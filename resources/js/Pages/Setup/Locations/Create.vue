<template>
    <app-layout title="Location Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Location <span v-if="edit">Edit</span> <span v-else>Create</span>
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

                <Link :href="route('locations')"  class="text-gray-600 dark:text-gray-200 hover:underline">Location</Link>

                <span class="mx-5 text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>

                <Link href="#" v-if="edit" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</Link>
                <Link :href="route('locations.create')" v-else  class="text-blue-600 dark:text-blue-400 hover:underline">Create</Link>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

    export default defineComponent({
        components: {
            JetInputError,
            Link,
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
