<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">User</h1>
        </div>
        <form class="bg-white p-4 rounded-sm flex flex-col gap-4" method="POST" @submit.prevent="forms.put(route('user.update', props.user.id), {
            onSuccess: () => forms.reset('username', 'password')
        })">
            <div>
                <p>Name</p>
                <input v-model="forms.name" :class="{'border border-red-500': forms.errors.name}" type="text">
                <p class="text-red-500"> {{ forms.errors.name }} </p>
            </div>
            <div>
                <p>Username</p>
                <input v-model="forms.username" :class="{'border border-red-500': forms.errors.username}" type="text">
                <p class="text-red-500"> {{ forms.errors.username }} </p>
            </div>
            <div>
                <p>Password</p>
                <input v-model="forms.password" :class="{'border border-red-500': forms.errors.password}"
                       type="password">
                <p class="text-red-500"> {{ forms.errors.password }} </p>
            </div>
            <div>
                <p>Store Name</p>
                <input v-model="forms.store_name" :class="{'border border-red-500': forms.errors.store_name}"
                       type="text">
                <p class="text-red-500"> {{ forms.errors.store_name }} </p>
            </div>
            <div>
                <p>Store Address</p>
                <input v-model="forms.store_address" :class="{'border border-red-500': forms.errors.store_address}"
                       type="text">
                <p class="text-red-500"> {{ forms.errors.store_address }} </p>
            </div>
            <div>
                <p>Store Phone</p>
                <input v-model="forms.store_phone" :class="{'border border-red-500': forms.errors.store_phone}"
                       type="text">
                <p class="text-red-500"> {{ forms.errors.store_phone }} </p>
            </div>
            <button class="bg-primary py-2 text-sm px-4 self-end" type="submit">
                Update
            </button>
        </form>
    </div>
</template>
<script lang="ts" setup>
import {useForm} from '@inertiajs/vue3';

const props = defineProps<{
    user: {
        id: number,
        username: string,
        password: string,
        name: string,
        store_name: string,
        store_address: string,
        store_phone: string,
    }
}>();

const forms = useForm<{
    username: string,
    password: string,
    name: string,
    store_name: string,
    store_address: string,
    store_phone: string,
}>({
    name: props.user.name,
    store_name: props.user.store_name,
    store_address: props.user.store_address,
    store_phone: props.user.store_phone,
    username: "",
    password: "",
})
</script>
