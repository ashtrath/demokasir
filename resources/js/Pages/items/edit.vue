<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Edit Item</h1>
        </div>
        <form @submit.prevent="router.post(route('items.update', item.id), {
            _method: 'put',
            ...forms
        }, {
            onStart: () => forms.processing = true,
            onFinish: () => forms.processing = false
        })" enctype="multipart/form-data" class="bg-white p-4 rounded-sm flex flex-col gap-4" method="POST">
            <div class="w-max">
                <p>Product Image</p>
                <label for="image" v-if="forms.image" class="cursor-pointer">
                    <img :src="render(forms.image)" alt=""
                        class="rounded-sm w-48 h-48 aspect-square object-cover object-center">
                </label>
                <label for="image" v-else class="cursor-pointer">
                    <img :src="`/storage/${$props.item.image}`" alt=""
                        class="rounded-sm w-48 h-48 aspect-square object-cover object-center">
                </label>
                <input accept=".jpg,.jpeg,.png,.webp" hidden type="file" name="image" id="image"
                    @change="e => forms.image = e.currentTarget!.files[0]">
            </div>
            <div>
                <p>Name</p>
                <input :class="{ 'border border-red-500': $page.props.errors.name }" type="text" name="name"
                    v-model="forms.name" :disabled="forms.processing" placeholder="Bimoli">
                <p v-if="$page.props.errors.name" class="text-red-500">
                    {{ $page.props.errors.name }}
                </p>
            </div>
            <div>
                <p>Category</p>
                <select name="category_id" v-model="forms.category_id" :disabled="forms.processing">
                    <option :value="null" selected>Select Category</option>
                    <option v-for="category in categories" :value="category.id" :key="category.id"> {{ category.name }}
                    </option>
                </select>
            </div>
            <div>
                <p>Stock</p>
                <input :class="{ 'border border-red-500': $page.props.errors.stock }" type="number" placeholder="0"
                    name="stock" v-model="forms.stock" :disabled="forms.processing">
                <p v-if="$page.props.errors.stock" class="text-red-500">
                    {{ $page.props.errors.stock }}
                </p>
            </div>
            <div>
                <p>Buy Price</p>
                <div :class="{ 'border border-red-500': $page.props.errors.buy_price }"
                    class="flex items-center border rounded-sm">
                    <p class="pl-2">Rp.</p>
                    <input type="number" class="border-none" placeholder="0" name="buy_price" v-model="forms.buy_price"
                        :disabled="forms.processing">
                </div>
                <p v-if="$page.props.errors.buy_price" class="text-red-500">
                    {{ $page.props.errors.buy_price }}
                </p>
            </div>
            <div>
                <p>Sell Price</p>
                <div :class="{ 'border border-red-500': $page.props.errors.sell_price }"
                    class="flex items-center border rounded-sm">
                    <p class="pl-2">Rp.</p>
                    <input type="number" class="border-none" placeholder="0" name="sell_price"
                        v-model="forms.sell_price" :disabled="forms.processing">
                </div>
                <p v-if="$page.props.errors.sell_price" class="text-red-500">
                    {{ $page.props.errors.sell_price }}
                </p>
            </div>
            <div class="flex justify-between">
                <Link :href="route('items.index')" class="border border-primary py-2 text-sm px-4"
                    :class="{ 'pointer-events-none': forms.processing }">
                Back
                </Link>
                <button class="bg-primary py-2 text-sm px-4 w-16 flex justify-center items-center" type="submit"
                    :disabled="forms.processing">
                    <i v-if="forms.processing" class="bx bx-loader-alt bx-spin"></i>
                    <p v-else>Update</p>
                </button>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    categories: Category[],
    item: Item
}>();

const forms = useForm<Omit<Item, "id" | "category" | "created_at" | "updated_at">>({
    category_id: props.item.category_id,
    name: props.item.name,
    image: null,
    stock: props.item.stock,
    buy_price: props.item.buy_price,
    sell_price: props.item.sell_price
});

const render = (file: File) => URL.createObjectURL(file);
</script>