<template>
    <div class="py-6 mx-auto">
        <div v-show="selectedRows.length" class="fixed top-0 left-0 right-0 z-40 w-full bg-teal-200 shadow">
            <div class="container px-4 py-4 mx-auto">
                <div class="flex md:items-center">
                    <div class="flex-shrink-0 mr-4">
                        <svg class="w-8 h-8 text-teal-600"  viewBox="0 0 20 20" fill="currentColor">  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    </div>
                    <div v-html="selectedRows.length + ' rows are selected'" class="text-lg text-teal-800"></div>
                </div>
            </div>
        </div>

        <div v-if="selectedRows.length > 0 && bulkActions && bulkActions.length > 0" class="flex items-center justify-between mb-4">
            <div class="flex-1 pb-3 pr-4 mb-3 border-b">
                <div class="flex flex-row flex-wrap">
                    <label class="pr-5">Bulk Actions</label>
                    
                    <div v-for="(action, action_idx) in bulkActions" :key="`action_${action_idx}`" class="relative pr-2 md:w-1/5">
                        <div v-if="action.type == 'select'" class="relative">
                            <select 
                                class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" 
                                v-model="action.value"
                            >
                                <option :value="null">{{ action.placeholder }}</option>
                                <option v-for="opt in action.options" :key="`opt_${opt.value}`" :value="opt.value">{{ opt.text }}</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <button 
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray"
                        @click="emptySelected()"
                    >
                        <font-awesome-icon :icon="['fas', 'times']" />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            <div class="flex-1 pr-4">
                <div class="flex flex-row flex-wrap">
                    <div v-for="(filter, filter_idx) in filters" :key="`filter_${filter_idx}`" class="relative pr-2 md:w-1/5">
                        <div v-if="filter.type == 'search' || filter.type == 'text' || filter.type == 'email'">
                            <input :type="filter.type"
                                class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                                :placeholder="filter.placeholder" v-model="filter.value">
                            <div v-if="filter.type == 'search'" class="absolute top-0 left-0 inline-flex items-center p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </div>
                        </div>
                        <div v-else-if="filter.type == 'select'" class="relative">
                            <select 
                                class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" 
                                v-model="filter.value"
                            >
                                <option :value="null">{{ filter.placeholder }}</option>
                                <option v-for="opt in filter.options" :key="`opt_${opt.value}`" :value="opt.value">{{ opt.text }}</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex rounded-lg shadow">
                    <div class="relative">
                        <button @click.prevent="open = !open"
                            class="inline-flex items-center px-2 py-2 font-semibold text-gray-500 bg-white rounded-lg hover:text-blue-500 focus:outline-none focus:shadow-outline md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path
                                    d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                            </svg>
                            <span class="hidden md:block">Display</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>

                        <div v-show="open" 
                            class="absolute top-0 right-0 z-40 block w-40 py-1 mt-12 -mr-1 overflow-hidden bg-white rounded-lg shadow-lg">
                            <label
                                v-for="(heading, heading_idx) in headings" v-show="heading.key != 'id'" :key="heading.key"
                                class="flex items-center justify-start px-4 py-2 text-truncate hover:bg-gray-100">
                                <div class="mr-3 text-teal-600">
                                    <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading_idx)">
                                </div>
                                <div class="text-gray-700 select-none" v-html="heading.value"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-lg shadow">
            <table class="relative w-full whitespace-no-wrap bg-white border-collapse table-auto table-striped">
                <thead>
                    <tr class="text-left">
                        <th class="sticky top-0 px-3 py-2 bg-gray-100 border-b border-gray-200">
                            <label
                                class="inline-flex items-center justify-between px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200">
                                <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox()" :checked="allChecked">
                            </label>
                        </th>
                        <th v-for="heading in headings" :key="heading.key" class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200"
                            v-text="heading.value" v-show="!heading.hidden" :ref="heading.key" :class="{ [heading.key]: true }"></th>
                    </tr>
                </thead>
                <tbody v-if="rows.length > 0">
                    <data-table-row v-for="(row, rowIdx) in rows" :key="`tblRow_${rowIdx}`" :headings="headings" :row_prop="row" :selectedRows_prop.sync="selectedRows" @rowUpdated="rowUpdated" @buttonPressed="buttonPressed" />
                </tbody>
                <tbody v-else>
                    <tr>
                        <td :colspan="columns" class="p-3 text-center">
                            No data available for your search
                        </td>
                    </tr>
                </tbody>
            </table> 
        </div>
    </div>
</template>

<script>
    import DataTableRow from './../Components/DataTableRow'
    import JetLabel from './../Jetstream/Label'

    export default {
        props: ['headings_prop', 'rows_prop', 'selectedRows_prop', 'bulkActions_prop', 'filters_prop'],
        components: {
            DataTableRow,
            JetLabel
        },
        data() {
            return {
                headings: this.headings_prop,
                rows: this.rows_prop,
                open: false,
                selectedRows: this.selectedRows_prop,
                filters: this.filters_prop,
                bulkActions: this.bulkActions_prop
            }
        },
        computed: {
            columns: function() {
                return this.headings.filter(heading => !heading.hidden).length + 1
            },
            allChecked: function() {
                return this.selectedRows.length > 0 && this.selectedRows.length == this.rows.length
            }
        },
        watch: {
            headings_prop: function(val) {
                this.headings = val;
            },
            rows_prop: function(val) {
                this.rows = val;
                this.selectedRows = [];
            }
        },
        methods: {
            toggleColumn(idx) {
                this.$set(this.headings[idx], "hidden", !this.headings[idx].hidden);
            },
            selectAllCheckbox() {
                if (this.selectedRows.length >= this.rows.length) {
                    this.selectedRows = [];
                    this.$emit('updateSelectedRows', []);
                }
                else {
                    let selected = this.rows.map(row => row.id.value);
                    this.selectedRows = selected;
                    this.$emit('updateSelectedRows', selected);
                }
            },
            rowUpdated(val) {
                this.$emit('rowUpdated', val);
            },
            buttonPressed(key, val) {
                this.$emit('buttonPressed', key, val);
            },
            emptySelected: function() {
                this.selectedRows = [];
                this.$emit('updateSelectedRows', []);
            }
        }
    }
</script>