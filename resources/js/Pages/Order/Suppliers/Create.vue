<template>
    <app-layout title="Supplier Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Order <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[  { route: 'suppliers.index'}, {route: 'supplier.order.index', name:'Orders'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'suppliers.index'}, {route: 'supplier.order.index', name:'Orders'} , {route: 'supplier.order.create', name:'Generate'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="supplier_id" required value="Supplier" />
                            <select id="supplier_id" required @change="changeSupplier($event)" v-model="form.supplier_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="supplier in suppliers" v-bind:value="supplier.id">{{ supplier.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.supplier_id" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="contact_person" value="Contact Person Name" />
                            <jet-input id="contact_person" type="text" class="mt-1 block" v-model="form.contact_person" autocomplete="contact_person"  readonly />
                            <jet-input-error :message="form.errors.contact_person" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="mobile" value="Mobile#" required />
                            <jet-input id="mobile" type="text" required class="mt-1 block" v-model="form.mobile" autocomplete="mobile" readonly />
                            <jet-input-error :message="form.errors.mobile" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="email" value="Email" required />
                            <jet-input id="email" type="text" required class="mt-1 block" v-model="form.email" autocomplete="email" readonly />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                    </div>

                    <div v-if="form.items.length" class="book-item-details">
                        <div class="book-item-header">
                            <p>Add books to list:
                            <span @click="addBook" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Book</span>
                            </p>
                            <div class="flex flex-row">
                                <div class="basis-1/4"><jet-label value="Select Book" /></div>
                                <div class="basis-1/4"><jet-label value="Class" /></div>
                                <div class="basis-1/4"><jet-label value="Subject" /></div>
                                <div class="basis-1/4"><jet-label value="Quantity" /></div>
                            </div>
                        </div>

                        <div class="book-item-body">
                            <div v-for="(item,index) in form.items" class="flex flex-row row1">
                                <div class="basis-1/4">
                                    <select v-model="item.book_id" @change="itemChange($event)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                        <option v-for="book in books" :value="book.id" v-text="book.name"></option>
                                    </select>
                                </div>

                                <div class="basis-1/4">
                                    <jet-input type="text" class="mt-1 block" v-model="item.class" readonly  />
                                </div>

                                <div class="basis-1/4">
                                    <jet-input type="text" class="mt-1 block" v-model="item.subject" readonly />
                                </div>

                                <div class="basis-1/4">
                                    <jet-input type="number" class="mt-1 block" v-model="item.quantity" />
                                </div>
                                <div class="basis-1/4">
                                    <button type="button" v-on:click="removeRow(index, item.id)" v-if="index > 0" >
                                      <span class="material-icons text-sm text-red-500">delete</span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-row">
                                <div class="basis-1/4"></div>

                                <div class="basis-1/4"></div>

                                <div class="basis-1/4"></div>

                                <div class="basis-1/4">
                                    <jet-input type="number" class="mt-1 block" readonly v-model="computeQuantity" />
                                </div>
                                <div class="basis-1/4">

                                </div>
                            </div>
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
    import { Link } from '@inertiajs/inertia-vue3';
    // import BookList from '@/Pages/Order/Supplier/BookList.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            JetInputError,
            Link,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple
            // BookList
        },
        props: ['suppliers','order'],
        data: () => ({
            edit: false,
            books: []
        }),
        setup () {
            const form = useForm({
              name: null,
              supplier_id: '',
              warehouse_id: '',
              date: new Date().toISOString().slice(0,10),
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
                axios.get(route('suppliers.books', this.form.supplier_id)).then(supplierBooks =>{
                    if(supplierBooks.data.books.length > 0){
                        this.books = supplierBooks.data.books;
                    }
                });
                this.edit = true;
            }
        },
        methods:{
            changeSupplier(event){
                this.form.items = [];
                this.suppliers.forEach((supplier, index) => {
                    if (supplier.id == event.target.value ) {
                        axios.get(route('suppliers.books', this.form.supplier_id)).then(supplierBooks =>{
                            if(supplierBooks.data.books.length > 0){
                                this.books = supplierBooks.data.books;
                                this.form.mobile = supplier.mobile;
                                this.form.email = supplier.email;
                                this.form.contact_person = supplier.contact_person;
                                this.addBook();
                            }else{
                                this.books = null;
                            }
                        });
                    }
                });
            },
            addBook(){
                const item = {
                    supplier_id : this.form.supplier_id,
                    publisher_id : '',
                    book_id : null,
                    class: '',
                    subject: '',
                    quantity: 0,
                };
                this.form.items.push(item);
            },

            itemChange(event){
                let book_id = event.target.value;
                let book = {};
                this.books.forEach((bookData) =>{
                    if (bookData.id == event.target.value) {
                        book = bookData;
                    }
                });
                if (book) {
                    this.form.items.forEach((item, index) =>{
                        if(item.book_id == event.target.value){
                            this.form.items[index].class= book.class;
                            this.form.items[index].subject= book.subject;
                            this.form.items[index].publisher_id= book.publisher_id;
                        }
                    });
                }
            },

            removeRow(index, item_id = null) {
                if (confirm('Are you sure?')) {
                    this.form.items.splice(index, 1);
                    if (item_id) {
                        axios.delete(route('supplier.order.item.delete', item_id));
                    }
                }
            },

            submitData(){
                let canSubmit  = true;
                this.form.items.forEach((item) =>{
                    if(!item.book_id){
                        canSubmit = false;
                    }
               });
               if (canSubmit) {
                    this.form.total_quantity = this.computeQuantity;
                    this.order ? this.form.put(route('supplier.order.update', this.order.id)) : this.form.post(route('supplier.order.store'));
               }else{
                    alert('Order items are not set properly, "please select the book in the list" ');
               }
            }
        }
    })
</script>