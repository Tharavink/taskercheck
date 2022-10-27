<template>
    <tr>
        <td class="px-3 border-t border-gray-200 border-dashed">
            <label
                class="inline-flex items-center justify-between px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200">
                <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :value="row.id.value" v-model="selectedRows"
                        @click="getRowDetail(row.id.value)">
            </label>
        </td>
        <td v-for="heading in headings" :key="heading.key" v-show="!heading.hidden" :class="['border-t border-gray-200 border-dashed', row[heading.key].cssClass ? row[heading.key].cssClass : '']">
            <select-box v-if="row[heading.key].dropdown" :value_prop="row[heading.key].value" :options_props="row[heading.key].options" @valueUpdated="rowUpdated(heading.key, $event)" />
            <button 
                v-else-if="row[heading.key].button"
                :class="['inline-flex items-center px-4 py-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out', row.status_id.value == 1 && row[heading.key].value && row[heading.key].display ? ' bg-green-500 border border-transparent rounded-md hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green' : ' bg-gray-500 border border-transparent rounded-md focus:outline-none focus:border-gray-900 focus:shadow-outline-gray']"
                :disabled="!(row.status_id.value == 1 && row[heading.key].value && row[heading.key].display)" @click="buttonPressed(heading.key, $event)"
            >
                {{ row.status_id.value == 1 ? (row[heading.key].value && row[heading.key].display ? 'Compare IC and Picture' : 'Pending Document Upload') : 'Already Verified'}}
            </button>
            <button
                v-else-if="row[heading.key].buttonPayable"
                :class="['h-full w-full bg-indigo-600 py-3 text-white']"
                @click="buttonPressed(heading.key, $event)"
            >
                {{ row[heading.key].display }}
            </button>
            <div v-else-if="row[heading.key].file" class="w-full">
                <a v-if="row[heading.key].display" :href="row[heading.key].display" target="_blank" rel="noopener noreferrer" class="text-gray-700 underline">View File</a>
            </div>
            <text-span v-else class="flex items-center px-6 py-3 text-gray-700" :value_prop="row[heading.key].display" :editable="row[heading.key].editable" @valueUpdated="rowUpdated(heading.key, $event)" />
        </td>
    </tr>
</template>

<script>
import SelectBox from './SelectBox';
import TextSpan from './TextSpan';

export default {
    props: ['headings', 'row_prop', 'selectedRows_prop'],
    components: {
        SelectBox,
        TextSpan
    },
    data() {
        return {
            row: this.row_prop,
            selectedRows: this.selectedRows_prop
        }
    },
    watch: {
        row_prop: function(val) {
            this.row = val
        },
        selectedRows_prop: function(val) {
            this.selectedRows = val;
        }
    },
    methods: {
        getRowDetail(id) {
            let rows = this.selectedRows;
            if (rows.includes(id)) {
                let index = rows.indexOf(id);
                rows.splice(index, 1);
            } else {
                rows.push(id);
            }
            this.selectedRows = rows;
        },
        rowUpdated: function(key, payload) {
            let row = this.row;
            row[key].value = payload;

            let self = this;
            this.$nextTick(function() {
                this.$emit('rowUpdated', row);
            });
        },
        buttonPressed: function(key, payload) {
            let row = this.row;

            let self = this;
            this.$nextTick(function() {
                this.$emit('buttonPressed', key, row);
            });
        }
    }
}
</script>