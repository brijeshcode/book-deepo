<template>
    <app-layout title="Sales">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales
                <add-link v-if="($page.props.user.permissions.includes('create sales'))" createRoute="sales.create" isbutton >Generate</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'sales.index'} ]" />
        </template>
        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create sales'))" createRoute="sales.create" title="Add new Sales" withIcon />
              <span @click="toggleFilter" class="p-2">
                <FilterIcon class=" cursor-pointer text-gray-500 hover:text-gray-800" />
              </span>
            </div>
        </template>

        <div v-if="showFilter" class="p-4 transition ease-in bg-white shadow rounded w-full border-red-100 my-4">

          <div class="p-4  grid  grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="filter">
              <jet-label for="date" value="Sales date" />
              <jet-input id="date" type="date" class="mt-1 block w-full" v-model="filter.date" autocomplete="date" />
            </div>
            <div class="filter">
              <jet-label for="student_name" value="Student Name" />
              <jet-input id="student_name" type="text" class="mt-1 block w-full" v-model="filter.student_name" autocomplete="student_name" />
            </div>
            <div class="filter">
              <jet-label for="student_email" value="Student Email" />
              <jet-input id="student_email" type="text" class="mt-1 block w-full" v-model="filter.student_email" autocomplete="student_email" />
            </div>
            <div class="filter">
              <jet-label for="student_mobile" value="Student Mobile" />
              <jet-input id="student_mobile" type="text" class="mt-1 block w-full" v-model="filter.student_mobile" autocomplete="student_mobile" />
            </div>
            <div class="filter">
              <jet-label for="quantity" value="Sales quantity" />
              <jet-input id="quantity" type="number" class="mt-1 block w-full" v-model="filter.quantity" autocomplete="quantity" />
            </div>
            <div class="filter">
              <jet-label for="amount" value="Sales amount" />
              <jet-input id="amount" type="number" class="mt-1 block w-full" v-model="filter.amount" autocomplete="amount" />
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
                            Order #
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            School
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Student name
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
                        <tr v-for="sale in sales.data" :key="sale.id">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'sales.edit', to:sale.id }" >
                              <div class="text-sm text-gray-500">{{ sale.id }}</div>
                            </Edit-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'sales.edit', to:sale.id }" >
                              <div class="text-sm text-gray-500">{{ sale.date }}</div>
                            </Edit-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ sale.school.name }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ sale.student_name }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ sale.total_quantity }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ sale.total_amount }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ sale.note }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <Show-link class="p-1" :show="{route: 'sales.show', id:sale.id }" showicon />
                            <!-- <doc class="p-1" :link="{route: 'sales.invoice.save', id:sale.id }" icon /> -->

                            <print class="p-1" :link="{route: 'sales.invoice.print', id:sale.id }" icon />
                            <Edit-link v-if="($page.props.user.permissions.includes('edit sales'))" class="p-1" :edit="{route: 'sales.edit', to:sale.id }" showicon />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="sales" pageof=" Sale Orders" />
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
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import FilterIcon from '@/Shared/Components/Icons/svg/Filter.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import print from '@/Shared/Components/Links/Print.vue'
    import doc from '@/Shared/Components/Links/InvoicePdf.vue'
    import JetButton from '@/Jetstream/Button.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination, ShowLink,print,
            FilterIcon,JetLabel,JetInput,JetButton,doc
        },
        props: ['sales', 'schools' ],
        data: () => ({
            showFilter: false,
            filter:{
              date: null,
              student_name: null,
              student_email: null,
              student_mobile: null,
              quantity: null,
              amount: null,
              school_id: null,
              filter: 1
            }
        }),

        methods:{
          toggleFilter(){
            this.showFilter   = !this.showFilter;
          },
          filterData(){
            Inertia.get(route('sales.index'), this.filter ,{
                        preserveState: true,
                        replace: true
                    });
          }
        }
    })
</script>
