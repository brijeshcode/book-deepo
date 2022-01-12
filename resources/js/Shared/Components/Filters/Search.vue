<template>
    <jet-input class="h-11 my-1" v-model="search" type="text" placeholder="Search..." autocomplete="search" />
</template>

<script>
    import debounce from 'lodash/debounce'
    import { Inertia } from '@inertiajs/inertia'
    import JetInput from '@/Jetstream/Input.vue'
    export default{
        components: {
            JetInput

        },
        props: {
                searchRoute: String
        },
        data: () => ({
            search: ''
        }),
        watch:{
          search: debounce( function(val){
                Inertia.get(route(this.searchRoute), {search: val },{
                        preserveState: true,
                        replace: true
                    });
                }, 200)
         }

    };
</script>
