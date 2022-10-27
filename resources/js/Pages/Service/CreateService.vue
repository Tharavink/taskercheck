<template>
    <div class="py-2 mx-auto">
        <div class="flex items-center justify-between mb-4">
            <div class="flex-1 pb-3 pr-4 mb-3">
                <div class="flex flex-row flex-wrap items-center justify-center">
                    <label class="pr-5 text-xl">New Service</label>
                    
                    <div class="relative pr-2 md:w-1/5">
                        <input type="text" class="w-full py-2 pl-4 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                            placeholder="Type the service name..." v-model="service.name" />
                    </div>

                    <button 
                        class="inline-flex items-center px-4 py-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green"
                        :disabled="service.name == null || service.name == ''" @click="submit()"
                    >
                        <font-awesome-icon :icon="['fas', 'check']" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['service_index_route'],
    data() {
        return {
            service: {
                name: null
            }
        }
    },
    methods: {
        submit: function() {
            let self = this;
            axios.post(this.service_index_route, { service: this.service })
                .then(response => {
                    self.$set(self.service, 'name', null);
                    self.$emit('addService', response.data);
                });
        }
    }
}
</script>