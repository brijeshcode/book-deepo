<template>
    <app-layout title="Supplier Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Order <span v-if="edit">Edit</span> <span v-else>Create</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" breadcrum flex items-center py-4 overflow-y-auto whitespace-nowrap">
                <Link :href="route('dashboard')" class="text-gray-600 dark:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </Link>

                <span class="mx-5 text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>

                <Link :href="route('suppliers')"  class="text-gray-600 dark:text-gray-200 hover:underline">Suppliers</Link>

                <span class="mx-5 text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>

                <Link :href="route('supplierOrder')"  class="text-gray-600 dark:text-gray-200 hover:underline">Orders</Link>

                <span class="mx-5 text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>

                <Link href="#" v-if="edit" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</Link>
                <Link :href="route('supplierOrder.create')" v-else  class="text-blue-600 dark:text-blue-400 hover:underline">Create</Link>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-2">
                        <form  @submit.prevent="submitData">
                            <div class="flex flex-row mb-4">

                                <div class="basis-1/4">
                                    <jet-label for="supplier_id" required="true" value="Supplier" />
                                    <select id="supplier_id" @change="changeSupplier($event)" v-model="form.supplier_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
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
                        axios.delete(route('supplierOrderItem.delete', item_id));
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
                    this.order ? this.form.put(route('supplierOrder.update', this.order.id)) : this.form.post(route('supplierOrder.store'));
               }else{
                    alert('Order items are not set properly, "please select the book in the list" ');
               }
            }
        }
    })
</script>