<template>
    <app-layout title="Sales">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ {route: 'sales'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'sales'}, {route: 'sales.create', name:'Generate'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submitData">
                    <div class="flex flex-row mb-4">
                        <div class="mb-4 basis-1/4">
                            <jet-label for="date" required value="Date" />
                            <jet-input id="date" type="date" class="mt-1 block" v-model="form.date" autocomplete="date" />
                            <jet-input-error :message="form.errors.date" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="school_id" required value="Schools" />
                            <select id="school_id" @change="schoolChange($event)" v-model="form.school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.school_id" class="mt-2" />
                        </div>

                        <div class="flex-col" v-if="bundles.length > 0">
                            <jet-label for="bundle_id" required value="Bundle" />
                            <select id="bundle_id" @change="bundleChange($event)" v-model="form.bundle_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="bundle in bundles" v-bind:value="bundle.id">{{ bundle.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.bundle_id" class="mt-2" />
                        </div>


                    </div>

                    <div class="flex flex-row mb-4">
                        <div class="mb-4 basis-1/4">
                            <jet-label for="student_name" required value="Student Name" />
                            <jet-input id="student_name" type="text" class="mt-1 block" v-model="form.student_name" autocomplete="student_name"  />
                            <jet-input-error :message="form.errors.student_name" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="student_email" value="Student Email" />
                            <jet-input id="student_email" type="email" class="mt-1 block" v-model="form.student_email" autocomplete="student_email"  />
                            <jet-input-error :message="form.errors.student_email" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="student_mobile" value="Student Mobile" />
                            <jet-input id="student_mobile" type="text" class="mt-1 block" v-model="form.student_mobile" autocomplete="student_mobile"  />
                            <jet-input-error :message="form.errors.student_mobile" class="mt-2" />
                        </div>

                    </div>

                    <div v-if="form.items.length" class="book-item-details">
                         <!-- <p>Add books to list:
                            <span @click="addItem" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Book</span>
                            </p> -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Books</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Quantity</th>
                                    <th>Cost </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in form.items">
                                    <td>
                                        <!-- <select v-model="item.book_id" readonly @change="itemChange($event)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                            <option v-for="book in books" :value="book.id" v-text="book.name"></option>
                                        </select> -->
                                        <jet-input type="text" v-model="item.book_name" disabled  />

                                    </td>
                                    <td>
                                        <jet-input type="text" class="mt-1 block" v-model="item.class" readonly  />
                                    </td>
                                    <td>
                                        <jet-input type="text" class="mt-1 block" v-model="item.subject" readonly />
                                    </td>
                                    <td>
                                        <input-group type="number" class="mt-1 block" :prefix="item.system_quantity" prefixlabel="Qty:" v-model="item.quantity" />
                                    </td>
                                    <td>
                                        <jet-input type="number" class="mt-1 block" v-model="item.cost" />
                                    </td>
                                    <td>
                                       <button type="button" v-on:click="removeRow(index, item.id)" v-if="index > 0" >
                                          <span class="material-icons text-sm text-red-500"><remove-icon /></span>
                                       </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <jet-input type="number" class="mt-1 block" readonly v-model="computeQuantity" />
                                    </td>
                                    <td>
                                        <jet-input type="number" class="mt-1 block" readonly v-model="computeCost" />
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="mb-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" >Save</jet-button>
                        <jet-button class="ml-4" >Save & Pring</jet-button>
                    </div>
                </form>
            </div>
        </div>
        <!-- <div class="notifications" v-if="$page.props.flash.message">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8  ">
                <Alerts :type="$page.props.flash.type" :message="$page.props.flash.message" />
            </div>
        </div> -->
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import InputGroup from '@/Shared/Components/Form/Simple/InputGroup.vue'
    import { Inertia } from '@inertiajs/inertia'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'

    export default defineComponent({
        components: {
            JetInputError,
            RemoveIcon,
            InputGroup,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            BreadSimple
        },
        props: ['schools','sale'],
        data: () => ({
            edit: false,
            books: [],
            bundles: []
        }),
        setup () {
            const form = useForm({
              name: null,
              date: new Date().toISOString().slice(0,10),
              school_id: '',
              bundle_id: '',
              student_name: '',
              student_email: '',
              student_mobile: '',
              total_quantity: 0,
              total_amount: 0,
              note: '',
              items: []
            });

            return { form  }
        },
        computed: {
            computeQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                return qty;
            },
            computeCost: function () {
                let cost = 0;
                this.form.items.forEach((item) =>{ cost += parseInt(item.cost); });
                return cost;
            }
        },
        created(){
            if (this.sale) {
                Object.keys(this.sale).forEach((index) => {
                    this.form[index] = this.sale[index];
                });
                axios.get(route('schools.bundles', this.form.school_id)).then(bundles =>{
                    if(bundles.data.length > 0){
                        this.bundles = bundles.data;
                    }
                });
                this.edit = true;

            }
        },
        methods:{
            schoolChange(event){
                this.form.items = [];
                this.getBundle(event.target.value);
            },

            getBundle(school_id){
                axios.get(route('schools.bundles', school_id)).then(bundles =>{
                    this.bundles = bundles.data;
                });
            },
            bundleChange(event){
                this.form.items = [];
                this.books = []; // reset the book array
                this.bundles.forEach((bundle) =>{
                    if (event.target.value == bundle.id) {
                        bundle.items.forEach((item) =>{
                            this.books.push(item.book);
                            this.form.items.push( {
                                school_id : this.form.school_id,
                                book_id : item.book.id,
                                bundle_id: this.form.bundle_id,
                                class: item.book.class,
                                subject: item.book.subject,
                                quantity: item.quantity,
                                cost: item.book.cost,
                                book_name: item.book.name,
                                system_quantity: item.book.quantity,
                            });
                        });
                    }
                });
            },
            addItem(){
                const item = {
                    school_id : this.form.school_id,
                    bundle_id: this.form.bundle_id,
                    book_name : '',
                    book_id : null,
                    class: '',
                    subject: '',
                    quantity: 0,
                    cost: 0,
                    system_quantity: 0
                };
                this.form.items.push(item);
            },
            /*itemChange(event){
                let book_id = event.target.value;
                let book = {};
                this.books.forEach((bookData) =>{
                    if (bookData.id == event.target.value) {
                        book = bookData;
                    }
                });
                console.log(book);
                if (book) {
                    this.form.items.forEach((item, index) =>{
                        if(item.book_id == event.target.value){
                            this.form.items[index].class= book.class;
                            this.form.items[index].subject= book.subject;
                            this.form.items[index].cost= book.cost;
                            this.form.items[index].book_name = book.name;
                            this.form.items[index].system_quantity= book.quantity;
                        }
                    });
                }
            },*/

            removeRow(index, item_id = null) {
                if (confirm('Are you sure?')) {
                    this.form.items.splice(index, 1);
                    /*if (item_id) {
                        axios.delete(route('publisherOrderItem.delete', item_id));
                    }*/
                }
            },

            submitData(){
                let canSubmit  = true;
                this.form.items.forEach((item, key) =>{
                    if(!item.book_id){
                        canSubmit = false;
                    }
                    /*delete this.form.items[key].system_quantity;
                    delete this.form.items[key].book_name;*/
               });
               if (canSubmit) {
                    this.form.total_quantity = this.computeQuantity;
                    this.form.total_amount = this.computeCost;
                    this.sale ? this.form.put(route('sales.update', this.sale.id)) : this.form.post(route('sales.store'));
               }else{
                    // alert('Order items are not set properly, "please select the book in the list" ');
               }
            }
        }
    })
</script>