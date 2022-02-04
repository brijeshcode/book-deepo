<template>
    <Link :href="route(link.route, link.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="icon"><print /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import print from '@/Shared/Components/Icons/svg/Print.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,print},
        props: {
            link: Object,
            icon: {type: Boolean , default: false}
        },
    }
</script>