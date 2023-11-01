<template>
    <AppLayout title="Edit product">

        <template #header>
            <Breadcrumb :href="'products'" :title="'Products'" :property="product" />
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">

                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md"
                        enctype="multipart/form-data">

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="brand">
                                Brand <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.brand"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="brand" type="text">
                            <!-- <span class="text-red-500">{{ errors?.name }}</span> -->
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="model">
                                Model <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.model"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="model" type="text">
                            <!-- <span class="text-red-500">{{ errors.description }}</span> -->
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="colour">
                                Colour <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.color"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="color" type="text">
                            <!-- <span class="text-red-500">{{ errors.email }}</span> -->
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="capacity">
                               Capacity <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.capacity"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="capacity" type="number">
                            <!-- <span class="text-red-500">{{ errors.email }}</span> -->
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="capacity_unit">
                                Capacity Unit <span class="text-red-500">*</span>
                            </label>
                            <select v-model="form.capacity_unit"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="capacity_unit" type="selected">
                                <option v-for="unit in capacityUnits" :key="unit.id" :value="unit.id">
                                    {{ unit.name }}
                                </option>
                            </select>
                            <!-- <span class="text-red-500">{{ errors.email }}</span> -->
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="category">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select v-model="form.category"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="category" type="select">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }} 
                                </option>
                            </select>
                            <!-- <span class="text-red-500">{{ errors.email }}</span> -->
                        </div>

                        <div class="flex items-center justify-between">
                            <Button :form="form"></Button>
                        </div>

                    </form>
                    <p class="text-xs text-center text-gray-500">
                        &copy; {{ $page.props.currentYear }} 
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "@/Components/Button.vue";
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
    components: {
        AppLayout,
        Breadcrumb,
        Button
    },
    props: {
        product: Object,
        capacityUnits: Object,
        categories: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                brand: this.product.brand,
                model: this.product.model,
                color: this.product.color,
                capacity: this.product.capacity,
                capacity_unit: '',
                category:'',
            })
        }
    },
    methods: {
        submit() {
            this.form.put(this.route('products.update', this.product.id), {})
        }
    }
}
</script>