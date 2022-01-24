<template>
    <app-layout title="Bundle Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bundle <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'bundles.index'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'bundles.index'}, {route: 'bundles.create', name:'Add'} ]" />
        </template>


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" bundle ? form.put(route('bundles.update', bundle.id)) : form.post(route('bundles.store'))">
                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="school_id" required value="School" />
                            <select id="school_id" @change="changeSchool($event)" v-model="form.school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.school_id" class="mt-2" />
                        </div>


                        <div class="basis-1/4">
                            <jet-label for="name" required value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>


                        <div class=" basis-1/4">
                            <jet-label for="note" value="Note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.note" autocomplete="note" />
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex flex-row mb-4" v-if="schoolBooks.length > 0">
                        <table class="min-w-full divide-y divide-gray-200 border mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><span @click="addBooks" ><add-icon /></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item , index) in form.books">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <select v-model="item.book_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                            <option v-for="(book) in schoolBooks" :value="book.id">{{ book.class }} - {{ book.subject }} - {{ book.name }}</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <jet-input type="number" min="1" setp="1" class="mt-1 block" v-model="item.quantity" />
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <button type="button" @click="remove(index)" class="ml-4" v-if="index > 0">
                                          <span class="text-sm text-red-500 "><remove-icon /></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'
    import AddIcon from '@/Shared/Components/Icons/svg/Plus.vue'
    // import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            JetInputError,
            RemoveIcon,
            AddIcon,
            BreadSimple,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox
        },
        props: ['bundle', 'schools'],
         data: () => ({
            edit: false,
            schoolBooks : []
         }),
        setup () {
            const form = useForm({
              name: null,
              state: null,
              school_id: '',
              pincode: '',
              email: '',
              note: '',
              active: false,
              books: []
            })

            return { form  }
        },
        created(){
            if (this.bundle) {
                Object.keys(this.bundle).forEach((index) => {
                    this.form[index] = this.bundle[index];
                });
                this.edit = true;
                this.getBooks(this.bundle.school_id);
                Object.keys(this.bundle.items).forEach((index) => {
                    this.form.books.push(this.bundle.items[index]);
                });
            }
        },
        methods:{
            addBooks(){
                this.form.books.push({
                    book_id: '',
                    class: '',
                    subject: '',
                    quantity: ''
                })
            },
            remove(index){
                this.form.books.splice(index, 1);
            },
            changeSchool(event){
                this.form.books= [];
                this.getBooks(event.target.value);
                this.addBooks();
            },
            getBooks(school_id){
                axios.get(route('schools.books', school_id)).then(books =>{
                    this.schoolBooks = books.data;
                });
            }
        },
    })
</script>
