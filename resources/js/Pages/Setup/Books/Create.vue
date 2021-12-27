<template>
    <app-layout title="Book">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book <span v-if="edit">Edit</span> <span v-else>Create</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-2">
                        <form  @submit.prevent=" book ? form.put(route('books.update', book.id)) : form.post(route('books.store'))">
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
                                    <jet-label for="class" value="Class" />
                                    <jet-input id="class" type="text" class="mt-1 block" v-model="form.class" autocomplete="class" />
                                    <jet-input-error :message="form.errors.class" class="mt-2" />
                                </div>

                                <div class="basis-1/4">
                                    <jet-label for="subject" value="Subject" />
                                    <jet-input id="subject" type="text" class="mt-1 block" v-model="form.subject" autocomplete="class" />
                                    <jet-input-error :message="form.errors.subject" class="mt-2" />
                                </div>
                            </div>


                            <div class="flex flex-row mb-4">
                                <div class="basis-1/4">
                                    <jet-label for="supplier_id" required="true" value="Supplier" />
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
                            </div>

                            <div class="flex flex-row mb-4">

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

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox
        },
        props: ['book','suppliers', 'publishers'],
         data: () => ({
            edit: false
         }),
        setup () {
            const form = useForm({
              supplier_id: '',
              publisher_id: '',
              name: null,
              subject: '',
              author_name: '',
              class: null,
              description: null,
              note: '',
              active: false

            })

            return { form  }
        },

        created(){
            if (this.book) {
                Object.keys(this.book).forEach((index) => {
                    this.form[index] = this.book[index];
                });
                this.edit = true;
            }
        }
    })
</script>
