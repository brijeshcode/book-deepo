<template>
    <app-layout title="Sample">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sample
                <add-link v-if="($page.props.user.permissions.includes('create samples'))" createRoute="samples.create" isbutton >Generate</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools'}, {route: 'samples.index'} ]" />
        </template>
        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create samples'))" createRoute="samples.create" title="Add new Sample" withIcon />
            </div>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col">
              <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sample #
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            School
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Note
                          </th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="sample in samples.data" :key="sample.id">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'samples.edit', to:sample.id }" >
                              <div class="text-sm text-gray-500">{{ sample.id }}</div>
                            </Edit-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'samples.edit', to:sample.id }" >
                              <div class="text-sm text-gray-500">{{ sample.date }}</div>
                            </Edit-link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ sample.school.name }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ sample.quantity }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ sample.note }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end text-sm font-medium">
                            <Show-link class="p-1" :show="{route: 'samples.show', id:sample.id }" showicon />
                            <Edit-link v-if="($page.props.user.permissions.includes('edit samples'))" class="p-1" :edit="{route: 'samples.edit', to:sample.id }" showicon />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :pageData="samples" pageof=" Sample Orders" />
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
    import Pagination from '@/Shared/Components/Pagination/Simple.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import AddLink from '@/Shared/Components/Links/Add.vue'
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    import ShowLink from '@/Shared/Components/Links/Show.vue'
    import Search from '@/Shared/Components/Filters/Search.vue'

    export default defineComponent({
        components: {
            AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination, ShowLink
        },
        props:{ samples: Object }
    })
</script>
