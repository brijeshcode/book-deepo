<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order
                <add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="schoolOrder.create" isbutton >Generate</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools'}, {route: 'schoolOrder', name:'Orders'} ]" />
        </template>
        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="schoolOrder.create" title="Add new school order" withIcon />
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
                            #
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            School
                          </th>
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
                            Status
                          </th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="order in orders.data" :key="order.id">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ order.id }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'schoolOrder.edit', to:order.id }" >
                              <div class="text-sm text-gray-500">{{ order.date }}</div>
                            </Edit-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ order.school.name }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ order.school.name }}</div>
                            <div class="text-sm text-gray-500">{{ order.school.email }}</div>
                            <div class="text-sm text-gray-500">{{ order.school.mobile }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ order.quantity }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ order.total_amount }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <!-- <div class="text-sm text-gray-500">{{ order.note }}</div> -->
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ order.status }}
                              </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <show-link class="p-1" :show="{route: 'schoolOrder.show', id:order.id }" showicon />
                            <div v-if="($page.props.user.permissions.includes('edit school orders'))">

                              <deliver-link class="p-1" v-if="order.status != 'Completed'" :order="{route: 'school.order.delivery', id:order.id }" title="Update delivery" showicon />
                              <return-link class="p-1" v-if="order.status != 'Pending'"  :order="{route: 'school.order.return', id:order.id }" showicon />
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="orders" pageof=" Schools Orders" />
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
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'
    import DeliverLink from '@/Shared/Components/Links/Delivery.vue'
    import ReturnLink from '@/Shared/Components/Links/Return.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination,DeliverLink,ReturnLink,ShowLink
        },
        props:{
            orders: Object
        }
    })
</script>
