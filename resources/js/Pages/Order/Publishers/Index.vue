<template>
    <app-layout title="Publisher Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publisher Order
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Orders'} ]" />
        </template>
        <template #actions>
            <div class="flex">

              <span @click="toggleFilter" class="p-2">
                <FilterIcon class=" cursor-pointer text-gray-500 hover:text-gray-800" />
              </span>
            </div>
        </template>

        <div v-if="showFilter" class="p-4 transition ease-in bg-white shadow rounded w-full border-red-100 my-4">

          <div class="p-4  grid  grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-4">
              <div class="filter">
                <jet-label for="from_date" value="From date" />
                <jet-input id="from_date" type="date" class="mt-1 block w-full" v-model="filter.from_date" autocomplete="from_date" />
              </div>
              <div class="filter">
                <jet-label for="to_date" value="To date" />
                <jet-input id="to_date" type="date" class="mt-1 block w-full" v-model="filter.to_date" autocomplete="to_date" />
              </div>
            <div class="filter">
              <jet-label for="quantity" required value="Order quantity" />
              <jet-input id="quantity" type="number" class="mt-1 block w-full" v-model="filter.quantity" autocomplete="quantity" />
            </div>
            <div class="filter">
              <jet-label for="amount" required value="Order amount" />
              <jet-input id="amount" type="number" class="mt-1 block w-full" v-model="filter.amount" autocomplete="amount" />
            </div>
            <!-- <div class="filter">
              <jet-label for="status" required value="Order Status" />
              <select id="status" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.status"
                  >
                  <option value="Requested">Requested</option>
                  <option value="Partial">Partial</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                  </select>
            </div> -->
            <div class="filter">
              <jet-label for="publisher_id" required value="Publisher" />
                  <select id="publisher_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.publisher_id"
                  >
                      <option v-for="publisher in publishers" :value="publisher.id">{{ publisher.name }}</option>
                  </select>
            </div>

          </div>

          <div>

          <div class="p-4">
            <jet-button @click="filterData"  >Filter</jet-button>
          </div>

          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col">
              <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="order in orders.data" :key="order.id">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Show-link class="p-1" :show="{route: 'supplier.order.show', id:order.id }" >
                              <div class="text-sm text-gray-500">{{ order.date }}</div>
                            </Show-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ order.publisher.name }}</div>
                            <div class="text-sm text-gray-500">Order: #{{ order.id }}</div>
                          </td>

                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ order.school_order.school.name }}</div>
                            <div class="text-sm text-gray-500">Order: #{{ order.school_order_id }}</div>
                          </td>

                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ order.quantity }}</div>
                          </td>

                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ order.due }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ order.paid }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ order.note }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <Show-link class="p-1" :show="{route: 'publisher.order.show', id:order.id }" showicon />
                            <span :title="order.order_recived_confirmation ? 'Order Recived Confirm By Supplier' : 'Order Revice not Confirma Not Recived'" class="p-1" :class="order.order_recived_confirmation ? 'text-green-500': 'text-gray-500'"> <SeenIcon /></span>
                            <!-- <deliver-link :order="{route: 'publisher.order.delivery', id:order.id }" title="Update delivery" showicon /> -->

                             <simple-link v-if=" order.due > 0" class="p-1" :link="{route: 'publisher.payments.create', id:order.id }" ><pay-icon /></simple-link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="orders" pageof=" Publishers Orders" />
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
    import Search from '@/Shared/Components/Filters/Search.vue'
    import SeenIcon from '@/Shared/Components/Icons/svg/Doubletick.vue'

    import { Inertia } from '@inertiajs/inertia'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import SimpleLink from '@/Shared/Components/Links/Simple.vue'
    import payIcon from '@/Shared/Components/Icons/svg/Paypal.vue'

    export default defineComponent({

        components: {
            AppLayout,BreadSimple,Search,AddLink,
            DeliverLink,Pagination,ShowLink,
            FilterIcon,JetLabel,JetInput,JetButton,
            SeenIcon,SimpleLink,payIcon
        },
        props:{ orders: Object , publishers: Object},
        data: () => ({
            showFilter: false,
            filter:{
              from_date: null,
              to_date: null,
              quantity: null,
              amount: null,
              status: null,
              publisher_id: null,
              filter: 1
            }
        }),
        methods:{
          toggleFilter(){
            this.showFilter   = !this.showFilter;
          },
          filterData(){
            Inertia.get(route('publisher.order.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
