<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class=" pt-5 pl-5 flex flex-wrap w-full mb-8">
                      <div class="w-full mb-6 lg:mb-0">
                        <h1 class="sm:text-4xl flex text-5xl font-medium title-font mb-2 text-gray-900">
                            <svg class="h-9 w-9"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="13" r="2" />  <line x1="13.45" y1="11.55" x2="15.5" y2="9.5" />  <path d="M6.4 20a9 9 0 1 1 11.2 0Z" /></svg> Dashboard</h1>
                        <div class="h-1 w-40 bg-pink-500 rounded"></div>
                      </div>
                    </div>
                    <div class="flex items-start justify-center pt-5 bg-white min-w-screen">
                        <div class="flex flex-wrap w-full px-4">
                            <div class="w-full px-2 sm:w-1/2 xl:w-1/3">
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
                            </div>
                            <div class="w-full px-2 mt-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
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


                            <div class="w-full px-2 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                                <div
                                    class="relative flex items-center px-8 py-6 overflow-hidden rounded-md shadow-sm bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-orange-300 to-orange-500"></span>
                                    <div class="p-3 bg-opacity-75 rounded-full bg-gradient-to-br from-orange-400 to-orange-600">
                                        <svg class="h-8 w-8 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /></svg>
                                    </div>
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{ books }}</h4>
                                        <div class="text-gray-500">Books</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- component -->
                    <section class="text-gray-600 body-font">
                      <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap w-full mb-8">
                          <div class="w-full mb-6 lg:mb-0">
                            <h1 class="sm:text-4xl text-5xl font-medium title-font mb-2 text-gray-900 flex"> <svg class="h-9 w-9"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="19" x2="20" y2="19" />  <polyline points="4 15 8 9 12 11 16 6 20 10" /></svg> Statistic</h1>
                            <div class="h-1 w-20 bg-indigo-500 rounded"></div>
                          </div>
                        </div>
                        <div class="flex flex-wrap -m-4 text-center">
                          <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="bg-indigo-500 rounded-lg p-2 xl:p-6">
                                <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">{{ schoolOrders }}</h2>
                                <p class="leading-relaxed text-gray-100 font-bold">School orders</p>
                            </div>
                          </div>
                          <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="bg-indigo-500 rounded-lg p-2 xl:p-6">
                                <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">{{ supplierOrders }}</h2>
                                <p class="leading-relaxed text-gray-100 font-bold">Supplier Orders</p>
                            </div>
                          </div>
                          <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="bg-indigo-500 rounded-lg p-2 xl:p-6">
                                <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">{{ publisherOrders }}</h2>
                                <p class="leading-relaxed text-gray-100 font-bold">Publisher Orders</p>
                            </div>
                          </div>
                          <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="bg-indigo-500 rounded-lg p-2 xl:p-6">
                                <h2 class="title-font font-medium sm:text-4xl text-3xl text-white">4</h2>
                                <p class="leading-relaxed text-gray-100 font-bold">Pendings</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        components: {AppLayout},
        props: ['books','schools','warehouses', 'schoolOrders', 'supplierOrders', 'publisherOrders']
    })
</script>
