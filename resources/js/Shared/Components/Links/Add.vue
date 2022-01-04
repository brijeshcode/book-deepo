<template>
    <Link v-if="isbutton" :href="route(createRoute)" class="text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 shadow-lg shadow-indigo-500/50 dark:shadow-lg dark:shadow-indigo-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2" title="Add">
        <span v-if="withIcon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>

    <Link v-else :href="route(createRoute)" class="p-2 text-gray-700 hover:text-indigo-900" title="Add">
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
            withIcon: {type: Boolean , default: false},
            isbutton: {type: Boolean , default: false}
        },
    }
</script>