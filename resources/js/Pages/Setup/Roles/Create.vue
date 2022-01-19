<template>
    <app-layout title="Roles Add">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles <span v-if="edit">Edit</span> <span v-else>Add</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[ { route: 'roles'}, { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'roles'}, {route: 'roles.create', name:'Add'} ]" />
        </template>


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" role ? form.put(route('roles.update', role.id)) : form.post(route('roles.store'))">
                    <div class="flex flex-row mb-4">

                        <div class="w-1/3">
                            <jet-label for="name" required value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block " v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <jet-label for="description" required value="Description" />
                            <jet-input id="description" placeholder="Add Description for this role" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>
                    </div>


                    <div class="text-xl uppercase  mb-4 mt-4">
                         <label class="flex items-center">Permissions &nbsp;
                                <!-- <input @change="allPermissions(event)" type="checkbox"  value="1">
                                <span class="ml-2 font-bold capitalize">All</span> -->
                            </label>
                        <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class=" bg-indigo-500  p-4" v-for="(permission, index) in permissions">
                            <label class="flex text-white items-center">
                                <input type="checkbox" :id="permission.id" :value="permission.id" v-model="form.permissions">
                                <span class="ml-2 font-bold capitalize">{{ permission.name }}</span>
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

    export default defineComponent({
        components: {
            JetInputError,
            BreadSimple,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
        },
        props: ['role', 'permissions'],
         data: () => ({
            edit: false
         }),
        setup () {
            const form = useForm({
              name: null,
              description: '',
              permissions: [],
            })

            return { form  }
        },

        created(){
            if (this.role) {
                this.form.name = this.role.name;
                this.form.description = this.role.description;
                this.role.permissions.forEach(permissions =>{
                    this.form.permissions.push(permissions.id);
                });
                this.edit = true;
            }
        },
        methods:{
            allPermissions(event){
                console.log(event);
                this.permissions.forEach(permission =>{
                    this.form.permissions.push(permission.id);
                });
            }
        }
    })
</script>
