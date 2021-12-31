<template>
    <app-layout title="Publishers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publishers
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" breadcrum flex items-center py-4 overflow-y-auto whitespace-nowrap">
                <Link :href="route('dashboard')" class="text-gray-600 dark:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </Link>

                <span class="mx-5 text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>

                <Link :href="route('publishers')"  class="text-blue-600 dark:text-blue-200 hover:underline">Publishers</Link>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div>
                        <Link :href="route('publishers.create')" class="mb-6 p-2 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Add Publisher</Link>
                        &nbsp;
                        <Link :href="route('publishersOrder')" class="mb-6 p-2 bg-green-400 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Orders</Link>
                    </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <!-- This example requires Tailwind CSS v2.0+ -->
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
                                    Location
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="publisher in publishers.data" :key="publisher.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ publisher.name }}</div>
                                    <span v-if="publisher.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                      Active
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                      in-Active
                                    </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ publisher.contact_person }}</div>
                                    <div class="text-sm text-gray-500">{{ publisher.email }}</div>
                                    <div class="text-sm text-gray-500">{{ publisher.mobile }}</div>
                                  </td>

                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-900">{{ publisher.location }}</div>
                                    <div class="text-sm text-gray-800">{{ publisher.city }}, {{ publisher.state }}</div>
                                      <div class="text-sm text-gray-500"> ({{ publisher.pincode }})</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('publishers.edit', publisher.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <Pagination
                              :links="publishers.links"
                              :from="publishers.from"
                              :to="publishers.to"
                              :total="publishers.total"
                              :previous="publishers.prev_page_url"
                              :next="publishers.next_page_url"
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
    import { Link } from '@inertiajs/inertia-vue3';


    export default defineComponent({
        components: {
            Link,
            AppLayout,
            Pagination
        },
        props:{
            publishers: Object
        }
    })
</script>
