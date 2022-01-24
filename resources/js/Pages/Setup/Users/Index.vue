<template>
    <app-layout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
                <add-link createRoute="users.create" isbutton >Add</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'users.index'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <search searchRoute='users.index' />
              <Add-link createRoute="users.create" withIcon  />
            </div>
        </template>
        <!-- <alert-success  message="Location added successfuly" /> -->

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
                            Email
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Note
                          </th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users.data" :key="user.id">
                          <td class="px-4 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'users.edit', to:user.id }"  >
                              <div class="text-sm text-gray-900">{{ user.name }}</div>
                            </Edit-link>
                            <span v-if="user.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                              Active
                            </span>
                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                              in-Active
                            </span>
                          </td>
                          <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                          </td>
                          <td class="px-4 py-4 whitespace-nowrap">
                            <div v-on="user.roles">
                            <div class="text-sm text-gray-500" v-for="role in user.roles" >{{ role.name }}</div>
                            </div>
                          </td>
                          <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ user.note }}</div>
                          </td>
                          <td class="px-4 py-4 whitespace-nowrap  text-sm flex justify-end text-right  font-medium">
                            <Edit-link :edit="{route: 'users.edit', to:user.id }" showicon />
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <Pagination :pageData="users" pageof=" Users" />
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
    import Search from '@/Shared/Components/Filters/Search.vue'
    // import AlertSuccess from '@/Shared/Components/Alerts/Pops/Success.vue'

    export default defineComponent({
        components: {
          AppLayout,BreadSimple, Search,AddLink,EditLink,Pagination
        },
        props:{
            users: Object,
        }
    })
</script>