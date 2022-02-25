<template>
    <app-layout title="School">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'schools.index'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'schools.index'}, {route: 'schools.create', name:'add'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2 mt-4">
                <form  @submit.prevent="submitData">

                    <div class="flex flex-row">
                        <div class="mb-4 basis-1/4">
                            <jet-label for="warehouse_id" required value="Warehouse" />
                            <select id="warehouse_id" @change="newLocation($event)" v-model="form.warehouse_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="warehouse in warehouses" v-bind:value="warehouse.id">{{ warehouse.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.warehouse_id" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="city" required value="City" />
                            <jet-input id="city" type="text" class="mt-1 block" readonly v-model="form.city" autocomplete="city" />
                            <jet-input-error :message="form.errors.city" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="state" required value="State" />
                            <jet-input id="state" type="text" class="mt-1 block" readonly v-model="form.state" autocomplete="state" />
                            <jet-input-error :message="form.errors.state" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="pincode" required value="Pincode" />
                            <jet-input id="pincode" type="text" class="mt-1 block" v-model="form.pincode" autocomplete="pincode" />
                            <jet-input-error :message="form.errors.pincode" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row">
                        <div class="mb-4 basis-1/4">
                            <jet-label for="name" required value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="contact_person" value="Contact Person Name" />
                            <jet-input id="contact_person" type="text" class="mt-1 block" v-model="form.contact_person" autocomplete="contact_person" />
                            <jet-input-error :message="form.errors.contact_person" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="mobile" value="Mobile#" required />
                            <jet-input id="mobile" type="text" class="mt-1 block" v-model="form.mobile" autocomplete="mobile" />
                            <jet-input-error :message="form.errors.mobile" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="email" value="Email" required />
                            <jet-input id="email" type="text" class="mt-1 block" v-model="form.email" autocomplete="email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                    </div>


                    <div class="flex flex-row">
                        <div class="mb-4 basis-1/4">
                            <jet-label for="address" value="Address" />
                            <jet-input id="address" type="text" class="mt-1 block" v-model="form.address" autocomplete="address" />
                            <jet-input-error :message="form.errors.address" class="mt-2" />
                        </div>

                        <div class="mb-4 basis-1/4">
                            <jet-label for="note" value="Note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.note" autocomplete="note" />
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="mb-4 basis-1/4">
                            <label class="flex items-center">
                                <jet-checkbox name="active" v-model:checked="form.active" />
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="my-4">

                        <span class="text-lg font-bold">Documents </span>
                         <span class="px-2 py-1 bg-gray-800 text-white  my-2 rounded cursor-pointer" @click="addDocument"> Add </span>
                        <div class="docments" v-for="schoolDoc in form.documents">
                            <div class="grid grid-cols-1 mb-4 md:grid-cols-5 gap-4">
                                <div>
                                    <jet-label for="title" required value="Title" />
                                    <jet-input id="title" type="text" required class="mt-1 w-full" v-model="schoolDoc.title" autocomplete="title" />
                                </div>

                                <div class="col-span-2">
                                    <jet-label for="note" value="Description" />
                                    <jet-input id="note" type="text" class="mt-1 w-full" v-model="schoolDoc.note" autocomplete="note" />
                                </div>
                                <div>
                                    <Link v-if="schoolDoc.id " :href="schoolDoc.link" class="text-indigo-600">Click to open File </Link>
                                    <!-- <input type="file" @input="schoolDoc.link = $event.target.files[0]" /> -->
                                    <input type="file" @input="schoolDoc.link = $event.target.files[0]" class="w-full" />
                                </div>

                                <div>
                                    <trash @click="removeDocument"  />
                                </div>

                            </div>
                        </div>
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
    import { Link } from '@inertiajs/inertia-vue3';
    import { useForm } from '@inertiajs/inertia-vue3'

    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import Trash from '@/Shared/Components/Icons/svg/Trash.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            BreadSimple,
            Link,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            Trash
        },
        props: ['school', 'warehouses'],
         data: () => ({
            edit: false
         }),
        setup () {
            const form = useForm({
              _method: 'PUT',
              name: null,
              warehouse_id: '',
              city: null,
              state: null,
              pincode: '',
              email: '',
              mobile: '',
              fax : '',
              contact_person: '',
              address: '',
              note: '',
              documents: [],
              active: false

            })

            function submitData(){
                if (this.school) {
                    form.post(route('schools.update', this.school.id));
                }else{
                    form._method = 'POST';
                    form.post(route('schools.store'));
                }
                // this.school ? form.post(route('schools.update', this.school.id)) : form.post(route('schools.store'))
            }
            return { form, submitData  }
        },

        created(){
            if (this.school) {

                Object.keys(this.school).forEach((index) => {
                    this.form[index] = this.school[index];
                });
                this.edit = true;
            }
        },
        methods:{
            newLocation(event){
                this.warehouses.forEach((warehouse, index) =>{
                    if (warehouse.id == event.target.value ) {
                        this.form.city = warehouse.city;
                        this.form.state = warehouse.state;
                        this.form.pincode = warehouse.pincode;
                    }
                });
            },
            addDocument(){
                this.form.documents.push({
                    title:null,
                    note:null,
                    link:''
                });
            },

            removeDocument(index) {
                if (confirm('Are you sure?')) { this.form.documents.splice(index, 1); }
            },
        }
    })
</script>
