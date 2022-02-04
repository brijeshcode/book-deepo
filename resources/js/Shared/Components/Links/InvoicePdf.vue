<template>
    <Link :href="route(link.route, link.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="icon"><doc /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import doc from '@/Shared/Components/Icons/svg/Doc.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,doc},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>