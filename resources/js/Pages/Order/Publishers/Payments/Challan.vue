<template>
    <app-layout title="Publishers Challan Payment">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publishers Challan Payment <span v-if="edit">Edit</span> <span v-else>Generate</span>
            </h2>
        </template>

        <template #breadcrum>
            <bread-simple v-if="edit" :items="[  { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Orders'} , { name:'edit'} ]" />
            <bread-simple v-else :items="[ { route: 'publishers.index'}, {route: 'publisher.order.index', name:'Orders'} , {route: 'publisher.order.create', name:'Generate'} ]" />
        </template>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <form  @submit.prevent="form.post(route('publisher.payments.challan.store'))">
                    <ul>
                        <li>Publisher: {{ challan.publisher.name }}</li>
                        <li>School Order #: {{ challan.school_order_id }}</li>
                        <li>School Order Date: {{ challan.school_order.date }}</li>
                        <li>Challan #: {{ challan.challan_no }}</li>
                        <li>Challan Amount: {{ challan.amount }}</li>
                        <li>Paid: {{ challan.payment_status }}</li>
                    </ul>

                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4">
                            <jet-label for="date" required value="date" />
                            <jet-input id="date" type="date" class="mt-1 block" v-model="form.date" autocomplete="date"  />

                            <jet-input-error :message="form.errors.date" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="amount" required value="amount" />
                            <jet-input id="amount" type="text" class="mt-1 block" v-model="form.amount" autocomplete="amount" readonly />

                            <jet-input-error :message="form.errors.amount" class="mt-2" />
                        </div>

                        <div class="basis-1/4">
                            <jet-label for="payment_mode" required value="payment_mode" />
                            <jet-input id="payment_mode" type="text" class="mt-1 block" v-model="form.payment_mode" autocomplete="payment_mode"  />

                            <jet-input-error :message="form.errors.payment_mode" class="mt-2" />
                        </div>



                        <div class="basis-1/4">
                            <jet-label for="note" required value="note" />
                            <jet-input id="note" type="text" class="mt-1 block" v-model="form.note" autocomplete="note" />

                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
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
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    // import BookList from '@/Pages/Order/Publishers/BookList.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import BreadSimple from '@/Shared/Components/Breadcrum/Simple.vue'
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        components: {
            JetInputError,
            JetInput,
            Link,
            AppLayout,
            JetButton,
            JetLabel,
            JetCheckbox,
            BreadSimple
            // BookList
        },
        props: ['challan'],
        data: () => ({
            edit: false,
            books: []
        }),
        setup () {
            const form = useForm({
                publisher_id: '',
                challan_id: '',
                amount: '',
                date: new Date().toISOString().slice(0,10),
                note: '',
                payment_mode: 'cash',
                payment_status: 'paid',
            });

            return { form  }
        },

        created(){
            this.form.publisher_id = this.challan.publisher_id;
            this.form.challan_id = this.challan.id;
            this.form.amount = this.challan.amount;
        },
        methods:{
        }
    })
</script>