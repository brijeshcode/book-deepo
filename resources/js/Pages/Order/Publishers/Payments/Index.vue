<template>
    <app-layout title="Publisher Payments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publisher Payments
                <!-- <add-link createRoute="publisher.order.create" isbutton >Generate</add-link> -->
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Orders'}, {name: 'Payments'} ]" />
        </template>
        <template #actions>
            <div class="flex">
              <!-- <Add-link createRoute="publisher.order.create" title="Add new publisher order" withIcon /> -->
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
                            School Order #
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Publisher</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Challan #
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Note
                          </th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="challan in challans.data" :key="challan.id">
                          <td class="px-6 py-4 whitespace-nowrap">
                              <div class="text-sm text-gray-500">{{ challan.school_order_id }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                              <div class="text-sm text-gray-500">{{ challan.date }}</div>
                          </td>

                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ challan.publisher.name }}</div>
                            <div class="text-sm text-gray-500">{{ challan.email }}</div>
                            <div class="text-sm text-gray-500">{{ challan.mobile }}</div>
                          </td>

                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ challan.challan_no }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ challan.amount }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm uppercase text-gray-500">{{ challan.payment_status }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ challan.note }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <!-- <Show-link class="p-1" :show="{route: 'publisher.challan.show', id:challan.id }" showicon /> -->
                            <SimpleLink v-if="challan.payment_status != 'paid' " class="p-1" :link="{route: 'publisher.payments.challan.create', id:challan.id }" >
                              <pay />
                            </SimpleLink>

                            <!-- <deliver-link :challan="{route: 'publisher.challan.delivery', id:challan.id }" title="Update delivery" showicon /> -->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="challans" pageof=" Publishers Challans" />
                   </div>
                </div>
              </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import AddLink from '@/Shared/Components/Links/Add.vue'
    import DeliverLink from '@/Shared/Components/Links/Delivery.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import SimpleLink from '@/Shared/Components/Links/Simple.vue'
    import pay from '@/Shared/Components/Icons/svg/Paypal.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination,ShowLink, SimpleLink,
            pay
        },
        props:{ challans: Object }
    })
</script>
