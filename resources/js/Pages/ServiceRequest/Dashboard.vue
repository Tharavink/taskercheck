<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Service Request Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                        <div class="antialiased sans-serif">
                            <h1 class="py-4 mb-10 text-3xl border-b">Service Requests</h1>
                            <h3 class="py-2 text-3xl text-center">Total Pending Payable : RM {{ totalPayable.toFixed(2) }}</h3>

                            <data-table :headings_prop="headings" :rows_prop.sync="request_data" :selectedRows_prop.sync="selectedRows" :bulkActions_prop.sync="bulkActions" :filters_prop.sync="filters" @updateSelectedRows="updateSelectedRows" @rowUpdated="rowUpdated" @buttonPressed="buttonPressed" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <sweet-modal ref="requestModal" title="Service Provider Bank Account" width="60%">
            <div v-if="selectedRequest" class="flex flex-col items-center justify-center w-full p-4">
                <div v-if="selectedRequest.business.bank_account" class="flex flex-col items-center justify-center w-full">
                    <label class="text-xl text-center">{{ selectedRequest.business.bank_account.bank.name }}</label>
                    <label class="text-xl text-center">{{ selectedRequest.business.bank_account.acc_number }}</label>
                    <label class="text-xl text-center">{{ selectedRequest.business.bank_account.acc_name }}</label>
                </div>
                <div v-else class="flex flex-col items-center justify-center w-full">
                    <label class="text-xl text-center">
                        No bank account info available for this business.
                    </label>
                </div>
            </div>
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
    import DataTable from './../../Components/DataTable'

    import { SweetModal } from 'sweet-modal-vue'

    import _ from "lodash"

    export default {
        props: ['requests_index_route', 'requests_statusses', 'services'],
        components: {
            AppLayout,
            DataTable,
            SweetModal
        },
        data() {
            return {
                requests: [],
                open: false,
                selectedRows: [],
                selectedRequest: null,
                headings: [
                    {
                        'key': 'id',
                        'value': 'Request ID',
                        'hidden': true
                    },
                    {
                        'key': 'business_id',
                        'value': 'Provider'
                    },
                    {
                        'key': 'user_id',
                        'value': 'Requester'
                    },
                    {
                        'key': 'service_id',
                        'value': 'Service'
                    },
                    // {
                    //     'key': 'service_time',
                    //     'value': 'Time'
                    // },
                    {
                        'key': 'amount',
                        'value': 'Amount'
                    },
                    {
                        'key': 'payable',
                        'value': 'Payable'
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
                        options: this.requests_statusses.map(status => { 
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
                        placeholder: 'Search by Business Name...',
                        name: 'keyword',
                        value: null
                    },
                    {
                        type: 'select',
                        label: 'Service Type',
                        placeholder: 'Choose Service Type...',
                        name: 'service_id',
                        options: this.services.map(service => { 
                            return {
                                text: service.name, 
                                value: service.id
                            }
                        }),
                        value: null
                    },
                    {
                        type: 'select',
                        label: 'Status',
                        placeholder: 'Choose Status...',
                        name: 'status_id',
                        options: this.requests_statusses.map(status => { 
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
            this.fetchRequests();
        },
        watch: {
            params: _.debounce(function() {
                this.fetchRequests();
            }, 500),
            bulkActions: {
                handler: function(val) {
                    this.applyAction(val);
                },
                deep: true
            }
        },
        computed: {
            request_data: function() {
                let self = this;
                return this.requests.map(s_request => {
                    return {
                        id: {
                            value: s_request.id,
                            display: s_request.id
                        },
                        business_id: {
                            value: s_request.business_id,
                            display: s_request.business.name
                        },
                        user_id: {
                            value: s_request.user_id,
                            display: s_request.requester.name
                        },
                        service_id: {
                            value: s_request.service_id,
                            display: s_request.service.name
                        },
                        service_time: {
                            value: s_request.service_time,
                            display: s_request.service_time
                        },
                        amount: {
                            value: s_request.amount,
                            display: s_request.amount ? `RM ${s_request.amount.toFixed(2)}` : `-`
                        },
                        payable: {
                            value: s_request.amount * 0.90,
                            display: s_request.amount ? `RM ${(s_request.amount * 0.90).toFixed(2)}` : `-`,
                            buttonPayable: s_request.amount ? true : false
                        },
                        status_id: {
                            value: s_request.status_id,
                            display: s_request.status.status,
                            cssClass: s_request.status.cssClass + ' text-center',
                            dropdown: true,
                            options: self.requests_statusses.map(status => { 
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
            },
            totalPayable: function() {
                return this.requests.filter(req => [3, 4, 7].includes(req.status_id)).reduce((acc, req) => acc + (req.amount * 0.90) , 0.00)
            }
        },
        methods: {
            fetchRequests: function() {
                let self = this;
                axios.get(this.requests_index_route, {
                    params: this.params
                })
                    .then(response => {
                        self.requests = response.data
                    });
            },
            rowUpdated: function(val) {
                let s_request = Object.fromEntries(Object.entries(val).map(([ key, obj ]) => [ key, obj.value ]));
                this.updateRequest(s_request);
            },
            applyAction: function(actions) {
                let requests = this.requests.filter(s_request => this.selectedRows.includes(s_request.id));
                let self = this;
                requests.forEach(s_request => {
                    actions.forEach(action => {
                        if (action.value) {
                            s_request[action.name] = action.value
                        }
                    });
                    self.updateRequest(s_request);
                });
            },
            updateRequest: function(s_request) {
                let self = this;
                axios.put(this.requests_index_route + '/' + s_request.id, s_request)
                    .then(response => {
                        let idx = self.requests.findIndex(s_request => s_request.id == response.data.id);
                        if (idx > -1) {
                            self.$set(self.requests, idx, response.data);
                        }
                        else {
                            self.fetchRequests();
                        }
                    })
                    .catch(error => {
                        if (error.response.data.message) {
                            self.fetchRequests();
                        }
                    })
            },
            updateSelectedRows: function(selectedRows) {
                this.selectedRows = selectedRows;
            },
            buttonPressed: function(key, val) {
                if (key == 'payable') {
                    let request = this.requests.find(req => req.id == val.id.value)
                    console.log(request)
                    this.$set(this, 'selectedRequest', request)
                    this.$refs.requestModal.open()
                }
            }
        }
    }
</script>
