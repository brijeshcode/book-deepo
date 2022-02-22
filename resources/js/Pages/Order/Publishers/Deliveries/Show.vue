<template>
    <app-layout title="Publisher Order Deliveries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publisher Order Deliveries
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'publishers.index'}, {route: 'publisher.order.index', name: 'Order'}, { route:'publisher.delivery.index' ,name:'Deliveries'} , {name: 'Show'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <!-- Introduction section -->
                <div class="flex flex-row w-full justify-between border-b">
                    <div class="flex-col px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">Delivery Order #: {{ delivery.order.id }}</p>
                        <p class="text-lg font-bold text-gray-600">{{ delivery.publisher.name }}</p>
                        <!-- <p class="text-gray-500">{{ delivery.publisher.email }}</p>
                        <p class="text-gray-500">{{ delivery.publisher.mobile }}</p> -->
                        <p class="text-gray-500 mb-4">Created: {{ delivery.date }}</p>
                    </div>
                    <div class="flex-col text-right px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">School Order #: {{ delivery.school_order_id }}</p>
                        <p class="text-lg font-bold text-gray-600">{{ delivery.school.name }}</p>
                    </div>
                </div>

                <div class="text-xl uppercase px-4 mt-4">
                        Delivery Items
                    <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                </div>

                <div class="w-full p-4 mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount %</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase">{{ delivery.quantity }}</th>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal text-gray-900 uppercase">{{ delivery.total_amount }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr class=" border-b" v-for="(item, index) in delivery.items">
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
                                    <td class="px-6">{{ item.quantity }}</td>
                                    <td class="px-6">{{ item.unit_price }}</td>
                                    <td class="px-6">{{ item.price }}</td>
                                    <td class="px-6">{{ item.discount_percent }}</td>
                                    <td class="px-6">{{ item.price_total }}</td>
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
        props: ['delivery']
    })
</script>