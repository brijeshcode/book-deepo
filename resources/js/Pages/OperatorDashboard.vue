<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class=" pt-5 pl-5 flex flex-wrap w-full mb-8">
                      <div class="w-full mb-6 lg:mb-0">
                        <h1 class="sm:text-4xl flex text-5xl font-medium title-font mb-2 text-gray-900">
                            <svg class="h-9 w-9"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="13" r="2" />  <line x1="13.45" y1="11.55" x2="15.5" y2="9.5" />  <path d="M6.4 20a9 9 0 1 1 11.2 0Z" /></svg> Dashboard</h1>
                        <div class="h-1 w-40 bg-pink-500 rounded"></div>
                      </div>
                    </div>

                    <div class="flex items-start justify-center pt-5 bg-white min-w-screen">
                        <div class="flex flex-wrap w-full px-4 pb-4">
                            <!-- <div class="w-full px-2 sm:w-1/2 xl:w-1/4">
                                <div
                                    class="relative flex items-center px-5 py-6 overflow-hidden rounded-md shadow-sm bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-indigo-300 to-indigo-500"></span>
                                    <div class="p-3 bg-opacity-75 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600">
                                        <svg class="h-8 w-8 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M3 21v-13l9-4l9 4v13" />  <path d="M13 13h4v8h-10v-6h6" />  <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" /></svg>
                                    </div>
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{ warehouses }}</h4>
                                        <div class="text-gray-500">Warehouses</div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="w-full px-2 mt-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                                <div
                                    class="relative flex items-center px-5 py-6 overflow-hidden rounded-md shadow-sm bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-pink-300 to-pink-500"></span>
                                    <div class="p-3 bg-opacity-75 rounded-full bg-gradient-to-br from-pink-400 to-pink-600">
                                        <svg class="h-8 w-8 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <line x1="3" y1="10" x2="21" y2="10" />  <polyline points="5 6 12 3 19 6" />  <line x1="4" y1="10" x2="4" y2="21" />  <line x1="20" y1="10" x2="20" y2="21" />  <line x1="8" y1="14" x2="8" y2="17" />  <line x1="12" y1="14" x2="12" y2="17" />  <line x1="16" y1="14" x2="16" y2="17" /></svg>
                                    </div>
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{ schools }}</h4>
                                        <div class="text-gray-500">Schools</div>
                                    </div>
                                </div>
                            </div>


                            <div class="w-full px-2 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-0">
                                <div
                                    class="relative flex items-center px-8 py-6 overflow-hidden rounded-md shadow-sm bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-orange-300 to-orange-500"></span>
                                    <div class="p-3 bg-opacity-75 rounded-full bg-gradient-to-br from-orange-400 to-orange-600">
                                        <bookIcon class="h-8 w-8 text-white" />
                                    </div>
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{ sales }}</h4>
                                        <div class="text-gray-500">Sales Invoice</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-2 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-0">
                                <div
                                    class="relative flex items-center px-8 py-6 overflow-hidden rounded-md shadow-sm bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-yellow-300 to-yellow-500"></span>
                                    <div class="p-3 bg-opacity-75 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600">
                                        <svg class="h-8 w-8 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polygon points="12 2 2 7 12 12 22 7 12 2" />  <polyline points="2 17 12 22 22 17" />  <polyline points="2 12 12 17 22 12" /></svg>
                                    </div>
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{ totalSale }}</h4>
                                        <div class="text-gray-500">Sale Amount</div>
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
    import bookIcon from '@/Shared/Components/Icons/svg/Book.vue'

    export default defineComponent({
        components: {AppLayout,bookIcon},
        props: ['books','schools','totalSale', 'sales']
    })
</script>
