<template>
    <app-layout title="Supplier Payments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Payments
                <!-- <add-link createRoute="supplier.order.create" isbutton >Generate</add-link> -->
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'suppliers'}, {route: 'supplier.order.index', name:'Orders'}, { route: 'supplier.payments.index', name: 'Payments'} ]" />
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
              <jet-label for="challan_no" value="Challan #" />
              <jet-input id="challan_no" type="text" class="mt-1 block w-full" v-model="filter.challan_no" autocomplete="challan_no" />
            </div>
            <div class="filter">
              <jet-label for="amount" value="Amount" />
              <jet-input id="amount" type="number" class="mt-1 block w-full" v-model="filter.amount" autocomplete="amount" />
            </div>
            <div class="filter">
              <jet-label for="payment_status" value="Payment Status" />
              <select id="payment_status" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.payment_status"
                  >
                  <option value="Due">Due</option>
                  <option value="Paid">Paid</option>
                  </select>
            </div>


            <div class="filter">
              <jet-label for="supplier_id" value="Suppliers" />
                  <select id="supplier_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.supplier_id"
                  >
                      <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                  </select>
            </div>

            <div class="filter">
              <jet-label for="note" value="Note" />
              <jet-input id="note" type="text" class="mt-1 block w-full" v-model="filter.note" autocomplete="note" />
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
                            Supplier</th>
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
                            <div class="text-sm text-gray-900">{{ challan.supplier.name }}</div>
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
                            <Show-link class="p-1" :show="{route: 'supplier.payments.challan.show', id:challan.id }" showicon />
                            <!-- <Show-link class="p-1" :show="{route: 'supplier.challan.show', id:challan.id }" showicon /> -->
                            <SimpleLink v-if="challan.payment_payment_status != 'paid' " class="p-1" :link="{route: 'supplier.payments.challan.create', id:challan.id }" >
                              <pay />
                            </SimpleLink>

                            <!-- <deliver-link :challan="{route: 'supplier.challan.delivery', id:challan.id }" title="Update delivery" showicon /> -->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="challans" pageof=" Suppliers Challans" />
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
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination,ShowLink, SimpleLink,
            FilterIcon,JetLabel,JetInput,JetButton,
            pay
        },
        props:{ challans: Object, suppliers: Object },
        data: () => ({
            showFilter: false,
            filter:{
              from_date: null,
              to_date: null,
              challan_no: null,
              amount: null,
              payment_status: null,
              note: null,
              supplier_id: null,
              filter: 1
            }
        }),
        created(){
        },
        methods:{
          toggleFilter(){
            this.showFilter   = !this.showFilter;
          },
          filterData(){
            Inertia.get(route('supplier.payments.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
