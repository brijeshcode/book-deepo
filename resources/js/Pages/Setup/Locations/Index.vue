<template>
    <app-layout title="Locations">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Locations
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <bread-simple :links="breadItems" />
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div>
                    <Link :href="route('locations.create')" class="mb-6 p-2 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Create</Link>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="flex flex-col">
                      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="table-auto min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    City
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    State
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pincode
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Note
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="location in locations.data" :key="location.id">
                                  <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ location.name }}</div>
                                    <span v-if="location.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                      Active
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                      in-Active
                                    </span>
                                  </td>
                                  <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ location.city }}</div>
                                  </td>
                                  <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ location.state }}</div>
                                  </td>
                                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ location.pincode }}</div>
                                  </td>
                                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-500">{{ location.note }}</div>
                                  </td>
                                  <td class="px-4 py-4 whitespace-nowrap  text-sm text-right  font-medium">
                                    <Link :href="route('locations.edit', location.id)" class="text-indigo-600 hover:text-indigo-900">
                                      <svg class="h-5 w-5"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    </Link>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <Pagination
                              :links="locations.links"
                              :from="locations.from"
                              :to="locations.to"
                              :total="locations.total"
                              :previous="locations.prev_page_url"
                              :next="locations.next_page_url"
                            />
                          </div>
                        </div>
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
    import Pagination from '@/Layouts/Pagination.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Link } from '@inertiajs/inertia-vue3';


    export default defineComponent({
        components: {
            Link,
            AppLayout,
            BreadSimple,
            Pagination
        },
        props:{
            locations: Object
        },
        data: () => ({
            breadItems: [
            { name: 'Location', url: route('locations'), active: route().current('locations')}
            ]
         }),
    })
</script>
