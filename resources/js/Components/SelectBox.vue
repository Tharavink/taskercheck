<template>
    <div class="relative">
        <select 
            class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
            v-model="value" @change="valueUpdated"
        >
            <option v-for="opt in options" :key="`opt_${opt.value}`" :value="opt.value">{{ opt.text }}</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value_prop', 'options_props'],
    data() {
        return {
            value: this.value_prop,
            options: this.options_props
        }
    },
    watch: {
        value_prop: function(val) {
            this.value = val;
        }
    },
    methods: {
        valueUpdated: function() {
            let self = this;
            self.$emit('valueUpdated', self.value);
        }
    }
}
</script>