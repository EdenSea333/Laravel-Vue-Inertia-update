<template>
	<AppLayout title="Stocks">

		<template #header>
			<h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
				<p>
					Stocks
					<i class="fa-solid fa-list-check"></i>
				</p>
			</h2>
		</template>

		<div class="py-12">

			<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
				<div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
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
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									brand
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									model
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Colour
								</th>
								<!-- <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									capacity
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									capacity_unit
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Category
								</th> -->
                                <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Qty
								</th>
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">Edit</span>
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="stock in stocksList.data" :key="stock.id">
								<td>
									<!-- <input type="checkbox" v-model="selectedUsers" :value="user.id" -->
										<!-- class="ml-5 outline-none" /> -->
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
                                        {{ stock.product.brand }}
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="flex items-center justify-center">
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
                                                {{ stock.product.model }}
											</div>
										</div>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
                                        {{ stock.product.color }}
									</div>
								</td>
								<!-- <td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
                                        {{ stock.product.capacity }}
									</div>
								</td> -->
								<!-- <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ stock.product.capacity_unit }}
									</div>
								</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ stock.product.category }}
									</div>
								</td> -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ stock.quantity }}
									</div>
								</td>
							</tr>
						</tbody>
					</table>
                    <Pagination class="mt-6" :links="stocksList.links" />
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
        stocksList: Object,
	},
	data() {
		return {
			selectedUsers: [],
			term: this.$page.term || '',
            form: this.$inertia.form({
                stock: ''
            })
		}
	},
	methods: {
		confirmAction(message, callback) {
			if (confirm(message)) {
				callback();
			}
		},
		deleteUser: function (user) {
			this.confirmAction('Are you sure you want to delete user?', function () {
				this.$inertia.delete(route('users.destroy', user.id));
			}.bind(this));
		},
		search() {
            console.log(this.stocksList);
			this.$inertia.replace(this.route('users.index', { term: this.term }))
		},
		async deleteSelectedUsers() {
			if (this.selectedUsers.length === 0) {
				return;
			}

			const confirmed = confirm(`Are you sure you want to delete ${this.selectedUsers.length} user(s)?`);
			if (!confirmed) {
				return;
			}

			try {
				await this.$inertia.post('/users/delete', { ids: this.selectedUsers });
				this.selectedUsers = [];
			} catch (error) {
				console.error(error);
				alert('An error occurred while deleting the selected users.');
			}
		},
		computed: {
			userAvatar(user) {
				return this.user.avatar !== 'placeholder'
					? this.user.avatar
					: 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
			}
		},
	}
}
</script>