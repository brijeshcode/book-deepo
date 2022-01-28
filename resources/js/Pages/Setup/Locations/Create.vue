<template>
    <app-layout title="Location Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Location <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'locations.index'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'locations.index'}, {route: 'locations.create', name:'Add'} ]" />
        </template>


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" location ? form.put(route('locations.update', location.id)) : form.post(route('locations.store'))">
                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="name" required value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="state" required value="State" />
                            <select id="location_id" @change="getCity($event)" v-model="form.state" class="w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="state in states" v-bind:value="state.name">{{ state.name }}</option>
                            </select>

                            <!-- <jet-input id="state" type="text" class="mt-1 block" v-model="form.state" autocomplete="state" /> -->
                            <jet-input-error :message="form.errors.state" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="city" required value="City"/>
                            <select id="city"  v-model="form.city" class="w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="city in cities" v-bind:value="city.name">{{ city.name }}</option>
                            </select>
                            <!-- <jet-input id="city" type="text" class="mt-1 block" v-model="form.city" autocomplete="city" /> -->
                            <jet-input-error :message="form.errors.city" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="pincode" required value="Pincode" />
                            <jet-input id="pincode" type="text" class="mt-1 block" v-model="form.pincode" autocomplete="pincode" />
                            <jet-input-error :message="form.errors.pincode" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex flex-row mb-4">

                        <div class=" basis-1/4">
                            <jet-label for="note" value="Note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.note" autocomplete="note" />
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mb-4">
                        <div class="">
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
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    // import { Link } from '@inertiajs/inertia-vue3';

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
        props: ['location','countries'],
         data: () => ({
            edit: false,
            states : [],
            cities : []
         }),
        setup () {
            const form = useForm({
              name: null,
              city: null,
              state: null,
              pincode: null,
              email: null,
              note: '',
              active: false

            })

            return { form  }
        },

        created(){
            if (this.location) {
                Object.keys(this.location).forEach((index) => {
                    this.form[index] = this.location[index];
                });
                this.edit = true;
            }

            this.countries.forEach(state =>{
                if (state.parent_id == 0) {
                   this.states.push(state);
                }
            });

            this.countries.forEach(state =>{
                if (state.parent_id == 1) {
                   this.cities.push(state);
                }
            });
        },
        methods:{
            getCity(event){
                this.cities = [];
                let i = 1;
                let selectedState = event.target.value;
                this.states.forEach(state => {
                    if (state.name == selectedState) {
                        this.countries.forEach(city => {
                            if (city.parent_id == state.id) {
                               this.cities.push(city);
                               console.log(i++);
                            }
                        });
                        return ;
                    }
                });
            }
        }
    })
</script>
