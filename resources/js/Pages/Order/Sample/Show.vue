<template>
    <app-layout title="Sales">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schoole Sample Details
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[  { route: 'schools.index'}, {route: 'samples.index'} , { name:'Detail'} ]" />
        </template>

         <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create samples'))" createRoute="samples.create" title="Add new school sample" withIcon />
            </div>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <!-- Introduction section -->
                <div class="flex flex-row w-full justify-between border-b">
                    <div class="flex-col px-4 py-2">
                        <p class="text-gray-500 mb-4">Created: {{ sample.date }}</p>
                    </div>
                    <div class="flex-col text-right px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">Sample# {{ sample.id }}</p>
                    </div>
                </div>

                <div class="flex flex-row border-b mb-4">
                    <div class="flex-col p-4 w-1/3 border-r">
                        <h2 class="uppercase font-semibold mb-2" >School Address</h2>
                        <p class="">{{ sample.school.name }}</p>
                        <p class="text-gray-500 text-sm">{{ sample.school.address }}</p>
                        <p class="text-gray-500 text-sm">{{ sample.school.city }}, {{ sample.school.state }}</p>
                        <p class="text-gray-500 text-sm">{{ sample.school.pincode }}</p>
                    </div>
                    <!-- <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" >Deliver From</h2>
                                <p class="">{{ sample.school.warehouse.name }}</p>
                                <p class="text-gray-500 text-sm">{{ sample.school.warehouse.address }}</p>
                                <p class="text-gray-500 text-sm">{{ sample.school.warehouse.city }}, {{ sample.school.warehouse.state }}</p>
                                <p class="text-gray-500 text-sm">{{ sample.school.warehouse.pincode }}</p>
                            </div>
                            <div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ sample.school.warehouse.email }}</p>
                                <p class="text-gray-500 text-sm">{{ sample.school.warehouse.mobile }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col p-4">

                    </div> -->
                </div>

                <!-- Sample Items details section -->
                    <div class="text-xl uppercase px-4 mt-4">
                        Sample Items
                        <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                    </div>

                    <div class="w-full p-4 mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ sample.quantity }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr class=" border-b" v-for="(item, index) in sample.items">
                                    <td class="px-6 py-2">
                                        <div class="flex ">
                                            <div class="left ">
                                                <div class="text-gray-900 text-lg">{{ item.name }}</div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Class: </span> {{ item.class }}
                                                </div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Subject: </span> {{ item.subject }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6">{{ item.publisher.name }}</td>
                                    <td class="px-6">{{ item.quantity }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                <!-- <div class="mb-4">
                    <jet-button class="ml-4" >Print</jet-button>
                </div> -->
            </div>
        </div>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'

    export default defineComponent({
        components: {
            AppLayout,
            JetLabel,
            JetButton,
            BreadSimple
        },
        props: ['sample']
    })
</script>