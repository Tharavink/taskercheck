<template>
    <div v-if="editing" class="flex flex-row items-center justify-items-start">
        <button v-if="editable" class="inline-flex items-center px-4 py-2 mr-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-gray" @click="saveEdited()">Save</button>
        <jet-input type="text" class="block w-full mt-1" v-model="value" />
    </div>
    <div v-else class="flex flex-row items-center justify-items-start">
        <button v-if="editable" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray" @click="setEditable(true)">Edit</button>
        <span class="flex items-center px-6 py-3 text-gray-700" v-text="value"></span>
    </div>
</template>

<script>
import JetInput from './../Jetstream/Input'
import JetButton from './../Jetstream/Button'

export default {
    props: ['value_prop', 'editable'],
    components: {
        JetInput,
        JetButton
    },
    data() {
        return {
            value: this.value_prop,
            editing: false
        }
    },
    watch: {
        value_prop: function(val) {
            this.editing = false;
            this.value = val;
        }
    },
    methods: {
        setEditable: function(bool) {
            this.editing = bool;
        },
        saveEdited: function() {
            this.setEditable(false);
            this.$emit('valueUpdated', this.value);
        }
    }
}
</script>