<template>
    <app-layout title="Supplier Returns">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Order Returns
                <!-- <add-link createRoute="supplier.order.create" isbutton >Generate</add-link> -->
            </h2>
        </template>
        <template #breadcrum>
            <bread-simple :items="[ { route: 'suppliers'}, {route: 'supplier.order.index', name: 'Order'}, {name:'Returns'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <!-- <Add-link createRoute="supplier.order.create" title="Add new supplier order" withIcon /> -->
            </div>
        </template>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                            <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Supplier
s                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    School
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    School order #
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                  </th>
                                  <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit Price
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                  </th> -->
                                </tr>

                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="returnData in returns.data" :key="returnData.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ returnData.date }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ returnData.supplier.name }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <show-link :show="{route: 'school.order.show', id:returnData.order.school_order_id }" >
                                      <div class="text-sm text-gray-900">{{ returnData.order.school.name }}</div>
                                    </show-link>
                                      <!-- <div class="text-sm text-gray-900">{{ returnData.order.school.name }}</div> -->
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <show-link :show="{route: 'school.order.show', id:returnData.order.school_order_id }" >
                                      <div class="text-sm text-gray-900">{{ returnData.order.school_order_id }}</div>
                                  </show-link>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ returnData.quantity }}</div>
                                  </td>

                                </tr>
                              </tbody>
                            </table>

                            <Pagination :pageData="returns" pageof=" Suppliers Returns" />
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import AddLink from '@/Shared/Components/Links/Add.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import DeliverLink from '@/Shared/Components/Links/Delivery.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'


    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination, ShowLink
        },
        props:{
            returns: Object
        }
    })
</script>
