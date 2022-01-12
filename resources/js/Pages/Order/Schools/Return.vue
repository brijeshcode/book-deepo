<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order Return
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools'}, {route: 'schoolOrder', name:'Orders'} , {name:'Return'} ]" />
        </template>


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2">
                    <form  @submit.prevent="submitData">
                        <div class="flex flex-row mb-4">

                            <div class="basis-1/4">
                                {{ order.school.name }}
                            </div>


                        </div>

                        <div v-if="form.items.length" class="book-item-details">

                            <table class="min-w-full divide-y divide-gray-200 border mb-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Book" /></th>
                                        <!-- <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Request Quantity" /></th> -->
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Return To" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Returnable Quantity" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Return Quantity" /></th>
                                        <!-- <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Unit Price" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Total Price" /></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in form.items">
                                        <td class="px-4 py-4 whitespace-nowrap"> {{ item.book_name }} </td>
                                        <!-- <td class="px-4 py-4 whitespace-nowrap">{{ item.request_quantity }}</td> -->
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div v-if="item.order_to === 'Supplier'">
                                                {{ item.supplier_name  }}
                                            </div>
                                            <div v-else>
                                                {{ item.publisher_name  }}
                                            </div>
                                        </td>

                                        <td class="text-center">{{ item.recived_quantity }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="number" style="width:120px" step="1" min="0" :max="item.recived_quantity" class="mt-1 block" v-model="item.quantity" />
                                        </td>


                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <!-- <td class="px-4 py-4 whitespace-nowrap"></td> -->
                                        <td class="px-4 py-4 whitespace-nowrap"><jet-input type="number" class="mt-1 block" style="width:120px" readonly v-model="computeDeliveryQuantity" /></td>
                                    </tr>
                                </tfoot>
                            </table>

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
    import GroupInput from '@/Shared/Components/Form/Simple/InputGroup'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    // import BookList from '@/Pages/Order/School/BookList.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            EditLink,
            Link,
            JetInputError,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple,
            GroupInput
            // BookList
        },
        props: ['schools','order'],
        setup () {
            const form = useForm({
              items: []
            });

            return { form  }
        },
        computed: {
            computeDeliveryQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                return qty;
            }


        },
        created(){
            if (this.order) {
                /*Object.keys(this.order).forEach((index) => {
                    this.form[index] = this.order[index];
                });*/
                this.order.items.forEach((item, index) => {
                    console.log(item);
                    var item = {
                        book_name : item.book.name,
                        publisher_name : item.publisher.name,
                        supplier_name : item.supplier.name,
                        supplier_id : item.supplier_id,
                        publisher_id : item.publisher_id,
                        school_order_id : item.school_order_id,
                        school_order_item_id : item.id,
                        order_to : item.order_to,
                        book_id : item.book_id,
                        // quantity : item.recived_quantity,
                        quantity : 0,
                        // price : item.recived_quantity ,
                        // amount: 0,
                        // request_quantity : item.quantity,
                        recived_quantity : item.recived_quantity
                    };
                    this.form.items.push(item);
                });

            }
        },
        methods:{
            submitData(){
                this.form.post(route('school.order.return.store'));
            }
        },

    })
</script>