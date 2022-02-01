<template>
    <app-layout title="Supplier Orders">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Orders
                <!-- <add-link createRoute="supplier.order.create" isbutton >Generate</add-link> -->
            </h2>
        </template>
        <template #breadcrum>
            <bread-simple :items="[ { route: 'suppliers'}, {route: 'supplier.order.index', name:'Orders'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <!-- <Add-link createRoute="supplier.order.index.create" title="Add new supplier order" withIcon /> -->
              <span @click="toggleFilter" class="p-2">
                <FilterIcon class=" cursor-pointer text-gray-500 hover:text-gray-800" />
              </span>
            </div>
        </template>

         <div v-if="showFilter" class="p-4 transition ease-in bg-white shadow rounded w-full border-red-100 my-4">

          <div class="p-4  grid  grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="filter">
              <jet-label for="date" value="Order date" />
              <jet-input id="date" type="date" class="mt-1 block w-full" v-model="filter.date" autocomplete="date" />
            </div>
            <div class="filter">
              <jet-label for="quantity" value="Order quantity" />
              <jet-input id="quantity" type="number" class="mt-1 block w-full" v-model="filter.quantity" autocomplete="quantity" />
            </div>
            <div class="filter">
              <jet-label for="amount" value="Order amount" />
              <jet-input id="amount" type="number" class="mt-1 block w-full" v-model="filter.amount" autocomplete="amount" />
            </div>
           <!--  <div class="filter">
              <jet-label for="status" value="Order Status" />
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
              <jet-label for="supplier_id" value="Suppliers" />
                  <select id="supplier_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.supplier_id"
                  >
                      <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
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
                                  <th>#</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Supplier
                                  </th>
                                  <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact Person
                                  </th> -->
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Note
                                  </th>
                                  <!-- <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th> -->
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="order in orders.data" :key="order.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                  {{ order.id }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <Edit-link :edit="{route: 'supplierOrder.edit', to:order.id }" >
                                    <div class="text-sm text-gray-500">{{ order.date }}</div>
                                  </Edit-link>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ order.supplier.name }}</div>
                                  </td>
                                  <!-- <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ order.contact_person }}</div>
                                    <div class="text-sm text-gray-500">{{ order.email }}</div>
                                    <div class="text-sm text-gray-500">{{ order.mobile }}</div>
                                  </td> -->
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ order.quantity }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ order.amount }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ order.note }}</div>
                                  </td>
                                  <!-- <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                                  <deliver-link :order="{route: 'supplier.order.delivery', id:order.id }" title="Update delivery" showicon />
                                  </td> -->
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
    import DeliverLink from '@/Shared/Components/Links/Delivery.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { Inertia } from '@inertiajs/inertia'


    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination,ShowLink,
            FilterIcon,JetLabel,JetInput,JetButton
        },
        props: ['orders', 'suppliers' ],

        data: () => ({
            showFilter: false,
            filter:{
              date: null,
              quantity: null,
              amount: null,
              status: null,
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
            Inertia.get(route('supplier.order.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
