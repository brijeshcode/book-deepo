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
                <form  @submit.prevent=" book ? form.put(route('books.update', book.id)) : form.post(route('books.store'))">

                    <div class="flex flex-row mb-4">
                        <div class="basis-1/4">
                            <jet-label for="sku_no" required="true" value="SKU#" />
                            <jet-input id="sku_no" type="text" class="mt-1 block" v-model="form.sku_no" autocomplete="sku_no" />
                            <jet-input-error :message="form.errors.sku_no" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mb-4" >
                        <div class="basis-1/4">
                            <jet-label for="name" required="true" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="author_name" value="Author Name" />
                            <jet-input id="author_name" type="text" class="mt-1 block" v-model="form.author_name" autocomplete="author_name" />
                            <jet-input-error :message="form.errors.author_name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="class" required="true" value="Class" />
                            <jet-input id="class" type="text" required="true"  class="mt-1 block" v-model="form.class" autocomplete="class" />
                            <jet-input-error :message="form.errors.class" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="subject" required="true" value="Subject" />
                            <jet-input id="subject" type="text" required="true" class="mt-1 block" v-model="form.subject" autocomplete="class" />
                            <jet-input-error :message="form.errors.subject" class="mt-2" />
                        </div>
                    </div>


                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="quantity" required="true" value="Quantity" />
                            <jet-input id="quantity" type="text" class="mt-1 block" v-model="form.quantity" autocomplete="quantity" />
                            <jet-input-error :message="form.errors.quantity" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="cost" value="Cost" />
                            <jet-input id="cost" type="text" class="mt-1 block" v-model="form.cost" autocomplete="cost" />
                            <jet-input-error :message="form.errors.cost" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="description"  value="Description" />
                            <jet-input id="description" type="text" class="mt-1 block" v-model="form.description" autocomplete="description" />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="note" value="Note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.note" autocomplete="note" />
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mb-4">
                        <div class="basis-1/4">
                            <jet-label for="supplier_id" value="Supplier" />
                            <select id="supplier_id" v-model="form.supplier_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="supplier in suppliers" v-bind:value="supplier.id">{{ supplier.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.supplier_id" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="publisher_id" required="true" value="Publisher" />
                            <select id="publisher_id" v-model="form.publisher_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="publisher in publishers" v-bind:value="publisher.id">{{ publisher.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.publisher_id" class="mt-2" />
                        </div>

                         <div class="basis-1/4">
                            <jet-label for="warehouse_id" required="true" value="Warehouse" />
                            <select id="warehouse_id" @change="changeWarehouse($event)" v-model="form.warehouse_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="warehouse in warehouses" v-bind:value="warehouse.id">{{ warehouse.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.warehouse_id" class="mt-2" />
                        </div>

                        <div class="basis-1/4" v-if="schools.length > 0">
                            <jet-label for="school_id" required="true" value="School" />
                            <select id="school_id" v-model="form.school_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.school_id" class="mt-2" />
                        </div>
                    </div>



                    <div class="mb-4">
                        <label class="flex items-center">
                            <jet-checkbox name="active" v-model:checked="form.active" />
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

    export default defineComponent({
        components: {
            JetInputError,
            BreadSimple,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox
        },
        props: ['book','suppliers', 'publishers', 'warehouses'],
         data: () => ({
            edit: false,
            schools : [],
            school_name : ''
         }),
        setup () {
            const form = useForm({
              supplier_id: '',
              publisher_id: '',
              warehouse_id: '',
              school_id: '',
              name: '',
              subject: '',
              author_name: '',
              class: '',
              description: null,
              note: '',
              sku_no: '',
              quantity: 0,
              cost: 0,
              active: false
            })

            return { form  }
        },

        created(){
            if (this.book) {
                Object.keys(this.book).forEach((index) => {
                    this.form[index] = this.book[index];
                });
                this.getSchoolByWarehouse(this.book.warehouse_id)
                this.edit = true;
            }
        },
        methods:{
            changeWarehouse(event){
                this.getSchoolByWarehouse(event.target.value);
            },
            getSchoolByWarehouse(warehouse_id){
                axios.get(route('warehouse.schools', warehouse_id)).then(warehouseSchools =>{
                    this.schools = warehouseSchools.data;
                });
            }/*,
            changeSchool(event){
                this.school_name = event.target.options[event.target.options.selectedIndex].text;
            }*/
        }
    })
</script>
