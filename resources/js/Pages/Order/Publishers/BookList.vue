<template>
	<div>
		<div class="book-item-header">
            <p>Add books to list:
            <span @click="addBook" class="bg-green-400 hover:bg-green-700 hover:text-white p-2 pb-1 pl-2 pt-1 rounded cursor-pointer">Add Book</span>
            </p>
            <div class="flex flex-row">
                <div class="basis-1/4"><jet-label value="Select Book" /></div>
                <div class="basis-1/4"><jet-label value="Class" /></div>
                <div class="basis-1/4"><jet-label value="Subject" /></div>
                <div class="basis-1/4"><jet-label value="Quantity" /></div>
            </div>
        </div>

        <div class="book-item-body">

			<div class="flex flex-row row1">

				<div class="basis-1/4">
					<select v-model="from.book_id" @change="bookChange">
						<option v-for="book in books" index="book.id" value="book.id" v-text="book.name"></option>
					</select>
				</div>

				<div class="basis-1/4">
	                <jet-input id="class" type="text" class="mt-1 block" v-model="form.class" readonly />
	            </div>

	            <div class="basis-1/4">
	                <jet-input id="subject" type="text" class="mt-1 block" v-model="form.subject" readonly />
	            </div>

	            <div class="basis-1/4">
	                <jet-input id="quantity" type="text" class="mt-1 block" v-model="form.quantity" readonly />
	            </div>

			</div>

        </div>
	</div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import { Inertia } from '@inertiajs/inertia'
	export default{
        components: {
            JetInput,
            JetLabel,
        	Link
        },
		props: {
			form1: Object,
			books: Array,
		},
		data: () => ({
            form: {}
         }),
		created(){
			form:{ book_id : 5}
		},
		methods:{
			bookChange(event){
				console.log('BookList.vue');
				// console.log(event);
			},
			 addBook(){
                console.log('add new book here');
            }
		}
	};
</script>