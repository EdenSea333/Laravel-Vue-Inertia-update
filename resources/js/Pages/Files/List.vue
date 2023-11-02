
<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    files: Array,
	file: Object,
});

const form = useForm({
    _method: 'POST',
    file: props.file
});

const showExcelList = ref(false);

const previewFiles = (event) => {
	if (event.target.files.length <= 0) {
		return;
	}
	form.file = event.target.files[0];
	showExcelList.value = true;
};
const closeModal = () => {
	showExcelList.value = false;
}
const upload = () => {
    form.post(route('files.upload'), {
        onSuccess: () => {
			showExcelList.value = false;
		},
    });
}

</script>

<template>
	<AppLayout title="Files">

		<template #header>
			<h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
				<p>
					Files
					<i class="fa-regular fa-file-excel"></i>
				</p>

				<label for="file-uploader"
					class="px-4 py-2 mr-3 text-sm text-green-600 transition border border-green-300 rounded-full hover:bg-green-600 hover:text-white hover:border-transparent cursor-pointer">Upload Excel File</label>
				<input class="hidden" id="file-uploader" type="file" @change="previewFiles"/>

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
									File name
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Upload Date
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Status
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="file in files.data" :key="file.id">
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ file.file_name }}
									</span>
								</td>
								<td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ file.created_at }}
									</span>
								</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
									<span
										class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
										{{ file.status }}
									</span>
								</td>
								
								<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">

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
					<Pagination class="mt-6" :links="files.links" />
				</div>
			</div>
		</div>
		
		<DialogModal :show="showExcelList" @close="closeModal">
			<template #title>
				Confirm
			</template>

			<template #content>
				Do you want to upload the excel file?
			</template>

			<template #footer>
				<SecondaryButton @click="closeModal" class="mr-2">
					Cancel
				</SecondaryButton>

				<PrimaryButton
					@click="upload"
				>
					Upload
				</PrimaryButton>
			</template>
		</DialogModal>
	</AppLayout>
</template>