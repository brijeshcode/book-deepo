<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order Details
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[  { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} , { name:'Detail'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="school.order.create" title="Add new school order" withIcon />
            </div>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <!-- Introduction section -->
                <div class="flex flex-row w-full justify-between border-b">
                    <div class="flex-col px-4 py-2">
                        <p class="text-gray-500 mb-4">Created: {{ order.date }}</p>
                        <p class="text-gray-700 text-sm uppercase font-bold">
                            Status<br/>
                            <span class="text-green-600 text-xl ">{{ order.status }}</span>
                        </p>
                    </div>
                    <div class="flex-col text-right px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">{{ order.school.name }}</p>
                        <p class="text-gray-500">{{ order.school.contact_person }}</p>
                        <p class="text-gray-500">{{ order.school.email }}</p>
                        <p class="text-gray-500">{{ order.school.mobile }}</p>
                    </div>
                </div>

                <div class="flex flex-row border-b mb-4">
                    <div class="flex-col p-4 w-1/3 border-r">
                        <h2 class="uppercase font-semibold mb-2" >School Address</h2>
                        <p class="text-gray-500 text-sm">{{ order.school.address }}</p>
                        <p class="text-gray-500 text-sm">{{ order.school.city }}, {{ order.school.state }}</p>
                        <p class="text-gray-500 text-sm">{{ order.school.pincode }}</p>
                    </div>
                    <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" >Deliver To</h2>
                                <p class="">{{ order.school.warehouse.name }}</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.address }}</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.city }}, {{ order.school.warehouse.state }}</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.pincode }}</p>
                            </div>
                            <div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.email }}</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.mobile }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col p-4">
                        <h2 class="uppercase font-semibold mb-2" >Order By</h2>
                        <p class="text-gray-500 text-sm">Manual</p>

                    </div>
                </div>

                <!-- Order Item details section -->
                <div class="text-xl uppercase px-4 mt-4">
                    Order Items
                    <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                </div>

                <div class="w-full p-4 mb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class=" border-b" v-for="(item, index) in order.items">
                                <td class="px-6 py-2">
                                    <div class="flex ">
                                        <div class="left ">
                                            <div class="text-gray-900 text-lg">{{ item.book.name }}</div>
                                            <div class="text-gray-500">
                                                <span class="font-bold text-sm text-gray-700">Class: </span> {{ item.book.class }}
                                            </div>
                                            <div class="text-gray-500">
                                                <span class="font-bold text-sm text-gray-700">Subject: </span> {{ item.book.subject }}
                                            </div>
                                        </div>
                                        <div class="right pl-4">
                                            <div class="text-gray-900 text-lg">&nbsp;</div>
                                            <div class="text-gray-500">
                                                <span class="font-bold text-sm text-gray-700">Publisher: </span> {{ item.book.publisher.name }}
                                            </div>
                                            <div class="text-gray-500" v-if="item.supplier">
                                                <span class="font-bold text-sm text-gray-700">Supplier: </span> {{ item.supplier.name }}
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td class="px-6">{{ item.order_to }}</td>
                                <td class="px-6">{{ item.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
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
    import GroupInput from '@/Shared/Components/Form/Simple/InputGroup'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    // import BookList from '@/Pages/Order/School/BookList.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'
    import AddLink from '@/Shared/Components/Links/Add.vue'


    export default defineComponent({
        components: {
            EditLink,
            Link,
            JetInputError,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple,
            GroupInput,
            AddLink
            // BookList
        },
        props: ['order'],
        data: () => ({
            edit: false,
            books: []
        }),
        created(){

        },
        methods:{}
    })
</script>