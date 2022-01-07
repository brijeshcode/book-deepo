<template>
    <button v-if="static" type="button" @click="remove(index)" class="ml-4" v-if="index > 0">
      <span class="text-sm text-red-500 ">Delete</span>
    </button>
    <Link v-else :href="route(delete.route, delete.id)" class="text-indigo-600 hover:text-indigo-900">
        <span v-if="showicon"><icon /></span>
        <span v-else><slot></slot></span>
    </Link>
</template>

<script>
    import icon from '@/Shared/Components/Icons/svg/Trash.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default{
        components:{Link,icon},
        props: {
            delete: Object,
            showicon: {type: Boolean , default: false},
            static: {type: Boolean , default: true}
        },
    }
</script>