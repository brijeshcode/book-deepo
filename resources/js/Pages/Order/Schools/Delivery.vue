<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order Delivery
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[ { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} , {name:'Delivery'} ]" />
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

                        <!-- Order Item details section -->
                        <div class="flex my-4">
                            Delivery From
                            <select @change="deliveryFromChange($event)" v-model='deliveryFrom' class="ml-2">
                                    <option v-for="order in supplierOrders" data-deliveryType="supplier" :value="order.id">{{ order.supplier.name }}</option>
                                    <option v-for="order in publisherOrders" data-deliveryType="publisher" :value="order.id">{{ order.publisher.name }}</option>
                                </select>
                        </div>

                        <!-- Order Item details section -->
                        <div class="text-xl uppercase px-4 mt-4 " v-if="form.items.length > 0">
                            Delivery Items
                            <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                        </div>
                        <div v-if="form.items.length > 0" class="book-item-details">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mb-2">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Book" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Request Quantity" />
                                            </th>

                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Delivery Quantity" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Unit Price" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Price" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Discount %" />
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <jet-label value="Total Price" />
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in form.items">
                                            <td class="px-4 py-4 whitespace-nowrap"> {{ item.book_name }} </td>
                                            <td class="px-4 py-4 whitespace-nowrap">{{ item.quantity_requested }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="number" @change="priceChange(index)" style="width:120px" step="1" min="0" :max="item.quantity_requested" class="mt-1 block" v-model="item.quantity" />
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="number" @change="priceChange(index)" style="width:120px" step="1" min="0" class="mt-1 block" v-model="item.unit_price" />
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="number" @change="priceChange(index)" style="width:120px" step="1" min="0" class="mt-1 block" v-model="item.price" />
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="number" @change="priceChange(index)" style="width:100px" step="1" min="0" max="100" class="mt-1 block" v-model="item.discount_percent" />
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <jet-input type="number" readonly @change="amountChange(index)" style="width:120px" step="1" min="0" class="mt-1 block" v-model="item.price_total" />

                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="px-4 py-4 whitespace-nowrap"><jet-input type="number" class="mt-1 block" style="width:120px" readonly v-model="computeDeliveryQuantity" /></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><jet-input type="number" class="mt-1 block" style="width:120px" readonly v-model="computeTotalAmount" /></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Order Item details section -->
                        <div class="text-xl uppercase px-4 mt-4 " v-if="form.items.length > 0">
                            Delivery Challans    <span class="p-2 bg-gray-800 text-white m-2 " @click="addChallan">Add </span>
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
                                            <th>
                                                 <span class="p-2 bg-gray-800 text-white m-2 " @click="addChallan">Add </span>
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
                                                <jet-input type="file" v-model="challan.path" />
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            EditLink,
            Link,
            RemoveIcon,
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
        props: ['order', 'publisherOrders', 'supplierOrders'],
        data: () => ({
            edit: false,
            deliveryType: '',
            deliveryFrom : '',
        }),
        setup () {
            const form = useForm({
              date: new Date().toISOString().slice(0,10),
              publisher_id: '',
              publisher_order_id: '',
              supplier_id: '',
              supplier_order_id: '',
              school_id: '',
              school_order_id: '',
              quantity: 0,
              discount_percent: 0,
              discount: 0,
              sub_total: 0,
              total_amount: 0,
              note: '',
              items: [],
              challans: [],
            });

            return { form  }
        },
        computed: {
            computeDeliveryQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                this.form.quantity = qty;
                return qty;
            }
            ,
            computeTotalAmount: function () {
                let amt = 0;
                this.form.items.forEach((item) =>{ amt += parseInt(item.price_total); });
                this.form.total_amount = amt;
                return amt;
            }

        },
        created(){
            if (this.order) {
                this.form.school_order_id = this.order.id;
                this.form.school_id = this.order.school_id;

                /*Object.keys(this.order).forEach((index) => {
                    this.form[index] = this.order[index];
                });*/
                /*this.order.items.forEach((item, index) => {
                    console.log(item);
                    var orderItem = {
                        delivery_quantity : 0,
                        book_name : item.book.name,
                        publisher_name : item.publisher.name,
                        supplier_id : item.supplier_id,
                        publisher_id : item.publisher_id,
                        school_order_id : item.school_order_id,
                        school_order_item_id : item.id,
                        order_to : item.order_to,
                        book_id : item.book_id,
                        // quantity : item.quantity - item.quantity_recived,
                        quantity : 0,
                        price : 0,
                        amount: 0,
                        request_quantity : item.quantity,
                        quantity_recived : item.quantity_recived
                    };
                    if (item.supplier) {
                        orderItem.supplier_name = item.supplier.name;
                    }

                    this.form.items.push(orderItem);
                });*/

            }
        },
        methods:{
            submitData(){
                    this.deliveryType == 'supplier' ? this.form.post(route('supplier.delivery.store'))  : this.form.post(route('publisher.delivery.store')) ;
            },
            priceChange(index){
                this.form.items[index].price = this.form.items[index].unit_price * this.form.items[index].quantity;
                this.form.items[index].price_total = this.calculateDiscount(index, this.form.items[index].price);
            },
            amountChange(index){
                this.form.items[index].price = this.calculateDiscount(index, this.form.items[index].price_total) / this.form.items[index].quantity;
                this.calculateDiscount(index);
            },
            calculateDiscount(index, amount){
                return amount - (this.form.items[index].discount_percent / 100) * amount;
            },
            deliveryFromChange(event){
                this.form.items = [];
                this.form.challans= [];

                let order_id = event.target.value;
                this.deliveryType  = event.target.selectedOptions[0].dataset.deliverytype;
                this.deliveryType == 'supplier' ? this.supplierItems(order_id)  : this.publisherItems(order_id) ;
            },

            addChallan(){
                this.deliveryType == 'supplier' ? this.supplierChallans()  : this.publissherChallans() ;
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
                    payment_status: 'Due',
                    amount: 0,
                    note:''
                });
            },

            removeChallan(index) {
                if (confirm('Are you sure?')) { this.form.challans.splice(index, 1); }
            },

            supplierItems(order_id){
                this.form.supplier_order_id = order_id;
                this.supplierOrders.forEach(order => {
                    if (order.id == order_id) {
                        this.form.supplier_id = order.supplier_id;
                        order.items.forEach(item => {
                            if (item.quantity_recived >= item.quantity) {return;}

                            this.form.items.push({
                                supplier_order_item_id: item.id ,
                                book_name: item.book.name,
                                book_id: item.book_id,
                                quantity_requested: item.quantity,
                                quantity_recived: item.quantity_recived,
                                quantity: item.delivery == null ? 0 : item.delivery.quantity,
                                unit_price: item.delivery == null ? 0 : item.delivery.unit_price,
                                price: item.delivery == null ? 0 : item.delivery.price,
                                discount_percent: item.delivery == null ? 0 : item.delivery.discount_percent,
                                discount_total: item.delivery == null ? 0 : item.delivery.discount_total,
                                price_total:item.delivery == null ? 0 : item.delivery.price_total
                            });
                        });

                        order.challans.forEach(challan => {
                            this.form.challans.push(challan);
                        });
                    }
                });
            },

            publisherItems(order_id){
                this.form.publisher_order_id = order_id;
                this.publisherOrders.forEach(order => {
                    if (order.id == order_id) {
                        this.form.publisher_id = order.publisher_id;
                        order.items.forEach(item => {
                            if (item.quantity_recived >= item.quantity) { return; }
                            this.form.items.push({
                                publisher_order_item_id: item.id ,
                                book_name: item.book.name,
                                book_id: item.book_id,
                                quantity_requested: item.quantity,
                                quantity_recived: item.quantity_recived,
                                quantity: item.delivery == null ? 0 : item.delivery.quantity,
                                unit_price: item.delivery == null ? 0 : item.delivery.unit_price,
                                price: item.delivery == null ? 0 : item.delivery.price,
                                discount_percent: item.delivery == null ? 0 : item.delivery.discount_percent,
                                discount_total: item.delivery == null ? 0 : item.delivery.discount_total,
                                price_total:item.delivery == null ? 0 : item.delivery.price_total
                            });
                        });

                        order.challans.forEach(challan => {
                            this.form.challans.push(challan);
                        });
                    }
                });
            }
        },

    })
</script>