<template>
    <template #title>
        <div class="text-blue-500 text-3xl text-center">Select product that is aligned with selected supply product.</div>
        <div class="text-red-900 text-center">{{supply_product}}</div>
    </template>

    <template #content>
        <Table>
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"></th>
                    <!-- <th scope="col"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                        ID
                    </th> -->
                    <th scope="col"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                        <div style="width: 70px;">Brand</div>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                        <div style="width: 150px; ">Model</div>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                        Colour
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                        Capacity
                    </th>
                    
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="product in products.data" :key="product.id">
                    <td>
                        <input type="radio" id="product.id" v-model="selectedProducts" :value="product.id"
                            class="ml-5 outline-none" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900" style="width: 80px; overflow:auto;">
                                    {{ product.brand }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-center text-gray-900 " style="width: 150px; overflow:auto;">
                            <span>{{ product.model }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 rounded-full" style="width:50px;">
                            {{ product.color }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            {{ product.capacity }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </Table>
        <Pagination class="mt-6" :links="products.links"/>
    </template>
    <template #footer>
        <SecondaryButton @click="matchDialogVisible = false">
            Cancel
        </SecondaryButton>

        <PrimaryButton class="ml-3" @click="() => { matchDialogVisible = false; save(supply_product) }">
            Save
        </PrimaryButton>
    </template>
</DialogModal>