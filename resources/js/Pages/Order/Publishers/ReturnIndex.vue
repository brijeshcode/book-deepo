<template>
    <app-layout title="Publisher Retuns">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publisher Order Retuns
                <!-- <add-link createRoute="publisherOrder.create" isbutton >Generate</add-link> -->
            </h2>
        </template>
        <template #breadcrum>
            <bread-simple :items="[ { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Order'}, { route : 'publisher.order.returns.index', name: 'returns'} ]" />
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
              <jet-label for="publisher_order_id" required value="Publisher Order #" />
              <jet-input id="publisher_order_id" type="number" class="mt-1 block w-full" v-model="filter.publisher_order_id" autocomplete="publisher_order_id" />
            </div>

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
                                    Date
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Publisher                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Publisher order #
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
                                    <div class="text-sm text-gray-900">{{ returnData.publisher.name }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ returnData.publisher_order_id }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ returnData.quantity }}</div>
                                  </td>
                                  <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ returnData.unit_price }}</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ returnData.price }}</div>
                                  </td> -->
                                </tr>
                              </tbody>
                            </table>

                            <Pagination :pageData="returns" pageof=" Publishers Retuns" />
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

    import { Inertia } from '@inertiajs/inertia'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,DeliverLink,Pagination,
            FilterIcon,JetLabel,JetInput,JetButton
        },
        props:{
            returns: Object, publishers: Object
        },
        data: () => ({
            showFilter: false,
            filter:{
              date: null,
              quantity: null,
              publisher_order_id: null,
              publisher_id: null,
              filter: 1
            }
        }),
        methods:{
          toggleFilter(){
            this.showFilter   = !this.showFilter;
          },
          filterData(){
            Inertia.get(route('publisher.order.returns.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
