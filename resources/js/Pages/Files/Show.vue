<template>
    <AppLayout title="Products">

        <template #header>
            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
                <p>
                    {{ file.file_name }}
                    /Show
                </p>
            </h2>
        </template>

        <div class="py-12">

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex justify-end mt-3">
                        <div class="mb-3 mr-20">
                            <div class="relative flex items-stretch mb-3 input-group">
                                <a href="#" @click="update(file)"
                                    class="float-left px-4 py-2 mt-3 ml-2 text-white bg-blue-500 duration-100 rounded hover:text-red-600">
                                    MATCH
                                </a>
                            </div>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>

                                <!-- <th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									ID
								</th> -->
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    <div style="width:600px">Product</div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    <div style="width:10px">Grade</div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Vat type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Qty
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Matching product
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="row in rows" :key="row.no">
                                <td class="py-4 text-center whitespace-nowrap">
                                    <div style="width:650px; overflow:auto;">{{ row.product }}</div>
                                </td>
                                <td class="py-4 text-center whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900" style="width:90px; overflow:auto;">
                                        {{ row.grade }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900" style="width:50px">
                                        {{ row.vat_type }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ row.qty }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-white"
                                        :style="'color: ' + (row.mapped == '' ? 'red' : 'blue')" style="width:150px">
                                        {{ row.mapped == '' ? 'No matching' : row.mapped }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="fa-solid fa-screwdriver-wrench" style="color: green" 
                                        @click=" select_product(row.product)"></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <Pagination class="mt-6" :links="products.links" /> -->
                </div>
            </div>
        </div>
    </AppLayout>

    
</template>

<script>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

export default {
    components: {
        AppLayout,
        Pagination,
        DialogModal,
        PrimaryButton,
        SecondaryButton
    },
    props: {
        file: Object,
        rows: Object,
        products: Object,
        supply_product: Object
    },
    data() {
        return {
            selectedProducts: [],
            term: this.$page.term || '',
        }
    },
    methods: {
        update: function (file) {
            this.confirmAction('Are you sure you want to match this file with proudct?', function () {
                this.$inertia.put(route('stocks.update', file.id));
            }.bind(this));
        },
        confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        },
        save: function(supply_product_name){
            console.log('######################', supply_product_name);
            this.$inertia.put(this.route('matchinglist.update', this.selectedProducts, supply_product_name))
        },
        computed: {
            console: () => console,
        },
    }
}
</script>