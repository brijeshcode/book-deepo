<template>
    <app-layout title="Publisher Payments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publisher Payments
                <!-- <add-link createRoute="publisher.order.create" isbutton >Generate</add-link> -->
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'publishers.index'}, { route:'publisher.payments.index', name:'Payments'} ]" />
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
              <jet-label for="date" required value="Order date" />
              <jet-input id="date" type="date" class="mt-1 block w-full" v-model="filter.date" autocomplete="date" />
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
                            <Show-link class="p-1" :show="{route: 'publisher.payments.challan.show', id:challan.id }" showicon />

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
    import { Inertia } from '@inertiajs/inertia'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'
    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination,ShowLink, SimpleLink,
            FilterIcon,JetLabel,JetInput,JetButton,
            pay
        },
        props:{ challans: Object ,publishers: Object},
        data: () => ({
            showFilter: false,
            filter:{
              date: null,
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
            Inertia.get(route('publisher.payments.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
