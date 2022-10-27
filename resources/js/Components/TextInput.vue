<template>
    <input class="rounded-md shadow-sm form-input" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
export default {
    props: ['value_prop', 'editable'],
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
    }
}
</script>