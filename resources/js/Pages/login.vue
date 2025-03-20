<template>
    <div class="flex justify-center items-center w-full h-dvh">
        <form @submit.prevent="forms.post(route('post.login'))" class="w-96 bg-white shadow-md h-2/3 border flex flex-col justify-around px-8" method="POST">
            <div class="flex flex-col gap-2 items-center">
                <h1 class="font-semibold text-3xl">Login</h1>
                <p class="font-light text-black/75">To Continue</p>
            </div>
            <div class="w-full flex flex-col gap-4">
                <div class="w-full">
                    <p class="text-black/50">Username</p>
                    <input type="username" v-model="forms.username" :class="{'border-red-500': forms.errors.username}" class="border-b w-full" :disabled="forms.processing">
                    <p class="text-red-500 text-sm mt-1" v-if="forms.errors.username"> {{ forms.errors.username }} </p>
                </div>
                <div class="w-full">
                    <p class="text-black/50">Password</p>
                    <input type="password" v-model="forms.password" :class="{'border-red-500': forms.errors.password}" class="border-b w-full" :disabled="forms.processing">
                    <p class="text-red-500 text-sm mt-1" v-if="forms.errors.password"> {{ forms.errors.password }} </p>
                </div>
            </div>
            <p class="text-red-500 text-center" v-if="$page.props.errors['0']"> {{ $page.props.errors['0'] }} </p>
            <button class="bg-primary p-4 text-white" type="submit" :disabled="forms.processing">
                Login
            </button>
        </form>
    </div>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const forms = useForm<{
    username: string,
    password: string
}>({
    username: "",
    password: ""
});
</script>