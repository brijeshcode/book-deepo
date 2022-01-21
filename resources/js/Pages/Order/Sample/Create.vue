<template>
    <app-layout title="School Samples">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Samples <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[  { route: 'schools'}, {route: 'samples.index', name:'Samples'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'schools'}, {route: 'samples.index', name:'Samples'} , {route: 'samples.create', name:'Generate'} ]" />
        </template>


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2">

                    <form  @submit.prevent=" sample ? form.put(route('samples.update', sample.id)) : form.post(route('samples.store'))">
                        <div class="flex flex-row mb-4">
                            <div class="mb-4 basis-1/4">
                                <jet-label for="date" required value="Date" />
                                <jet-input id="date" type="date" class="mt-1 block" v-model="form.date" autocomplete="date" />
                                <jet-input-error :message="form.errors.date" class="mt-2" />
                            </div>

                            <div class="basis-1/4">
                                <jet-label for="school_id" required value="School" />
                                <select id="school_id" @change="changeSchool($event)" v-model="form.school_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" >
                                    <option v-for="school in schools" v-bind:value="school.id">{{ school.name }}</option>
                                </select>
                                <jet-input-error :message="form.errors.school_id" class="mt-2" />
                            </div>
                            <div class="mb-4 basis-1/2">
                                <jet-label for="note" value="Note" />
                                <jet-input id="note" type="text" class="mt-1 w-full block" v-model="form.note" autocomplete="note" />
                                <jet-input-error :message="form.errors.note" class="mt-2" />
                            </div>

                        </div>

                        <div v-if="form.items.length" class="book-item-details">
                            <div class="flex flex-row mb-4">
                                <p>Add Sample to list:
                                    <span @click="addItem" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Sample Item</span>
                                </p>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200 border mb-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Name" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Class" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Subject" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Publishers" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Quantity" /></th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><jet-label value="Action" /></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in form.items">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="text" step="1" min="0" class="mt-1 block" placeholder="Add Sample item name" v-model="item.name" />
                                        </td>

                                         <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="text" step="1" min="0" class="mt-1 block" v-model="item.class" />
                                        </td>

                                         <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="text" step="1" min="0" class="mt-1 block" v-model="item.subject" />
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <select v-model="item.publisher_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                                <option v-for="publishser in publishers" :value="publishser.id">{{ publishser.name }}</option>
                                            </select>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <jet-input type="number" style="width:70px" step="1" min="0" class="mt-1 block" v-model="item.quantity" />
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <button type="button" v-on:click="removeRow(index, item.id)" v-if="index > 0" >
                                          <span class="material-icons text-sm text-red-500"><remove-icon /></span>
                                        </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                        <td class="px-4 py-4 whitespace-nowrap"><jet-input type="number" class="mt-1 block" style="width:70px" readonly v-model="computeQuantity" /></td>
                                        <td class="px-4 py-4 whitespace-nowrap"></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <div class="mb-4">
                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing && form.items.length ">Save</jet-button>
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
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import RemoveIcon from '@/Shared/Components/Icons/svg/Trash.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            AppLayout,
            BreadSimple,
            JetLabel,
            JetInput,
            JetInputError,
            JetButton,
            RemoveIcon,
            EditLink,
        },
        props: ['schools','publishers', 'sample'],
        data: () => ({
            edit: false
        }),
        setup () {
            const form = useForm({
              school_id: '',
              date: new Date().toISOString().slice(0,10),
              quantity: 0,
              note: '',
              items: []
            });

            return { form  }
        },
        computed: {
            computeQuantity: function () {
                let qty = 0;
                this.form.items.forEach((item) =>{ qty += parseInt(item.quantity); });
                this.form.quantity = qty;
                return qty;
            }
        },
        created(){
            if (this.sample) {
                Object.keys(this.sample).forEach((index) => {
                    this.form[index] = this.sample[index];
                });
                // this.getBooks(this.sample.school_id)

                this.edit = true;
            }
        },
        methods:{
            changeSchool(event){
                this.form.items = [];
                this.addItem();
            },
            addItem(){
                this.form.items.push({
                    name : '',
                    class: '',
                    subject: '',
                    publisher_id: '',
                    quantity: 0,
                });

            },
            removeRow(index, item_id = null) {
                if (confirm('Are you sure?')) this.form.items.splice(index, 1);
            }
        }
    })
</script>