<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Service Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                        <div class="antialiased sans-serif">
                            <h1 class="py-4 mb-10 text-3xl border-b">Services</h1>
                            
                            <create-service :service_index_route="service_index_route" @addService="addService" />
                            <data-table :headings_prop="headings" :rows_prop.sync="services_data" :selectedRows_prop.sync="selectedRows" :bulkActions_prop.sync="bulkActions" :filters_prop.sync="filters" @updateSelectedRows="updateSelectedRows" @rowUpdated="rowUpdated" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import DataTable from './../../Components/DataTable'
    import CreateService from './CreateService'

    import _ from "lodash"

    export default {
        props: ['service_index_route', 'service_statusses'],
        components: {
            AppLayout,
            DataTable,
            CreateService
        },
        data() {
            return {
                services: [],
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
                        options: this.service_statusses.map(status => { 
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
                        options: this.service_statusses.map(status => { 
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
            this.fetchServices();
        },
        watch: {
            params: _.debounce(function() {
                this.fetchServices();
            }, 500),
            bulkActions: {
                handler: function(val) {
                    this.applyAction(val);
                },
                deep: true
            }
        },
        computed: {
            services_data: function() {
                let self = this;
                return this.services.map(service => {
                    return {
                        id: {
                            value: service.id,
                            display: service.id
                        },
                        name: {
                            value: service.name,
                            display: service.name,
                            editable: true
                        },
                        status_id: {
                            value: service.status_id,
                            display: service.status.status,
                            cssClass: service.status.cssClass + ' text-center',
                            dropdown: true,
                            options: self.service_statusses.map(status => { 
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
            fetchServices: function() {
                let self = this;
                axios.get(this.service_index_route, {
                    params: this.params
                })
                    .then(response => {
                        self.services = response.data
                    });
            },
            rowUpdated: function(val) {
                let service = Object.fromEntries(Object.entries(val).map(([ key, obj ]) => [ key, obj.value ]));
                this.updateService(service);
            },
            applyAction: function(actions) {
                let services = this.services.filter(service => this.selectedRows.includes(service.id));
                let self = this;
                services.forEach(service => {
                    actions.forEach(action => {
                        if (action.value) {
                            service[action.name] = action.value
                        }
                    });
                    self.updateService(service);
                });
            },
            updateService: function(service) {
                let self = this;
                axios.put(this.service_index_route + '/' + service.id, { service })
                    .then(response => {
                        let idx = self.services.findIndex(service => service.id == response.data.service.id);
                        if (idx > -1) {
                            self.$set(self.services, idx, response.data.service);
                        }
                        else {
                            self.fetchServices();
                        }
                    })
                    .catch(error => {
                        if (error.response.data.message) {
                            self.fetchServices();
                        }
                    })
            },
            updateSelectedRows: function(selectedRows) {
                this.selectedRows = selectedRows;
            },
            addService: function(service) {
                this.services.push(service);
            }
        }
    }
</script>
