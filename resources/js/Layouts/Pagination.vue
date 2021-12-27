<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
		<div class="flex-1 flex justify-between sm:hidden">
			<Component
	          :is="previous ? 'Link' : 'span'"
	          :href="previous"
	          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
	          v-text="'Previous'" />
	         <Component
	          :is="next? 'Link' : 'span'"
	          :href="next"
	          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
	          v-text="'Next'" />
		</div>
		<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
		  <div>
		    <p class="text-sm text-gray-700" v-if="from && total && to">
		      Showing
		      <span class="font-medium">{{ from }}</span>
		      to
		      <span class="font-medium">{{ to }}</span>
		      of
		      <span class="font-medium">{{ total }}</span>
		      results
		    </p>
		  </div>
		  <div>
		    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
		        <Component
		          v-for="link in links"
		          :is="link.url ? 'Link' : 'span'"
		          :href="link.url"
		          class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"
		          :class="link.active ? 'text-indigo-800 bg-indigo-200 hover:bg-indigo-200 ' : ''"
		          v-html="link.label" />
		    </nav>
		  </div>
		</div>
	</div>
</template>
<script>
    import { Link } from '@inertiajs/inertia-vue3';
	export default{
        components: {
        	Link
        },
		props: {
			links: Array,
			from: [String, Number],
			total: [String, Number],
			to: [String, Number],
			next: String,
			previous: String
		}
	};
</script>