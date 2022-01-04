<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[  { route: 'schools'}, {route: 'schoolOrder', name:'Orders'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'schools'}, {route: 'schoolOrder', name:'Orders'} , {route: 'schoolOrder.create', name:'Generate'} ]" />
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2">
                    <form  @submit.prevent="submitData">
                        <div class="flex flex-row mb-4">

                            <div class="basis-1/4">
                                <jet-label for="school_id" required="true" value="School" />
                                <select id="school_id" @change="changeSchool($event)" v-model="form.school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                    <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                                </select>
                                <jet-input-error :message="form.errors.school_id" class="mt-2" />
                            </div>

                            <div class="mb-4 basis-1/4">
                                <jet-label for="contact_person" value="Contact Person Name" />
                                <jet-input id="contact_person" type="text" class="mt-1 block" v-model="form.contact_person" autocomplete="contact_person"  readonly />
                                <jet-input-error :message="form.errors.contact_person" class="mt-2" />
                            </div>

                            <div class="mb-4 basis-1/4">
                                <jet-label for="mobile" value="Mobile#" required="true" />
                                <jet-input id="mobile" type="text" class="mt-1 block" v-model="form.mobile" autocomplete="mobile" readonly />
                                <jet-input-error :message="form.errors.mobile" class="mt-2" />
                            </div>

                            <div class="mb-4 basis-1/4">
                                <jet-label for="email" value="Email" required="true" />
                                <jet-input id="email" type="text" class="mt-1 block" v-model="form.email" autocomplete="email" readonly />
                                <jet-input-error :message="form.errors.email" class="mt-2" />
                            </div>
                        </div>

                        <div v-if="form.items.length" class="book-item-details">
                            <div class="flex flex-row">
                                <p>Add books to list:
                                <span @click="addBook" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Book</span>
                                </p>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th><jet-label value="Select Book" /></th>
                                        <th><jet-label value="Details" /></th>
                                        <th><jet-label value="Quantity" /></th>
                                        <th><jet-label value="Order To" /></th>
                                        <th><jet-label value="Action" /></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in form.items">
                                        <td>
                                            <select v-model="item.book_id" @change="itemChange($event)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                                <option v-for="book in books" :value="book.id">{{ book.name }} - {{ book.quantity }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="item.book.sku_no" class="flex text-gray-800">

                                                <div class=" flex-1 rounded-md shadow-lg shadow-sm mr-2  ">
                                                    <div class=" card">
                                                        <div class="card-head pt-2 pb-2 border-b text-center flex">
                                                            <div class="font-bold w-full">Book</div>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="block">#: {{ item.book.sku_no }}</div>
                                                            <div class="block">
                                                            {{ item.book.class }}, <div class="right flex-1 text-sm "> {{ item.book.subject }}</div>
                                                            <div class="block">Qty: {{ item.book.quantity }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div v-if="item.book.supplier" class="flex-1 rounded-md shadow-lg mr-2">
                                                    <div class=" card">
                                                        <div class="card-head pt-2 pb-2 border-b text-center flex">
                                                            <div class="font-bold w-full">Supplier</div>
                                                        </div>

                                                        <div class="card-body p-2 text-cener">
                                                            <div class="right block ">{{ item.book.supplier.name }}</div>
                                                            <div class="block ">{{ item.book.supplier.email }}</div>
                                                            <div class="block text-sm ">{{ item.book.supplier.mobile }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div v-if="item.book.publisher" class="flex-1 rounded-md shadow-lg  ">
                                                    <div class=" card">
                                                        <div class="card-head pt-2 pb-2 border-b text-center flex">
                                                            <div class="font-bold w-full">Publisher</div>
                                                        </div>
                                                        <div class="card-body p-2 text-cener">
                                                            <div class="right block">{{ item.book.publisher.name }}</div>
                                                            <div class="block">{{ item.book.publisher.email }}</div>
                                                            <div class="block">{{ item.book.publisher.mobile }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <jet-input type="number" style="width:70px" step="1" min="0" class="mt-1 block" v-model="item.quantity" />
                                            <!-- <group-input prefixlabel="Qty:" :prefix="item.book.quantity" type="number" class="mt-1 block" v-model="item.quantity" /> -->
                                        </td>
                                        <td>
                                            <select v-model="item.order_to" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                                <option value="Supplier">Supplier</option>
                                                <option value="Publisher">Publisher</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" v-on:click="removeRow(index, item.id)" v-if="index > 0" >
                                          <span class="material-icons text-sm text-red-500">delete</span>
                                        </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><jet-input type="number" class="mt-1 block" style="width:70px" readonly v-model="computeQuantity" /></td>
                                        <td></td>
                                        <td></td>
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
    // import BookList from '@/Pages/Order/School/BookList.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
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
        props: ['schools','order', 'books'],
        data: () => ({
            edit: false
        }),
        setup () {
            const form = useForm({
              school_id: '',
              date: '',
              email: '',
              mobile: '',
              fax : '',
              contact_person: '',
              note: '',
              total_quantity: 0,
              total_amount: 0,
              items: []
            });

            return { form  }
        },
        computed: {
            computeQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                return qty;
            }
        },
        created(){
            if (this.order) {
                Object.keys(this.order).forEach((index) => {
                    this.form[index] = this.order[index];
                });
                this.edit = true;
                this.onEditBook();
            }
        },
        methods:{
            changeSchool(event){
                this.form.items = [];
                this.schools.forEach((school, index) => {
                    if (school.id == event.target.value ) {
                        this.form.mobile = school.mobile;
                        this.form.email = school.email;
                        this.form.contact_person = school.contact_person;
                        this.addBook();
                    }
                });
            },
            addBook(){
                const item = {
                    school_id : this.form.school_id,
                    book_id : null,
                    class: '',
                    subject: '',
                    quantity: 0,
                    supplier_id: '',
                    publisher_id: '',
                    order_to: 'Supplier',
                    book: {}
                };
                this.form.items.push(item);

            },

            itemChange(event){
                this.refreshBook(event.target.value);
            },
            refreshBook(book_id = ''){
                let book = {};
                this.books.forEach((bookData) =>{
                    if (bookData.id == book_id) {
                        book = bookData;
                    }
                });
                if (book) {
                    this.form.items.forEach((item, index) =>{
                        if(item.book_id == event.target.value){
                            this.form.items[index].class= book.class;
                            this.form.items[index].subject= book.subject;
                            this.form.items[index].publisher_id = book.publisher_id;
                            this.form.items[index].supplier_id = book.supplier_id;
                            this.form.items[index].book = book;
                        }
                    });
                }
            },
            onEditBook(){
                this.books.forEach((bookData) =>{
                    this.form.items.forEach((item, index) =>{
                        if(item.book_id == bookData.id){
                            this.form.items[index].class= bookData.class;
                            this.form.items[index].subject= bookData.subject;
                            this.form.items[index].book = bookData;
                            this.form.items[index].publisher_id = bookData.publisher_id;
                            this.form.items[index].supplier_id = bookData.supplier_id;
                        }
                    });
                });
            },

            removeRow(index, item_id = null) {
                if (confirm('Are you sure?')) {
                    this.form.items.splice(index, 1);
                    if (item_id) {
                        axios.delete(route('schoolOrderItem.delete', item_id));
                    }
                }
            },
            checkStock(){
                this.form.post(route('school.checkStock', this.form.school_id));
            },
            submitData(){
                let canSubmit  = true;
                this.form.items.forEach((item, key) =>{
                    if(!item.book_id){
                        canSubmit = false;
                    }
                    delete this.form.items[key].book;
                    delete this.form.items[key].system_cost;
               });
               if (canSubmit) {
                    this.form.total_quantity = this.computeQuantity;
                    this.order ? this.form.put(route('schoolOrder.update', this.order.id)) : this.form.post(route('schoolOrder.store'));
               }else{
                    alert('Order items are not set properly, "please select the book in the list" ');
               }
            }
        }
    })
</script>