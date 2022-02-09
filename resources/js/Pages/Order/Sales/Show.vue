<template>
    <app-layout title="Sales">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales Details
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ {route: 'sales.index'} , { name:'Details'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <!-- Introduction section -->
                <div class="flex flex-row w-full justify-between border-b">
                    <div class="flex-col px-4 py-2">
                        <p class="text-gray-500 mb-4">Created: {{ sale.formated_date }}</p>
                        <p class="text-gray-700 text-sm uppercase font-bold">
                            Status<br/>
                            <span class=" text-xl " :class="sale.status == 'cancel' ? 'text-red-600' : text-green-600">{{ sale.status }}</span>
                        </p>
                    </div>
                    <div class="flex-col text-right px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">#{{ sale.id }}</p>
                        <p class="text-lg font-bold text-gray-800">{{ sale.student_name }}</p>
                        <p class="text-gray-500">{{ sale.student_email }}</p>
                        <p class="text-gray-500">{{ sale.student_mobile }}</p>
                    </div>
                </div>

                <div class="flex flex-row border-b mb-4">
                    <div class="flex-col p-4 w-1/3 border-r">
                        <h2 class="uppercase font-semibold mb-2" >School Address</h2>
                        <p class="">{{ sale.school.name }}</p>
                        <p class="text-gray-500 text-sm">{{ sale.school.address }}</p>
                        <p class="text-gray-500 text-sm">{{ sale.school.city }}, {{ sale.school.state }}</p>
                        <p class="text-gray-500 text-sm">{{ sale.school.pincode }}</p>
                    </div>
                    <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" ></h2>
                                <p class="">{{ sale.school.warehouse.name }}</p>
                                <p class="text-gray-500 text-sm">{{ sale.school.warehouse.address }}</p>
                                <p class="text-gray-500 text-sm">{{ sale.school.warehouse.city }}, {{ sale.school.warehouse.state }}</p>
                                <p class="text-gray-500 text-sm">{{ sale.school.warehouse.pincode }}</p>
                            </div>
                            <div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ sale.school.warehouse.email }}</p>
                                <p class="text-gray-500 text-sm">{{ sale.school.warehouse.mobile }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col p-4">
                        <h2 class="uppercase font-semibold mb-2" >Order By</h2>
                        <p class="text-gray-500 text-sm">Operator name</p>

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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr v-if="sale.discount_percent > 0">
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">Discount %</th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ sale.discount_percent }}</th>
                                </tr>
                                <tr v-if="sale.discount_percent > 0">
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">Discount</th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ sale.discount_amount }}</th>
                                </tr>
                                <tr>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ sale.total_quantity }}</th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ sale.total_amount }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr class=" border-b" v-for="(item, index) in sale.items">
                                    <td class="px-6 py-2">
                                        <div class="flex ">
                                            <div class="left ">
                                                <div class="text-gray-900 text-lg">{{ item.book_name }}</div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Class: </span> {{ item.class }}
                                                </div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Subject: </span> {{ item.subject }}
                                                </div>
                                            </div>

                                        </div>

                                    </td>
                                    <td class="px-6">{{ item.book.publisher.name }}</td>
                                    <td class="px-6">{{ item.quantity }}</td>
                                    <td class="px-6">{{ item.cost }}</td>
                                    <td class="px-6">{{ item.cost * item.quantity }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>


                <div class="mb-4">
                    <print :link="{route:'sales.invoice.print', id:sale.id}" class="ml-4" >Print</print>
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import InputGroup from '@/Shared/Components/Form/Simple/InputGroup.vue'
    import { Inertia } from '@inertiajs/inertia'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'
    import print from '@/Shared/Components/Links/Print.vue'

    export default defineComponent({
        components: {
            JetInputError,
            print,
            RemoveIcon,
            AppLayout,
            JetLabel,
            JetButton,
            BreadSimple
        },
        props: ['sale'],
        data: () => ({
            edit: false,
            books: [],
            bundles: []
        }),
        created(){
        },
        methods:{}
    })
</script>