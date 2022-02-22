<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order Return
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} , {name:'Return'} ]" />
        </template>


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2">

                    <div class="flex flex-row w-full justify-between border-b">
                        <div class="flex-col px-4 py-2">
                            <p class="text-gray-500">Order #: {{ order.id }}</p>
                            <p class="text-gray-500 mb-4">Created: {{ order.date }}</p>
                            <p class="text-gray-700 text-sm uppercase font-bold">
                                Status<br/>
                                <span class="text-green-600 text-xl ">{{ order.status }}</span>
                            </p>
                        </div>
                        <div class="flex-col text-right px-4 py-2">
                            <p class="text-lg font-bold text-gray-800">{{ order.school.name }}</p>
                            <p class="text-gray-500">{{ order.school.contact_person }}</p>
                            <p class="text-gray-500">{{ order.school.email }}</p>
                            <p class="text-gray-500">{{ order.school.mobile }}</p>
                        </div>
                    </div>


                    <form  @submit.prevent="submitData">
                        <div class="flex flex-row my-4 mb-4">
                            Return to
                                <select @change="returnToChange($event)" v-model='returnTo' class="ml-2">
                                    <option v-for="delivery in supplierDeliveries" data-returnto="supplier" :value="delivery.id">{{ delivery.supplier.name }}</option>
                                    <option v-for="delivery in publisherDeliveries" data-returnto="publisher" :value="delivery.id">{{ delivery.publisher.name }}</option>
                                </select>


                        </div>

                        <div v-if="form.items.length" class="book-item-details">

                            <table class="min-w-full divide-y divide-gray-200 border mb-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Book" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Class" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Returnable Quantity" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Return Quantity" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Rate" /></th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Price" /></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in form.items">
                                        <td class="px-4 py-4 whitespace-nowrap"> {{ item.book_name }} </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                                {{ item.book_class  }}
                                        </td>

                                        <td class="text-center">{{ item.quantity_returnable }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="number" @change="priceChange(index)"  style="width:120px" step="1" min="0" :max="item.quantity_returnable" class="mt-1 block" v-model="item.quantity" />
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">{{ item.unit_price }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">{{ item.price }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap">{{ computeReturnQuantity }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">{{ computeReturnAmount }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <hr>
                        <!-- Order Item details section -->
                        <div class="text-xl uppercase px-4 my-4 " v-if="form.items.length > 0">
                            Return Challans    <span class="p-2 bg-gray-800 rounded text-white m-2 " @click="addChallan">Add </span>
                            <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                        </div>
                         <div v-if="form.items.length > 0">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mb-2">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Date" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Challan Number" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Amount" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="File" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Note" /></th>
                                            <th>
                                                 <span class="p-2 bg-gray-800 text-white m-2 rounded " @click="addChallan">Add </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(challan,challan_key) in form.challans">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="date" class="mt-1 block" v-model="challan.date" autocomplete="date" />
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input id="challan_no" style="width:150px" type="text" class="mt-1 block" v-model="challan.challan_no" autocomplete="challan_no" />
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input id="amount" style="width:100px" type="text" class="mt-1 block" v-model="challan.amount" autocomplete="amount" />
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <input type="file" @input="challan.path = $event.target.files[0]" />
                                                <img v-if="challan.path && challan.path != '' " :src="challan.path" style="width:120px;height:120px;">
                                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                  {{ form.progress.percentage }}%
                                                </progress>
                                            </td>
                                            <td>
                                                <textarea v-model="challan.note"></textarea>
                                            </td>
                                            <td>
                                                <button type="button" v-on:click="removeChallan(challan_key)" v-if="challan_key > 0" >
                                                    <span class="material-icons text-sm text-red-500"><remove-icon /></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    import GroupInput from '@/Shared/Components/Form/Simple/InputGroup'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    // import BookList from '@/Pages/Order/School/BookList.vue'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            EditLink,
            Link,
            JetInputError,
            JetInput,
            AppLayout,
            RemoveIcon,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple,
            GroupInput
            // BookList
        },
        props: [ 'publisherOrders', 'order', 'supplierOrders'],
        data: () => ({
            edit: false,
            returnTo: '',
            publisherDeliveries: [],
            supplierDeliveries: [],
            returnType : '',
        }),
        setup () {
            const form = useForm({
              date: new Date().toISOString().slice(0,10),
              publisher_id: '',
              supplier_id: '',
              publisher_order_id: '',
              supplier_order_id: '',
              quantity: 0,
              amount: 0,
              items: [],
              challans: [],
            });

            return { form  }
        },
        computed: {
            computeReturnQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                this.form.quantity = qty;
                return qty;
            },
            computeReturnAmount: function (){
                let amount  = 0;
                this.form.items.forEach((item) =>{ amount += parseInt(item.price); });
                this.form.amount = amount;
                return amount;
            }
        },

        created(){
            this.publisherDeliveries = this.publisherOrders.deliveries;
            this.supplierDeliveries = this.supplierOrders.deliveries;
        },
        methods:{
            submitData(){
                if (this.form.quantity <= 0) { alert('Return quantity zero, cannot make return.'); return ;}

                this.returnType == 'supplier' ? this.form.post(route('supplier.return.store'))  : this.form.post(route('publisher.return.store')) ;             },

            priceChange(index){
                this.form.items[index].price = this.form.items[index].unit_price * this.form.items[index].quantity;
            },

            addChallan(){
                this.returnType == 'supplier' ? this.supplierChallans()  : this.publissherChallans() ;
            },

            supplierChallans(){
                this.form.challans.push({
                    date: new Date().toISOString().slice(0,10),
                    school_order_id:this.order.id,
                    supplier_order_id: this.form.supplier_order_id,
                    supplier_delivery_id: '',
                    supplier_id: this.form.supplier_id,
                    challan_no: '',
                    path: '',
                    challan_type: 'return',
                    payment_status: 'Due',
                    amount: 0,
                    note:''
                });
            },

            publissherChallans(){
                this.form.challans.push({
                    date: new Date().toISOString().slice(0,10),
                    school_order_id:this.order.id,
                    publisher_order_id: this.form.publisher_order_id,
                    publisher_delivery_id: '',
                    publisher_id: this.form.publisher_id,
                    challan_no: '',
                    path: '',
                    challan_type: 'return',
                    payment_status: 'Due',
                    amount: 0,
                    note:''
                });
            },

            removeChallan(index) {
                if (confirm('Are you sure?')) { this.form.challans.splice(index, 1); }
            },

            returnToChange(event){
                this.form.items = [];
                this.form.challans= [];
                let delivery_id = event.target.value;
                this.returnType  = event.target.selectedOptions[0].dataset.returnto;
                this.returnType == 'supplier' ? this.supplierItems(delivery_id) : this.publisherItems(delivery_id);
            },

            publisherItems(delivery_id){

                this.publisherDeliveries.forEach(delivery => {
                    if (delivery.id == delivery_id) {
                        this.form.publisher_id = delivery.publisher_id;
                        this.form.publisher_order_id = delivery.publisher_order_id;
                        delivery.items.forEach(item => {
                            this.form.items.push({
                                publisher_order_item_id: item.publisher_order_item_id ,
                                book_name: item.book.name,
                                book_class: item.book.class,
                                book_id: item.book_id,
                                quantity_returnable: item.quantity,
                                quantity: 0,
                                unit_price: item.unit_price,
                                price: 0,
                            });
                        });
                    }
                });

                this.publisherOrders.challans.forEach(challan =>{
                    if (challan.challan_type == 'return' && this.form.publisher_id == challan.publisher_id) {
                        this.form.challans.push(challan);
                    }
                });

                this.form.items.forEach((item, key) => {
                    this.publisherOrders.returns.forEach((publisherReturns) => {
                        publisherReturns.items.forEach(returnItem => {
                            if (returnItem.publisher_order_item_id == item.publisher_order_item_id) {
                                this.form.items[key].price = returnItem.price;
                                this.form.items[key].quantity = returnItem.quantity;
                            }
                        });
                    });
                });

            },

            supplierItems(delivery_id){

                this.supplierDeliveries.forEach(delivery => {
                    if (delivery.id == delivery_id) {
                        this.form.supplier_id = delivery.supplier_id;
                        this.form.supplier_order_id = delivery.supplier_order_id;

                        delivery.items.forEach(item => {
                            this.form.items.push({
                                supplier_order_item_id: item.supplier_order_item_id,
                                book_name: item.book.name,
                                book_class: item.book.class,
                                book_id: item.book_id,
                                quantity_returnable: item.quantity,
                                quantity: 0,
                                unit_price: item.unit_price,
                                price: 0,
                            });
                        });


                    }
                });

                this.supplierOrders.challans.forEach(challan =>{
                    if (challan.challan_type == 'return' && this.form.supplier_id == challan.supplier_id) {
                        this.form.challans.push(challan);
                    }
                });

                this.form.items.forEach((item, key) => {
                    this.supplierOrders.returns.forEach((supplierReturns) => {
                        supplierReturns.items.forEach(returnItem => {
                            if (returnItem.supplier_order_item_id == item.supplier_order_item_id) {
                                this.form.items[key].price = returnItem.price;
                                this.form.items[key].quantity = returnItem.quantity;
                            }
                        });
                    });
                });
            }
        },

    })
</script>