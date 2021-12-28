<template>
    <app-layout title="Schools">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schools
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div>
                        <Link :href="route('schools.create')" class="mb-6 p-2 shadow-xl bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Add School</Link>
                        &nbsp;
                        <Link :href="route('schoolOrder')" class="mb-6 p-2 ml-2 bg-green-400 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Orders</Link>
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
                                    Warehouse
                                  </th>
                                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="school in schools.data" :key="school.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ school.name }}</div>
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
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('schools.edit', school.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <Pagination
                              :links="schools.links"
                              :from="schools.from"
                              :to="schools.to"
                              :total="schools.total"
                              :previous="schools.prev_page_url"
                              :next="schools.next_page_url"
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
    import { Link } from '@inertiajs/inertia-vue3';
    import Pagination from '@/Layouts/Pagination.vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        components: {
            AppLayout,Link,
            Pagination
        },
        props:{
            schools: Object
        }
    })
</script>
