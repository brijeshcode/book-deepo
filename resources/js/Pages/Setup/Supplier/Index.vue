<template>
    <app-layout title="Suppliers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suppliers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div>
                        <Link :href="route('suppliers.create')" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto">Create</Link>
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
                                <tr v-for="supplier in suppliers.data" :key="supplier.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ supplier.name }}</div>
                                    <span v-if="supplier.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                      Active
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                      in-Active
                                    </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ supplier.contact_person }}</div>
                                    <div class="text-sm text-gray-500">{{ supplier.email }}</div>
                                    <div class="text-sm text-gray-500">{{ supplier.mobile }}</div>
                                  </td>

                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-900">{{ supplier.location }}</div>
                                    <div class="text-sm text-gray-800">{{ supplier.city }}, {{ supplier.state }}</div>
                                      <div class="text-sm text-gray-500"> ({{ supplier.pincode }})</div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('suppliers.edit', supplier.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <Pagination
                              :links="suppliers.links"
                              :from="suppliers.from"
                              :to="suppliers.to"
                              :total="suppliers.total"
                              :previous="suppliers.prev_page_url"
                              :next="suppliers.next_page_url"
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
            suppliers: Object
        }
    })
</script>
