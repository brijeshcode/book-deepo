<template>
    <Link :href="route(link.route, link.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="showicon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Email.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,icon},
        props: {
            link: Object,
            showicon: {type: Boolean , default: false}
        },
    }
</script>