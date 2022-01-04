<template>
    <app-layout title="Location Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Location <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'locations'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'locations'}, {route: 'locations.create', name:'Add'} ]" />
        </template>


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" location ? form.put(route('locations.update', location.id)) : form.post(route('locations.store'))">
                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="name" required="true" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="city" required="true" value="City" />
                            <jet-input id="city" type="text" class="mt-1 block" v-model="form.city" autocomplete="city" />
                            <jet-input-error :message="form.errors.city" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="state" required="true" value="State" />
                            <jet-input id="state" type="text" class="mt-1 block" v-model="form.state" autocomplete="state" />
                            <jet-input-error :message="form.errors.state" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="pincode" required="true" value="Pincode" />
                            <jet-input id="pincode" type="text" class="mt-1 block" v-model="form.pincode" autocomplete="pincode" />
                            <jet-input-error :message="form.errors.pincode" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex flex-row mb-4">

                        <div class="  basis-1/4">
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
        props: ['location'],
         data: () => ({
            edit: false
         }),
        setup () {
            const form = useForm({
              name: null,
              city: null,
              state: null,
              pincode: '',
              email: '',
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
        }
    })
</script>
