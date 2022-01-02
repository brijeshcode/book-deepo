<template>
    <Link :href="route(createRoute)" class="p-2 text-gray-700 hover:text-indigo-900" title="Add">
        <span v-if="withIcon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Plus.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,icon},
        props: {
            createRoute: String,
            url: String,
            withIcon: {type: Boolean , default: false}
        },
    }
</script>