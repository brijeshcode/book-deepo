<template>
    <app-layout title="Publishers Payment">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publishers Payment <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
             <bread-simple :items="[  { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Orders'} , { name:'payment'} ]" />

        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <div class="border rounded">
                    <div class="p-2">
                        <div class="flex flex-row border-b mb-4">
                            <div class="flex-col w-1/3 border-r p-4">
                                <h2 class="uppercase font-semibold mb-2" >School Order: #{{ publisherOrder.school_order_id }}</h2>
                                <p class="text-gray-500 mb-4">Created: date</p>
                                <p class="text-gray-700 text-sm uppercase font-bold">
                                    Status<br/>
                                    <!-- <span class="text-green-600 text-xl ">{{ order.status }}</span> -->
                                    <span class="text-green-600 text-xl ">completed</span>
                                </p>
                            </div>
                            <div class="flex-col w-1/3 border-r p-4">
                                <h2 class="uppercase font-semibold mb-2" >Publisher Order: #{{ publisherOrder.id }} </h2>
                                <p class="text-gray-500 mb-4">Created: {{ publisherOrder.date }}</p>
                                <div class="mt-2 border-t">
                                    <table class="min-w-full">
                                        <tr class="hover:bg-gray-100">
                                            <th class="text-left px-2">Delivery Challan Total:</th>
                                            <td class="text-right px-2 text-lg">{{ publisherOrder.delivery_challan_total }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-100">
                                            <th class="text-left px-2">Return Challan Total:</th>
                                            <td class="text-right px-2 text-lg">{{ publisherOrder.return_challan_total }}</td>
                                        </tr>
                                        <tr class="border-b hover:bg-gray-100">
                                            <th class="text-left px-2">Paid Total:</th>
                                            <td class="text-right px-2 text-lg">{{ publisherOrder.paid }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-100">
                                            <th class="text-left px-2">Current Due Total:</th>
                                            <td class="text-right px-2 text-lg text-green-600 font-bold">{{ publisherOrder.due }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="flex-col w-1/3 p-4"></div>
                        </div>
                        <h2 class="font-semibold text-xl mb-4">Order Challans</h2>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Challan #</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase">Amount</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">File</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="challan in publisherOrder.challans" class="hover:bg-gray-100">
                                    <td class="px-6 py-2 text-gray-500 capitalize ">{{ challan.challan_type }}</td>
                                    <td class="px-6 py-2 text-gray-500 ">{{ challan.date }}</td>
                                    <td class="px-6 py-2 text-gray-500 ">{{ challan.challan_no }}</td>
                                    <td class="px-6 py-2 text-gray-500 text-right">{{ challan.amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr class="mb-4">

                        <h2 class="font-semibold text-xl mb-4">Payment history</h2>

                        <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                            <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>

                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="payment in publisherOrder.payments" :key="payment.id">
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <div class="text-sm text-gray-500">{{ payment.date }}</div>
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-500">{{ payment.amount }}</div>
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm uppercase text-gray-500">{{ payment.payment_mode }}</div>
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-500">{{ payment.note }}</div>
                              </td>

                            </tr>
                          </tbody>
                        </table>
                    </div>

                </div>
                <form  @submit.prevent="form.post(route('publisher.payments.store'))">
                    <div class="grid grid-cols-1 md:grid-cols-5 mb-4 gap-4">
                        <div class="">
                            <jet-label for="date" required value="Date" />
                            <jet-input id="date" type="date" class="mt-1 w-full " v-model="form.date" autocomplete="date"  />
                            <jet-input-error :message="form.errors.date" class="mt-2" />
                        </div>

                        <div class="">
                            <jet-label for="amount" required value="Amount" />
                            <jet-input id="amount" type="number" min="0"  max="form.amount" class="mt-1 w-full" required v-model="form.amount" autocomplete="amount" />
                            <jet-input-error :message="form.errors.amount" class="mt-2" />
                        </div>

                        <div class="">
                            <jet-label for="payment_mode" required value="Payment Mode" />
                            <jet-input id="payment_mode" type="text" class="mt-1 w-full " v-model="form.payment_mode" autocomplete="payment_mode" required />
                            <jet-input-error :message="form.errors.payment_mode" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <jet-label for="note" value="Note" />
                            <textarea id="note" class="mt-1 w-full rounded border-gray-300" v-model="form.note" autocomplete="note" ></textarea>

                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing && form.items.length ">Save</jet-button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    // import BookList from '@/Pages/Order/Publishers/BookList.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            Link,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple
            // BookList
        },
        props: ['publisherOrder'],
        data: () => ({
            edit: false,
            books: []
        }),
        setup () {
            const form = useForm({
                publisher_id: '',
                publisher_order_id: '',
                amount: '',
                date: new Date().toISOString().slice(0,10),
                note: '',
                payment_mode: 'cash'
            });

            return { form  }
        },

        created(){
            this.form.publisher_id = this.publisherOrder.publisher_id;
            this.form.publisher_order_id = this.publisherOrder.id;
            this.form.amount = this.publisherOrder.due;
        },
        methods:{
        }
    })
</script>