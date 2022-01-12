<template>
    <Link :href="route(order.route, order.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="showicon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Truck.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,icon},
        props: {
            order: Object,
            showicon: {type: Boolean , default: false}
        },
    }
</script>