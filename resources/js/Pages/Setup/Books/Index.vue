<template>
    <app-layout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
                <add-link createRoute="locations.create" isbutton >Add</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'books'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <search searchRoute='books' />
              <Add-link createRoute="books.create" withIcon />
            </div>
        </template>

        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        SKU #
                      </th>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Book
                      </th>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        School
                      </th>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Warehouse
                      </th>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Note
                      </th>
                      <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="book in books.data" :key="book.id">
                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ book.sku_no }}</div>
                      </td>

                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"> <span class="font-bold">{{ book.name }}</span> by, <span class="italic">{{ book.author_name }}</span></div>
                        <div class="text-sm text-gray-700">{{ book.class }}, {{ book.subject }}</div>
                      </td>
                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">  {{ book.school.name }}, {{ book.school.contact_person }}</div>
                        <div class="text-sm text-gray-700">
                          <svg class="h-4 w-4 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                          </svg>
                            {{ book.school.email }},<br/>
                          <svg class="h-4 w-4 inline-flex"  width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="7" y="4" width="10" height="16" rx="1" />  <line x1="11" y1="5" x2="13" y2="5" />  <line x1="12" y1="17" x2="12" y2="17.01" /></svg>
                            {{ book.school.mobile }}
                        </div>
                        <div class="text-sm text-gray-500"><svg class="h-4 w-4 inline-flex"  width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="18" y2="6.01" />  <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />  <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15" />  <line x1="9" y1="4" x2="9" y2="17" />  <line x1="15" y1="15" x2="15" y2="20" /></svg> {{ book.school.city }}, {{ book.school.state }} ({{ book.school.pincode }})</div>
                      </td>
                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ book.warehouse.name }}, {{ book.warehouse.contact_person }}</div>
                        <div class="text-sm text-gray-700">
                            <svg class="h-4 w-4 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                              </svg> {{ book.warehouse.email }},<br/>
                              <svg class="h-4 w-4 inline-flex"  width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="7" y="4" width="10" height="16" rx="1" />  <line x1="11" y1="5" x2="13" y2="5" />  <line x1="12" y1="17" x2="12" y2="17.01" /></svg>
                            {{ book.warehouse.mobile }}</div>
                        <div class="text-sm text-gray-500">
                          <svg class="h-4 w-4 inline-flex"  width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="18" y2="6.01" />  <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />  <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15" />  <line x1="9" y1="4" x2="9" y2="17" />  <line x1="15" y1="15" x2="15" y2="20" /></svg>
                      {{ book.warehouse.city }}, {{ book.warehouse.state }} ({{ book.warehouse.pincode }})</div>
                      </td>
                      <td>
                        <div class="truncate w-20">{{ book.note }}</div>
                      </td>
                      <td class="px-4 py-2 whitespace-nowrap text-right text-sm flex justify-end font-medium">
                        <Edit-link :edit="{route: 'books.edit', to:book.id }" showicon />
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :pageData="books" pageof=" Books" />
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
    import Search from '@/Shared/Components/Filters/Search.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple,Search,AddLink,EditLink,Pagination
        },
        props:{
            books: Object
        }
    })
</script>
