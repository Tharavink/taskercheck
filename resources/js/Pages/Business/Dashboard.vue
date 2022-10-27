<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Business Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                        <div class="antialiased sans-serif">
                            <h1 class="py-4 mb-10 text-3xl border-b">Businesses</h1>

                            <data-table :headings_prop="headings" :rows_prop.sync="business_data" :selectedRows_prop.sync="selectedRows" :bulkActions_prop.sync="bulkActions" :filters_prop.sync="filters" @updateSelectedRows="updateSelectedRows" @rowUpdated="rowUpdated" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        props: ['business_index_route', 'business_statusses'],
        components: {
            AppLayout,
            Welcome,
            DataTable,
            SweetModal
        },
        data() {
            return {
                businesses: [],
                open: false,
                selectedRows: [],
                headings: [
                    {
                        'key': 'id',
                        'value': 'Business ID',
                        'hidden': true
                    },
                    {
                        'key': 'name',
                        'value': 'Name'
                    },
                    {
                        'key': 'contact',
                        'value': 'Contact'
                    },
                    {
                        'key': 'ssm_id',
                        'value': 'SSM'
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
                        options: this.business_statusses.map(status => { 
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
                        options: this.business_statusses.map(status => { 
                            return {
                                text: status.status, 
                                value: status.id
                            }
                        }),
                        value: null
                    }
                ]
            }
        },
        mounted() {
            this.fetchBusinesses();
        },
        watch: {
            params: _.debounce(function() {
                this.fetchBusinesses();
            }, 500),
            bulkActions: {
                handler: function(val) {
                    this.applyAction(val);
                },
                deep: true
            }
        },
        computed: {
            business_data: function() {
                let self = this;
                return this.businesses.map(business => {
                    return {
                        id: {
                            value: business.id,
                            display: business.id
                        },
                        name: {
                            value: business.name,
                            display: business.name
                        },
                        contact: {
                            value: business.contact,
                            display: business.contact
                        },
                        ssm_id: {
                            value: business.ssm_id,
                            display: business.ssm ? business.ssm.file_url : null,
                            cssClass: 'text-white text-center',
                            file: true
                        },
                        status_id: {
                            value: business.status_id,
                            display: business.status.status,
                            cssClass: business.status.cssClass + ' text-center',
                            dropdown: true,
                            options: self.business_statusses.map(status => { 
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
            fetchBusinesses: function() {
                let self = this;
                axios.get(this.business_index_route, {
                    params: this.params
                })
                    .then(response => {
                        self.businesses = response.data
                    });
            },
            rowUpdated: function(val) {
                let business = Object.fromEntries(Object.entries(val).map(([ key, obj ]) => [ key, obj.value ]));
                this.updateBusiness(business);
            },
            applyAction: function(actions) {
                let businesses = this.businesses.filter(business => this.selectedRows.includes(business.id));
                let self = this;
                businesses.forEach(business => {
                    actions.forEach(action => {
                        if (action.value) {
                            business[action.name] = action.value
                        }
                    });
                    self.updateBusiness(business);
                });
            },
            updateBusiness: function(business) {
                let self = this;
                axios.put(this.business_index_route + '/' + business.id, { business })
                    .then(response => {
                        self.fetchBusinesses();
                    })
                    .catch(error => {
                        if (error.response.data.message) {
                            self.fetchBusinesses();
                        }
                    })
            },
            updateSelectedRows: function(selectedRows) {
                this.selectedRows = selectedRows;
            }
        }
    }
</script>