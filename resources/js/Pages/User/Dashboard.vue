<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                User Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                        <div class="antialiased sans-serif">
                            <h1 class="py-4 mb-10 text-3xl border-b">Users</h1>

                            <data-table :headings_prop="headings" :rows_prop.sync="user_data" :selectedRows_prop.sync="selectedRows" :bulkActions_prop.sync="bulkActions" :filters_prop.sync="filters" @updateSelectedRows="updateSelectedRows" @rowUpdated="rowUpdated" @buttonPressed="buttonPressed" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <sweet-modal v-if="selectedUser" ref="verificationModal" title="Verify User Picture and IC" width="60%">
            <div class="flex items-center justify-center w-full p-4">
                <label class="text-xl text-center">{{ selectedUser.name }}</label>
            </div>

            <div v-if="selectedUser.profile_pic && selectedUser.ic" class="flex flex-row items-center justify-center w-100">
                <div class="flex flex-col items-center justify-center w-1/2 h-64">
                    <label class="text-xl text-center">Profile Picture</label>
                    <img :src="selectedUser.profile_pic.file_url" class="object-contain w-full h-full" alt="Profile Picture">
                </div>
                <div class="flex flex-col items-center justify-center w-1/2 h-64">
                    <label class="text-xl text-center">IC Image</label>
                    <img :src="selectedUser.ic.file_url" class="object-contain w-full h-full" alt="IC Image">
                </div>
            </div>
            <div v-else class="w-100">
                <label class="text-xl text-center w-100">Not enough information to verify user</label>
            </div>

            <button 
                slot="button"
                class="inline-flex items-center px-4 py-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green"
                @click="confirmUser()"
            >
                Confirm User
            </button>
        </sweet-modal>
    </app-layout>
</template>

<style>
    .sweet-action-close {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
</style>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import Welcome from './../../Jetstream/Welcome'
    import DataTable from './../../Components/DataTable'

    import { SweetModal } from 'sweet-modal-vue'

    import _ from "lodash"

    export default {
        props: ['user_index_route', 'user_statusses'],
        components: {
            AppLayout,
            Welcome,
            DataTable,
            SweetModal
        },
        data() {
            return {
                users: [],
                selectedUser: {},
                open: false,
                selectedRows: [],
                headings: [
                    {
                        'key': 'id',
                        'value': 'User ID',
                        'hidden': true
                    },
                    {
                        'key': 'name',
                        'value': 'Name'
                    },
                    {
                        'key': 'email',
                        'value': 'Email'
                    },
                    {
                        'key': 'ic_id',
                        'value': 'IC'
                    },
                    {
                        'key': 'status_id',
                        'value': 'Status'
                    }
                ],
                bulkActions: [
                    {
                        type: 'select',
                        label: 'Change Status',
                        placeholder: 'Choose Status...',
                        name: 'status_id',
                        options: this.user_statusses.map(status => { 
                            return {
                                text: status.status, 
                                value: status.id
                            }
                        }),
                        value: null
                    }
                ],
                filters: [
                    {
                        type: 'search',
                        label: 'Keyword',
                        placeholder: 'Search...',
                        name: 'keyword',
                        value: null
                    },
                    {
                        type: 'select',
                        label: 'Status',
                        placeholder: 'Choose Status...',
                        name: 'status_id',
                        options: this.user_statusses.map(status => { 
                            return {
                                text: status.status, 
                                value: status.id
                            }
                        }),
                        value: null
                    },
                    {
                        type: 'select',
                        label: 'User Type',
                        placeholder: 'Choose User Type...',
                        name: 'has_business',
                        options: [
                            {
                                text: 'User',
                                value: 0
                            },
                            {
                                text: 'Servicer',
                                value: 1
                            }
                        ],
                        value: null
                    }
                ]
            }
        },
        mounted() {
            this.fetchUsers();
        },
        watch: {
            params: _.debounce(function() {
                this.fetchUsers();
            }, 500),
            bulkActions: {
                handler: function(val) {
                    this.applyAction(val);
                },
                deep: true
            }
        },
        computed: {
            user_data: function() {
                let self = this;
                return this.users.map(user => {
                    return {
                        id: {
                            value: user.id,
                            display: user.id
                        },
                        name: {
                            value: user.name,
                            display: user.name
                        },
                        email: {
                            value: user.email,
                            display: user.email
                        },
                        ic_id: {
                            value: user.ic_id,
                            display: user.profile_pic_id,
                            cssClass: 'bg-indigo-700 text-white text-center',
                            button: true
                        },
                        status_id: {
                            value: user.status_id,
                            display: user.status.status,
                            cssClass: user.status.cssClass + ' text-center',
                            dropdown: true,
                            options: self.user_statusses.map(status => { 
                                return {
                                    text: status.status, 
                                    value: status.id
                                }
                            })
                        }
                    }
                });
            },
            params: function() {
                let obj= {};
                this.filters.forEach(filter => {
                    obj[filter.name] = filter.value;
                });
                return obj;
            }
        },
        methods: {
            fetchUsers: function() {
                let self = this;
                axios.get(this.user_index_route, {
                    params: this.params
                })
                    .then(response => {
                        self.users = response.data
                    });
            },
            rowUpdated: function(val) {
                let user = Object.fromEntries(Object.entries(val).map(([ key, obj ]) => [ key, obj.value ]));
                this.updateUser(user);
            },
            buttonPressed: function(key, val) {
                if (key == 'ic_id') {
                    let user = this.users.find(user => user.id == val.id.value)
                    this.$set(this, 'selectedUser', user)
                    this.$refs.verificationModal.open()
                }
            },
            applyAction: function(actions) {
                let users = this.users.filter(user => this.selectedRows.includes(user.id));
                let self = this;
                users.forEach(user => {
                    actions.forEach(action => {
                        if (action.value) {
                            user[action.name] = action.value
                        }
                    });
                    self.updateUser(user);
                });
            },
            updateUser: function(user) {
                let self = this;
                axios.put(this.user_index_route + '/' + user.id, { user })
                    .then(response => {
                        self.fetchUsers();
                    })
                    .catch(error => {
                        if (error.response.data.message) {
                            self.fetchUsers();
                        }
                    })
            },
            updateSelectedRows: function(selectedRows) {
                this.selectedRows = selectedRows;
            },
            confirmUser: function() {
                this.updateUser({ ...this.selectedUser, status_id: 2 })
                this.$refs.verificationModal.close()
                this.selectedUser = {}
            }
        }
    }
</script>
