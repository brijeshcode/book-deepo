<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[  { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'schools.index'}, {route: 'school.order.index', name:'Orders'} , {route: 'school.order.create', name:'Generate'} ]" />
        </template>


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">

                <form  @submit.prevent="submitData">

                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">

                        <div class="">
                            <jet-label for="school_id" required value="School" />
                            <select id="school_id" @change="changeSchool($event)" v-model="form.school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" >
                                <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.school_id" class="mt-2" />
                        </div>

                        <div class="mb-4 ">
                            <jet-label for="contact_person" value="Contact Person Name" />
                            <jet-input id="contact_person" type="text" class="mt-1 w-full" v-model="form.contact_person" autocomplete="contact_person"  readonly />
                            <jet-input-error :message="form.errors.contact_person" class="mt-2" />
                        </div>

                        <div class="mb-4 ">
                            <jet-label for="mobile" value="Mobile#" required />
                            <jet-input id="mobile" type="text" class="mt-1 w-full" v-model="form.mobile" autocomplete="mobile" readonly />
                            <jet-input-error :message="form.errors.mobile" class="mt-2" />
                        </div>

                        <div class="mb-4 ">
                            <jet-label for="email" value="Email" required />
                            <jet-input id="email" type="text" class="mt-1 w-full" v-model="form.email" autocomplete="email" readonly />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="mb-4 ">
                            <jet-label for="expected_delivery_date" required value="Expected delivery date" />
                            <jet-input id="expected_delivery_date" type="date" class="mt-1 w-full" v-model="form.expected_delivery_date" autocomplete="expected_delivery_date" />
                            <jet-input-error :message="form.errors.expected_delivery_date" class="mt-2" />
                        </div>
                    </div>

                    <div v-if="form.items.length" class="book-item-details">
                        <div class="flex flex-row mb-4">
                            <p>Add books to list:
                                <span @click="addItem" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Book</span>
                            </p>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 border mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Select Book" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Class" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Publishers" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Suppliers" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Order To" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Quantity" /></th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Action" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in form.items">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <select v-model="item.book_id" @change="changeBook($event, index)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                            <option v-for="book in books" :value="book.id">{{ book.name }} - {{ book.quantity }}</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div v-if="item.book.id" class="flex text-gray-800">
                                            {{ item.book.class }}
                                        </div>
                                        <div v-if="item.book.id" class="flex text-xs">
                                            <Edit-link :edit="{route: 'books.edit', to:item.book.id }" class="text-xs" target="_blank" > View More </Edit-link>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div v-if="item.book.publisher">
                                            {{ item.book.publisher.name  }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <select v-model="item.supplier_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                            <option v-for="supplier in item.book.suppliers" :value="supplier.id">{{ supplier.name }}</option>
                                        </select>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <select v-model="item.order_to" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                            <option value="Publisher">Publisher</option>
                                            <option value="Supplier">Supplier</option>
                                        </select>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <jet-input type="number" style="width:70px" step="1" min="0" class="mt-1 block" v-model="item.quantity" />
                                        <!-- <group-input prefixlabel="Qty:" :prefix="item.book.quantity" type="number" claclassss="mt-1 block" v-model="item.quantity" /> -->
                                    </td>


                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <button type="button" v-on:click="removeRow(index, item.id)" v-if="index > 0" >
                                        <span class="material-icons text-sm text-red-500"><remove-icon /></span>
                                    </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
                                    <td class="p-4 whitespace-nowrap">{{ computeQuantity }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap"></td>
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'

    export default defineComponent({
        components: {
            EditLink,
            RemoveIcon,
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
        data: () => ({
            edit: false,
            books: []
        }),
        setup () {
            const form = useForm({
              school_id: '',
              date: new Date().toISOString().slice(0,10),
              email: '',
              expected_delivery_date: new Date().toISOString().slice(0,10),
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
                this.getBooks(this.order.school_id)

                this.edit = true;
                this.onEditBook();

                 console.log('test');
            }
        },
        methods:{
            changeSchool(event){
                this.form.items = [];
                this.schools.forEach((school, index) => {
                    if (school.id == event.target.value ) {
                        this.getBooks(school.id);
                        this.form.mobile = school.mobile;
                        this.form.email = school.email;
                        this.form.contact_person = school.contact_person;
                        this.addItem();
                    }
                });
            },
            addItem(){
                const item = {
                    school_id : this.form.school_id,
                    book_id : null,
                    class: '',
                    subject: '',
                    quantity: 0,
                    supplier_id: '',
                    publisher_id: '',
                    order_to: 'Publisher',
                    book: {}
                };
                this.form.items.push(item);
            },
            getBooks(school_id){
                axios.get(route('schools.books', school_id)).then(books =>{
                    this.books = books.data;
                });
            },

            changeBook(event , index){
                this.refreshBook(event.target.value, index);
            },

            refreshBook(book_id = '', itemIndex = ''){
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
                            if (itemIndex != '' ) {
                                if (index == itemIndex) {
                                    this.form.items[index].supplier_id = book.supplier_id;
                                }
                            }else{
                                this.form.items[index].supplier_id = book.supplier_id;
                            }
                            this.form.items[index].book = book;
                        }
                    });

                }
            },
            /*onEditBook(){
                console.log('in this fiunction body');
                console.log(this.form.items);
                this.books.forEach((bookData) =>{
                console.log('in books loop');
                console.log('in books loop');
                    this.form.items.forEach((item, index) =>{
                console.log('in item loop');
                        console.log(bookData.class);
                        if(item.book_id == bookData.id){
                            this.form.items[index].class= bookData.class;
                            this.form.items[index].subject= bookData.subject;
                            this.form.items[index].book = bookData;
                            this.form.items[index].publisher_id = bookData.publisher_id;
                            this.form.items[index].supplier_id = bookData.supplier_id;
                        }
                    });
                });
            },*/
            onEditBook(){
                this.order.items.forEach((orderItem) =>{
                    this.form.items.forEach((item, index) =>{

                        if(item.book_id == orderItem.book.id){
                            this.form.items[index].class= orderItem.book.class;
                            this.form.items[index].subject= orderItem.book.subject;
                            this.form.items[index].book = orderItem.book;
                            this.form.items[index].publisher_id = orderItem.publisher_id;
                            this.form.items[index].supplier_id = orderItem.supplier_id;
                            this.form.items[index].order_to = orderItem.order_to;
                        }
                    });
                });
            },

            removeRow(index, item_id = null) {
                if (confirm('Are you sure?')) {
                    this.form.items.splice(index, 1);
                    if (item_id) {
                        axios.delete(route('school.order.item.delete', item_id));
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
                    if (confirm('Are you sure you want to place this order')) {
                        this.order ? this.form.put(route('school.order.update', this.order.id)) : this.form.post(route('school.order.store'));
                    }
               }else{
                    alert('Order items are not set properly, "please select the book in the list" ');
               }
            }
        }
    })
</script>