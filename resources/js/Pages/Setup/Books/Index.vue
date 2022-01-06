<template>
    <app-layout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
                <add-link createRoute="books.create" isbutton >Add</add-link>
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
                        Quantity
                      </th>
                      <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cost
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
                        <div class="text-sm text-gray-900">{{ book.quantity }}</div>
                      </td>
                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ book.cost }}</div>
                      </td>
                      <!-- <td class="px-4 py-4 whitespace-nowrap">
                        <div v-for="school in book.schools" class="pb-2">

                          <div class="text-sm text-gray-900 ">
                            {{ school.name }}, {{ school.contact_person }}
                          </div>
                          <div class="text-sm text-gray-900">
                              <MailIcon class="inline-flex w-4 h-4" /> {{ school.email }},<br/>
                              <MobileIcon class="inline-flex w-4 h-4" /> {{ school.mobile }}
                          </div>
                           <div class="text-sm text-gray-500">
                            <MapIcon class="inline-flex w-4 h-4" /> {{ school.city }}, {{ school.state }} ({{ school.pincode }})
                          </div>
                        </div>
                      </td> -->
                      <!-- <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">  {{ book.school.name }}, {{ book.school.contact_person }}</div>
                        <div class="text-sm text-gray-700">
                          <MailIcon class="inline-flex w-4 h-4" /> {{ book.school.email }},<br/>
                          <MobileIcon class="inline-flex w-4 h-4" /> {{ book.school.mobile }}
                        </div>
                        <div class="text-sm text-gray-500">
                        <MapIcon class="inline-flex w-4 h-4" /> {{ book.school.city }}, {{ book.school.state }} ({{ book.school.pincode }})</div>
                      </td> -->
                      <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ book.warehouse.name }}, {{ book.warehouse.contact_person }}</div>
                        <div class="text-sm text-gray-700">
                            <MailIcon class="inline-flex w-4 h-4" /> {{ book.warehouse.email }},<br/>
                            <MobileIcon class="inline-flex w-4 h-4" /> {{ book.warehouse.mobile }}</div>
                        <div class="text-sm text-gray-500">
                          <MapIcon class="inline-flex w-4 h-4" />
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

    import MailIcon from '@/Shared/Components/Icons/svg/Email.vue'
    import MobileIcon from '@/Shared/Components/Icons/svg/Mobile.vue'
    import MapIcon from '@/Shared/Components/Icons/svg/Map.vue'
    import SchoolIcon from '@/Shared/Components/Icons/svg/School.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple,Search,AddLink,EditLink,Pagination,MailIcon,MobileIcon,MapIcon,SchoolIcon
        },
        props:{
            books: Object
        }
    })
</script>
