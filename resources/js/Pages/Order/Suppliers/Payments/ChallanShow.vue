<template>
    <app-layout title="Suppliers Challan Payment">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suppliers Challan Payment <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
             <bread-simple :items="[  { route: 'suppliers'}, {name:'Challan'} , { name:'payment'} ]" />

        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <div class="flex">
                    <div class="flex-1">
                        <ul>
                            <li>Supplier: {{ challan.supplier.name }}</li>
                            <li>School Order #: {{ challan.school_order_id }}</li>
                            <li>School Order Date: {{ challan.school_order.date }}</li>
                            <li>Challan #: {{ challan.challan_no }}</li>
                            <li>Challan Amount: {{ challan.amount }}</li>
                            <li>Paid: {{ challan.payment_status }}</li>
                        </ul>
                    </div>
                    <div class="flex-1">
                        <img v-if="challan.path" :src="challan.path" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    // import BookList from '@/Pages/Order/Suppliers/BookList.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            Link,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple
            // BookList
        },
        props: ['challan'],
        data: () => ({
            edit: false,
            books: []
        }),



    })
</script>