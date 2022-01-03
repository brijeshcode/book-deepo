<template>
    <app-layout title="Supplier Orders">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Orders
            </h2>
        </template>
        <template #breadcrum>
            <bread-simple :items="[ { route: 'suppliers'}, {route: 'supplierOrder', name:'Orders'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <Add-link createRoute="supplierOrder.create" title="Add new supplier order" withIcon />
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
                                    Contact Person
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Note
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="order in orders.data" :key="order.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <Edit-link :edit="{route: 'supplierOrder.edit', to:order.id }" >
                                    <div class="text-sm text-gray-500">{{ order.date }}</div>
                                  </Edit-link>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ order.supplier.name }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ order.contact_person }}</div>
                                    <div class="text-sm text-gray-500">{{ order.email }}</div>
                                    <div class="text-sm text-gray-500">{{ order.mobile }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ order.total_quantity }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ order.total_amount }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ order.note }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                                    <Edit-link :edit="{route: 'supplierOrder.edit', to:order.id }" showicon />

                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <Pagination :pageData="orders" pageof=" Suppliers Orders" />
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
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'


    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination
        },
        props:{
            orders: Object
        }
    })
</script>
