<template>
    <span @click="triggerCancel" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="icon"><print /></span>
        <span v-else><slot></slot></span>
    </span>
</template>

<script>
    import print from '@/Shared/Components/Icons/svg/Cancel.vue'
    import { Inertia } from '@inertiajs/inertia'
    export default{
        components:{print},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
        methods:{
            triggerCancel(){
                if (confirm('Are you sure you want to cancel This sale')) {
                    this.$inertia.post(route(this.link.route, this.link.id));
                }
            }
        }
    }
</script>