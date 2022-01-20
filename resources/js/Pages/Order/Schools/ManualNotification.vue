<template>
    <app-layout title="School Order">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                School Order Notification mail
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple :items="[  { route: 'schools'}, {route: 'schoolOrder', name:'Orders'} , { name:'Detail'} ]" />
        </template>

        <template #actions>
            <div class="flex">
              <Add-link v-if="($page.props.user.permissions.includes('create school orders'))" createRoute="schoolOrder.create" title="Add new school order" withIcon />
            </div>
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent=" form.post(route('school.order.manual_email_notification.store', order.id))">

                    <div class="flex justify-center mb-4">
                          <div class="w-1/2">
                                <jet-label for="reciver_type" required value="Select Reciver" />
                                <select id="reciver_type" @change="changeReciver($event)"
                                    v-model="form.reciver_email"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  w-full" >
                                    <option v-for="(reciver,reciver_email) in mailData" v-bind:value="reciver_email">{{ reciver.reciver_name }} ({{ reciver.reciver_email }} - {{ reciver.mail_to }})</option>
                                </select>
                          </div>
                    </div>
                    <div class="flex justify-center mb-4">

                          <div class="w-1/2">
                                <jet-label for="subject" required value="Subject" />
                                <jet-input id="subject" type="text" class="mt-1 w-full" v-model="form.subject" autocomplete="subject" />
                                <jet-input-error :message="form.errors.subject" class="mt-2" />
                          </div>
                    </div>
                    <div class="flex justify-center mb-4">
                          <div class="w-1/2">
                                <jet-label for="body" required value="Content" />
                                <textarea id="body" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 w-full h-96" v-model="form.body"></textarea>
                                <jet-input-error :message="form.errors.body" class="mt-2" />
                          </div>
                      </div>

                    <div class="flex justify-center mb-4">
                        <jet-button  :class="{ 'opacity-25': form.processing }">Send</jet-button>
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
    import GroupInput from '@/Shared/Components/Form/Simple/InputGroup'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EditLink from '@/Shared/Components/Links/Edit.vue'
    // import BookList from '@/Pages/Order/School/BookList.vue'
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'
    import AddLink from '@/Shared/Components/Links/Add.vue'


    export default defineComponent({
        components: {
            EditLink,
            Link,
            JetInputError,
            JetInput,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple,
            GroupInput,
            AddLink
            // BookList
        },
        props: ['order', 'mailData'],
        data: () => ({
            edit: false,
            books: []
        }),setup () {
            const form = useForm({
              school_order_id: '',
              reciver_email: '',
              reciver_name : '',
              reciver_type: '',
              reciver_id: '',
              subject: '',
              body: ''
            });

            return { form  }
        },
        methods:{
            changeReciver(event){
                let reciver = event.target.value;

                this.form.school_order_id = this.order.school_id;
                this.form.school_order_id = this.order.school_id;

                this.form.reciver_type = this.mailData[reciver].reciver_type;
                this.form.reciver_name = this.mailData[reciver].reciver_name;
                this.form.reciver_id = this.mailData[reciver].reciver_id;
                console.log(this.form);
            }
        }
    })
</script>