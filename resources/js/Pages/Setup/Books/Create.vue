<template>
    <app-layout title="Book">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'books'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'books'}, {route: 'books.create', name:'add'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="submit">

                    <div class="flex flex-row mb-4">
                        <div class="basis-1/4">
                            <jet-label for="sku_no" required value="SKU#" />
                            <jet-input id="sku_no" type="text" class="mt-1 block" v-model="form.book.sku_no" autocomplete="sku_no" />
                            <jet-input-error :message="form.errors.sku_no" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mb-4" >
                        <div class="basis-1/4">
                            <jet-label for="name" required value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.book.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="author_name" value="Author Name" />
                            <jet-input id="author_name" type="text" class="mt-1 block" v-model="form.book.author_name" autocomplete="author_name" />
                            <jet-input-error :message="form.errors.author_name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="class" required value="Class" />
                            <jet-input id="class" type="text" required  class="mt-1 block" v-model="form.book.class" autocomplete="class" />
                            <jet-input-error :message="form.errors.class" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="subject" required value="Subject" />
                            <jet-input id="subject" type="text" required class="mt-1 block" v-model="form.book.subject" autocomplete="class" />
                            <jet-input-error :message="form.errors.subject" class="mt-2" />
                        </div>
                    </div>


                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="quantity" required value="Quantity" />
                            <jet-input id="quantity" type="number" step="1" min="0" class="mt-1 block" v-model="form.book.quantity" autocomplete="quantity" />
                            <jet-input-error :message="form.errors.quantity" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="cost" value="Cost" />
                            <jet-input id="cost" type="number" step="0.01" min="0" class="mt-1 block" v-model="form.book.cost" autocomplete="cost" />
                            <jet-input-error :message="form.errors.cost" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="description"  value="Description" />
                            <jet-input id="description" type="text" class="mt-1 block" v-model="form.book.description" autocomplete="description" />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="note" value="Note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.book.note" autocomplete="note" />
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mb-4">


                        <div class="basis-1/4">
                            <jet-label for="location_id" required value="Choose Location" />
                            <select id="location_id" @change="changeLocation($event)"  v-model="form.book.location_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="location in locations" v-bind:value="location.id">{{ location.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.location_id" class="mt-2" />
                        </div>

                        <div class="basis-1/4" v-if="publishers.length > 0">
                            <jet-label for="publisher_id" required value="Publisher" />
                            <select id="publisher_id" v-model="form.book.publisher_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="publisher in publishers" v-bind:value="publisher.id">{{ publisher.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.publisher_id" class="mt-2" />
                        </div>

                         <div class="basis-1/4" v-if="warehouses.length > 0">
                            <jet-label for="warehouse_id" required value="Warehouse" />
                            <select id="warehouse_id" @change="changeWarehouse($event)" v-model="form.book.warehouse_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="warehouse in warehouses" v-bind:value="warehouse.id">{{ warehouse.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.warehouse_id" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row md-4" >
                        <div class=" my-2 w-full " v-if="suppliers.length > 0">
                            <span @click="addSupplier" class="bg-indigo-500 text-white hover:bg-indigo-600 font-bold p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add supplier</span>

                            <div class="block" v-for="(supplierList,index) in suppliersIds">
                                <div class="flex">
                                    <select v-model="supplierList.id" class="w-60 my-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                        <option v-for="supplier in suppliers" v-bind:value="supplier.id">{{ supplier.name }}</option>
                                    </select>
                                    <button type="button" v-on:click="removeSupplier(index)" class="ml-4" v-if="index > 0" >
                                      <span class="material-icons text-sm text-red-500"><remove-icon /></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="my-2  w-full " v-if="schools.length > 0">
                            <span @click="addSchool" class="bg-indigo-500 text-white hover:bg-indigo-600 font-bold p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add School</span>
                                <div class="block" v-for="(schoolList,index) in schoolIds">
                                    <div class="flex">
                                        <select  v-model="schoolList.id" class="w-60 my-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                            <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                                        </select>
                                        <button type="button" @click="removeSchool(index)" class="ml-4" v-if="index > 0">
                                          <span class="material-icons text-sm text-red-500 "><remove-icon /></span>
                                        </button>

                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <jet-checkbox name="active" v-model:checked="form.book.active" />
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
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
    import { Link } from '@inertiajs/inertia-vue3';
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'

    export default defineComponent({
        components: {
            JetInputError,
            RemoveIcon,
            BreadSimple,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox
        },
        props: ['book', 'locations' ],
        data: () => ({
            edit: false,
            schools : [],
            schoolIds : [],
            suppliersIds : [],
            publishers: [],
            suppliers: [],
            warehouses: [],
            school_name : ''
         }),
        setup () {
            const form = useForm({
                book: {},
                schools: [],
                suppliers: [],
            });

            return { form  }
        },

        created(){
            this.form.book = {
                location_id: '',
                publisher_id: '',
                warehouse_id: '',
                cost: 0,
                name: '',
                note: '',
                class: '',
                sku_no: '',
                subject: '',
                quantity: 0,
                active: false,
                author_name: '',
                description: null
            };
            if (this.book) {
                Object.keys(this.book).forEach((index) => {
                    this.form.book[index] = this.book[index];
                });
                Object.keys(this.book.schools).forEach((index) => {
                    this.schoolIds.push({id: this.book.schools[index].id});
                });

                Object.keys(this.book.suppliers).forEach((index) => {
                    this.suppliersIds.push({id: this.book.suppliers[index].id});
                });

                this.getPublishersByLocation(this.book.location_id);
                this.getSuppliersByLocation(this.book.location_id);
                this.getWarehousesByLocation(this.book.location_id);
                this.getSchoolByWarehouse(this.book.warehouse_id)
                this.edit = true;
            }
        },
        methods:{
            addSchool(){
                // this.form.schools.push({ id: ''});
                this.schoolIds.push({id: ''});
                // Vue.util.extend({}, this.form.skill)
            },
            addSupplier(){ this.suppliersIds.push({ id: ''}); },
            removeSupplier(index){ if (confirm('Are you sure?')) this.suppliersIds.splice(index, 1); },
            removeSchool(index){ if (confirm('Are you sure?')) this.schoolIds.splice(index, 1); },
            changeWarehouse(event){ this.getSchoolByWarehouse(event.target.value); },
            changeLocation(event){
                this.warehouses = [];
                this.publishers = [];
                this.form.suppliers = [];
                this.form.schools = [];
                this.getPublishersByLocation(event.target.value);
                this.getSuppliersByLocation(event.target.value);
                this.getWarehousesByLocation(event.target.value);

            },

            getSchoolByWarehouse(warehouse_id){
                axios.get(route('warehouse.schools', warehouse_id)).then(warehouseSchools =>{
                    this.schools = warehouseSchools.data;
                    if (this.schools.length < 1) {
                        alert('Please add School to this warehouse before you add book here. because book must have connection to atleast one school');
                    }
                });
            },
            getPublishersByLocation(location_id){
                axios.get(route('location.publishers', location_id)).then(locationPubliser =>{
                    this.publishers = locationPubliser.data;
                    if (this.publishers.length < 1) {
                        alert('Please add Publisher on this location before you add book here, becuase book must have atleast one publisher.');
                    }

                });
            },
            getSuppliersByLocation(location_id){
                axios.get(route('location.suppliers', location_id)).then(locationSupplier =>{
                    this.suppliers = locationSupplier.data;
                });
            },
            getWarehousesByLocation(location_id){
                axios.get(route('location.warehouses', location_id)).then(locationWarehouse =>{
                    this.warehouses = locationWarehouse.data;
                    if (this.warehouses.length < 1) {
                        alert('please add warehouse on this location before you add book here, because book must have connected to some warehouse.');
                    }
                });
            },
            submit(){
                let schoolId = [];
                let supplierId = [];

                this.schoolIds.forEach((school,index)=>{
                    schoolId.push(school.id);
                })

                this.suppliersIds.forEach((supplier,index)=>{
                    supplierId.push(supplier.id);
                })

                this.form.schools = schoolId;
                this.form.suppliers = supplierId;
                console.log(this.form.schools);
                this.book ? this.form.put(route('books.update', this.book.id)) : this.form.post(route('books.store'))
            }

        },
        watch:{
            warehouses:  function(warehouseData){
                if (warehouseData.length == 0) {
                    this.schools = [];
                }
            }
         }
    })
</script>
