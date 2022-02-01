<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order
                <add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="school.order.create" isbutton >Generate</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} ]" />
        </template>
        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="school.order.create" title="Add new school order" withIcon />
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
            <div class="filter">
              <jet-label for="status" value="Order Status" />
              <select id="status" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.status"
                  >
                  <option value="Pending">Pending</option>
                  <option value="Partial">Partial</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                  </select>
            </div>

            <div class="filter">
              <jet-label for="school_id" value="School" />
                  <select id="school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                  v-model="filter.school_id"
                  >
                      <option v-for="school in schools" :value="school.id">{{ school.name }}</option>
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
                          <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                          </th> -->
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
                            <Edit-link :edit="{route: 'school.order.edit', to:order.id }" >
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
                          <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ order.amount }}</div>
                          </td> -->
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <!-- <div class="text-sm text-gray-500">{{ order.note }}</div> -->
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ order.status }}
                              </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <show-link class="p-1" :show="{route: 'school.order.show', id:order.id }" showicon />
                            <MailLink class="p-1" :link="{route: 'school.order.manual_email_notification', id:order.id }" showicon />

                              <deliver-link class="p-1" v-if="order.status != 'Completed' && $page.props.user.permissions.includes('edit school orders')" :order="{route: 'school.order.delivery', id:order.id }" title="Update delivery" showicon />

                              <return-link class="p-1" v-if="order.status != 'Pending' && $page.props.user.permissions.includes('edit school orders')"  :order="{route: 'school.order.return', id:order.id }" showicon />
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
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import AddLink from '@/Shared/Components/Links/Add.vue'
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'
    import DeliverLink from '@/Shared/Components/Links/Delivery.vue'
    import ReturnLink from '@/Shared/Components/Links/Return.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import MailLink from '@/Shared/Components/Links/OrderManualMail.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetButton from '@/Jetstream/Button.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination,DeliverLink,ReturnLink,ShowLink,MailLink, FilterIcon,JetLabel,JetInput,JetButton
        },
        props: ['orders', 'schools' ],

        data: () => ({
            showFilter: false,
            filter:{
              date: null,
              quantity: null,
              amount: null,
              status: null,
              school_id: null,
              filter: 1
            }
        }),

        methods:{
          toggleFilter(){
            this.showFilter   = !this.showFilter;
          },
          filterData(){
            Inertia.get(route('school.order.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
