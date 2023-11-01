<template>
	<AppLayout title="Products">

		<template #header>
			<h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
				<p>
					Products
					<i class="fa-solid fa-table-list"></i>
				</p>

				<inertia-link href="products/create">
					<a
						class="px-4 py-2 mr-3 text-sm text-green-600 transition border border-green-300 rounded-full hover:bg-green-600 hover:text-white hover:border-transparent">Create
					product</a>
				</inertia-link>

			</h2>
		</template>

		<div class="py-12">

			<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
				<div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">

					<a href="#" @click="deleteSelectedProducts"
						class="float-left px-4 py-2 mt-3 text-red-400 duration-100 rounded hover:text-red-600">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor"
								fill="none"
								d="M3 6h18M6 6l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 4v-1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1" />
						</svg>
					</a>

					<div class="flex justify-end mt-3">
						<div class="mb-3 xl:w-96">
							<div class="relative flex items-stretch w-4/5 mb-3 input-group">

								<input id="search" type='text' v-model="term" @keyup="search"
									class="outline-none focus:ring-0 rounded-r-none form-control relative min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0"
									placeholder="Search...">

								<button
									class="rounded-l-none btn px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center"
									type="button" id="button-addon2">
									<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search"
										class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
										</path>
									</svg>
								</button>
							</div>
						</div>
					</div>

					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col"></th>
								<!-- <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									ID
								</th> -->
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<div style="width: 100px;">Brand</div>
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									<div style="width: 100px; ">Model</div>
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Colour
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Capacity
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Capacity Unit
								</th>
                                <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Category
								</th>
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">Edit</span>
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="product in products.data" :key="product.id">
								<td>
									<input type="checkbox" v-model="selectedProducts" :value="product.id"
										class="ml-5 outline-none" />
								</td>
								<!-- <td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
										{{ product.id }}
									</div>
								</td> -->
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="flex items-center justify-center">
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900" style="width: 100px; overflow:hidden;">
												<inertia-link class="transition hover:text-blue-500"
													:href="`products/${product.id}`">{{ product.brand }}</inertia-link>
											</div>
										</div>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900 " style="width: 100px; overflow:hidden">
										<span>{{ product.model }}</span>
									</div>
								</td>
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ product.color }}
									</span>
								</td>
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ product.capacity }}
									</span>
								</td>
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ product.capacity_unit?.name }}
									</span>
								</td>
								
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ product.category.name }}
									</span>
								</td>
								
								<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">

									<inertia-link :href="`/products/${product.id}/edit`"
										class="float-left px-4 py-2 text-green-400 duration-100 rounded hover:text-green-600">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
											viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
										</svg></inertia-link>

									<a href="#" @click="deleteProduct(product)"
										class="float-left px-4 py-2 ml-2 text-red-400 duration-100 rounded hover:text-red-600">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
											viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
										</svg>
									</a>

								</td>
							</tr>
						</tbody>
					</table>
					<Pagination class="mt-6" :links="products.links" />
				</div>
			</div>
		</div>
	</AppLayout>
</template>

<script>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
	components: {
		AppLayout,
		Pagination
	},
	props: {
		products: Object,
	},
	data() {
		return {
			selectedProducts: [],
			term: this.$page.term || '',
		}
	},
	methods: {
		confirmAction(message, callback) {
			if (confirm(message)) {
				callback();
			}
		},
		deleteProduct: function (product) {
			this.confirmAction('Are you sure you want to delete proudct?', function () {
				this.$inertia.delete(route('products.destroy', product.id));
			}.bind(this));
		},
		search() {
			this.$inertia.replace(this.route('products.index', { term: this.term }))
		},
		async deleteSelectedProducts() {
			console.log(this.selectedProducts);
			if (this.selectedProducts.length === 0) {
				return;
			}

			const confirmed = confirm(`Are you sure you want to delete ${this.selectedProducts.length} product(s)?`);
			if (!confirmed) {
				return;
			}

			try {
				await this.$inertia.post('/products/delete', { ids: this.selectedProducts });
				this.selectedProducts = [];
			} catch (error) {
				console.error(error);
				alert('An error occurred while deleting the selected products.');
			}
		},
		computed: {
			console: () => console,
		},
	}
}
</script>