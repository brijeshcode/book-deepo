<template>
    <app-layout title="Schools">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schools
                <add-link createRoute="schools.create" isbutton >Add</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <search searchRoute='schools' />
              <Add-link createRoute="schools.create" withIcon />
              <!-- <FilterIcon class="cursor-pointer" @click="showpink" /> -->
            </div>
        </template>

        <div class=" p-4 m-8 shadow-md w-full h-40 bg-red-400 bg-white overflow-hidden shadow-xl sm:rounded-lg" :class="showFilter ? '' : 'hidden' ">
              <search searchRoute='locations' />
         </div>

          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Contact
                        </th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Warehouse
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="school in schools.data" :key="school.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <Edit-link :edit="{route: 'schools.edit', to:school.id }" >
                            <div class="text-sm text-gray-900">{{ school.name }}</div>
                            <div class="text-sm text-gray-700">{{ school.address }}</div>
                          </Edit-link>
                          <span v-if="school.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                          </span>
                          <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            in-Active
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">{{ school.contact_person }}</div>
                          <div class="text-sm text-gray-500">{{ school.email }}</div>
                          <div class="text-sm text-gray-500">{{ school.mobile }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          <div class="text-sm text-gray-900">{{ school.warehouse }}</div>
                          <div class="text-sm text-gray-800">{{ school.city }}, {{ school.state }}</div>
                            <div class="text-sm text-gray-500"> ({{ school.pincode }})</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                          <BookLink :book="{route: 'schools.books.show', of:school.id }" showicon />
                          <Edit-link :edit="{route: 'schools.edit', to:school.id }" showicon />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :pageData="schools" pageof=" Schools" />
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
    import BookLink from '@/Shared/Components/Links/ViewBooks.vue'
    import FilterIcon from '@/Shared/Components/Links/Filter.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination,FilterIcon,BookLink
        },
        props:{
            schools: Object
        },
        data(){
          return { showFilter : false }
        },
        methods: {
          showpink(){ this.showFilter = this.showFilter ? false : true; }
        }
    })
</script>
