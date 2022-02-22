<template>
    <app-layout title="Publisher Order Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order Details
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ {route: 'publisher.order.index'} ,  {route: 'publisher.order.index', name:'Orders'}, { name:'Details'} ]" />
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
                        <p class="text-lg font-bold text-gray-800">Order #: {{ order.id }}</p>
                        <p class="text-lg font-bold text-gray-800">{{ order.publisher.name }}</p>
                        <p class="text-gray-500">{{ order.publisher.email }}</p>
                        <p class="text-gray-500">{{ order.publisher.mobile }}</p>
                    </div>
                </div>

                <div class="flex flex-row border-b mb-4">
                    <div class="flex-col p-4 w-1/3 border-r">
                        <h2 class="uppercase font-semibold mb-2" >School Address</h2>
                        <p class="">{{ order.schoolOrder.school.name }}</p>
                        <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.address }}</p>
                        <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.city }}, {{ order.schoolOrder.school.state }}</p>
                        <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.pincode }}</p>
                    </div>

                    <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" >Deliver To</h2>
                                <p class="">{{ order.schoolOrder.school.warehouse.name }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.warehouse.address }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.warehouse.city }}, {{ order.schoolOrder.school.warehouse.state }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.warehouse.pincode }}</p>
                            </div>
                            <div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.warehouse.email }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.school.warehouse.mobile }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" >School Order </h2>
                                <p class="">Order #: {{ order.schoolOrder.id }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.date  }}</p>
                                <p class="text-gray-500 text-sm">{{ order.schoolOrder.status }}</p>
                            </div>
                            <div>
                                <!-- <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.email }}</p>
                                <p class="text-gray-500 text-sm">{{ order.school.warehouse.mobile }}</p> -->
                            </div>
                        </div>
                    </div>

                </div>

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

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                </tr>
                            </tfoot>
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

                                        </div>

                                    </td>
                                    <td class="px-6">{{ item.book.publisher.name }}</td>
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'

    export default defineComponent({
        components: { AppLayout, BreadSimple },
        props: ['order']

    })
</script>