<template>
    <div class="flex overflow-hidden">
        <nav :class="{'w-96': lock, 'w-24': !lock}"
             class="hover:w-96 group transition-[width] duration-300 p-4 flex flex-col gap-4 overflow-clip overflow-y-auto max-h-dvh">
            <div class="w-full flex justify-between h-max relative">
                <h1 :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                    class="font-bold text-2xl">DEMO KASIR</h1>
                <button
                    :class="{'bg-primary right-0 translate-x-0': lock, 'right-1/2 translate-x-1/2': !lock}"
                    class="w-max absolute top-1/2 -translate-y-1/2 group-hover:translate-x-0 group-hover:right-0 flex justify-center items-center text-xl hover:bg-primary hover:text-white transition-all duration-150 p-2 rounded-full"
                    @click="lock = !lock">
                    <i :class="{'rotate-180': lock}"
                       class="bx bx-chevrons-right group-hover:rotate-180 duration-300 transition-transform"></i>
                </button>
            </div>
            <div class="flex flex-col gap-2">
                <Link :class="{'link-active': route().current('dashboard')}" :href="route('dashboard')"
                      class="link-btn">
                    <i class="bx bxs-dashboard"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Dashboard</p>
                </Link>
                <Link :class="{'link-active': route().current('cashier.*')}" :href="route('cashier.index')"
                      class="link-btn">
                    <i class="bx bx-cart"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Cashier</p>
                </Link>
                <Link :class="{'link-active': route().current('sales.*')}" :href="route('sales.index')"
                      class="link-btn">
                    <i class="bx bx-dollar"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Sales</p>
                </Link>
                <Link :class="{'link-active': route().current('categories.*')}" :href="route('categories.index')"
                      class="link-btn">
                    <i class="bx bx-list-ul"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Categories</p>
                </Link>
                <Link :class="{'link-active': route().current('items.*')}" :href="route('items.index')"
                      class="link-btn">
                    <i class="bx bx-package"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Items</p>
                </Link>
                <Link :class="{'link-active': route().current('user.*')}" :href="route('user.index')" class="link-btn">
                    <i class="bx bx-user"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">User</p>
                </Link>
                <button class="link-btn w-full" @click="router.delete(route('logout'))">
                    <i class="bx bx-log-out"></i>
                    <p :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}"
                       class="whitespace-nowrap">Log Out</p>
                </button>
            </div>
        </nav>
        <div class="bg-[#F6F6F6] w-full p-4 h-dvh overflow-y-auto">
            <slot/>
        </div>
        <Transition>
            <div v-if="$page.props.error || $page.props.success"
                 class="fixed right-4 top-4 shadow-sm bg-primary py-2 px-4 rounded-sm flex items-center gap-4 cursor-pointer max-w-96 text-sm"
                 @click="() => {$page.props.success = null; $page.props.error = null}">
                <p> {{ $page.props.error || $page.props.success }} </p>
                <button>
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
        </Transition>
    </div>
</template>
<script lang="ts" setup>
import {Link, router} from '@inertiajs/vue3';
import {Ref, ref} from 'vue';

const lock: Ref<boolean> = ref(false);

</script>
<style scoped>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: all 0.25s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(1rem);
}
</style>
