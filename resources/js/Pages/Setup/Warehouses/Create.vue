<template>
    <app-layout title="Warehouse">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Warehouse <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'warehouses.index'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'warehouses.index'}, {route: 'warehouses.create', name:'add'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" warehouse ? form.put(route('warehouses.update', warehouse.id)) : form.post(route('warehouses.store'))">
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
                            <jet-label for="location_id" required value="Location" />
                            <select id="location_id" @change="newLocation($event)" v-model="form.location_id" class="w-60 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <!-- <option>Select location</option> -->
                                <option v-for="location in locations" v-bind:value="location.id">{{ location.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.location_id" class="mt-2" />
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
                            <jet-label for="address" required value="Address" />
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
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    // import { Link } from '@inertiajs/inertia-vue3';
    import JetCheckbox from '@/Jetstream/Checkbox.vue'

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            AppLayout,
            BreadSimple,
            // Link,
            JetButton,
            JetLabel,
            JetCheckbox
        },
        props: ['warehouse', 'locations'],
         data: () => ({
            edit: false
         }),
        setup () {
            const form = useForm({
              name: null,
              location_id: '',
              city: null,
              state: null,
              pincode: '',
              email: '',
              address: '',
              mobile: '',
              fax : '',
              contact_person: '',
              note: '',
              active: false

            })

            return { form  }
        },

        created(){
            if (this.warehouse) {
                Object.keys(this.warehouse).forEach((index) => {
                    this.form[index] = this.warehouse[index];
                });
                this.edit = true;
            }

        },
        methods:{
            newLocation(event){
                this.locations.forEach((location, index) =>{
                    if (location.id == event.target.value ) {
                        this.form.city = location.city;
                        this.form.state = location.state;
                        this.form.pincode = location.pincode;
                    }
                });
            }
        }
    })
</script>
