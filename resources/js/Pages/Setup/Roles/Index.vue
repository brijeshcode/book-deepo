<template>
    <app-layout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
                <add-link createRoute="roles.create" isbutton >Add</add-link>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'roles'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <search searchRoute='roles' />
              <Add-link createRoute="roles.create" withIcon  />
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
                            Description
                          </th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="role in roles.data" :key="role.id">
                          <td class="px-4 py-4 whitespace-nowrap">
                            <Edit-link :edit="{route: 'roles.edit', to:role.id }"  >
                              <div class="text-sm text-gray-900">{{ role.name }}</div>
                            </Edit-link>

                          </td>

                          <td class="px-4 py-4 whitespace-nowrap">
                              <div class="text-sm text-gray-900">{{ role.description }}</div>
                          </td>


                          <td class="px-4 py-4 whitespace-nowrap  text-sm flex justify-end text-right  font-medium">
                            <Edit-link :edit="{route: 'roles.edit', to:role.id }" showicon />
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <Pagination :pageData="roles" pageof=" Roles" />
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
            roles: Object,
        }
    })
</script>