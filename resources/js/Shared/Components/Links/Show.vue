<template>
    <Link :href="route(show.route, show.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="showicon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Eye.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,icon},
        props: {
            show: Object,
            showicon: {type: Boolean , default: false}
        },
    }
</script>