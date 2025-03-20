<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Update Category</h1>
        </div>
        <form @submit.prevent="forms.put(route('categories.update', props.category.id))" class="bg-white p-4 rounded-sm flex flex-col gap-4" method="POST">
            <div>
                <p>Code</p>
                <input :class="{'border border-red-500': forms.errors.code}" type="text" v-model="forms.code">
                <p v-if="forms.errors.code" class="text-red-500">
                    {{ forms.errors.code }}
                </p>
            </div>
            <div>
                <p>Name</p>
                <input :class="{'border border-red-500': forms.errors.name}" type="text" v-model="forms.name">
                <p v-if="forms.errors.name" class="text-red-500">
                    {{ forms.errors.name }}
                </p>
            </div>
            <div class="flex justify-between">
                <Link :href="route('categories.index')" class="border border-primary py-2 text-sm px-4">
                    Back
                </Link>
                <button class="bg-primary py-2 text-sm px-4" type="submit">
                    Update
                </button>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    category: Category
}>()

const forms = useForm<Omit<Category, "id" | "created_at" | "updated_at">>({
    code: props.category.code,
    name: props.category.name
});
</script>