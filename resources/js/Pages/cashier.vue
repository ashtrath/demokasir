<template>
    <div class="flex flex-col gap-4 h-full overflow-hidden">
        <h1 class="font-semibold text-3xl">Cashier</h1>
        <div class="flex gap-2 w-full h-full overflow-y-auto overflow-hidden">
            <div class="flex flex-col p-2 gap-0 items-start justify-start bg-white overflow-y-auto w-full h-full">
                <button v-for="item in items" :key="item.id"
                        class="w-full flex flex-row gap-4 items-center py-4 px-3 hover:bg-gray-50 border-b border-gray-100"
                        @click="handleAddItem(item)">
                    <div class="relative w-16 shrink-0">
                        <img :alt="item.name" :class="{ 'grayscale': item.stock == 0 }"
                             :src="`/storage/${item.image}`"
                             class="w-full aspect-square object-cover object-center">
                    </div>
                    <div class="flex flex-col gap-1.5 flex-1 text-left">
                        <p class="font-semibold text-base leading-tight tracking-tight text-gray-900">
                            {{ item.name }}
                        </p>
                        <p class="font-medium text-sm text-primary tracking-wide">{{ formatRp(item.sell_price) }} </p>
                        <p class="font-normal text-xs text-gray-500">Stock: {{ item.stock }}</p>
                    </div>
                </button>
            </div>
            <form class="bg-white flex flex-col justify-between w-[500px] min-w-[500px] max-h-full" @submit.prevent="forms.post(route('cashier.store'), {
                onSuccess: () => {
                    forms.reset();
                    printPdf(route('sales.print', $page.props.saleId))
                }
            })">
                <table class="table-fixed w-full p-4">
                    <thead class="bg-primary text-white rounded-md sticky top-0 z-1">
                    <tr class="text-sm">
                        <th class="font-light rounded-tl-md w-[30%]">Item</th>
                        <th class="font-light w-[15%]">Qty</th>
                        <th class="font-light w-[20%]">Price</th>
                        <th class="font-light w-[20%]">Total</th>
                        <th class="font-light rounded-tr-md w-[15%]">
                            <i class="bx bx-trash"></i>
                        </th>
                    </tr>
                    </thead>
                </table>
                <div class="w-full h-full overflow-y-auto">
                    <template v-if="forms.items.length">
                        <table class="table-fixed w-full p-4">
                            <tbody>
                            <tr v-for="item in forms.items" :key="item.id" class="text-center text-xs">
                                <td class="w-[30%]"> {{ item.name }}</td>
                                <td class="w-[15%]">
                                    <input :value="item.qty" class="w-10" type="tel"
                                           @input="handleQty($event, item)">
                                </td>
                                <td class="w-[20%]"> {{ formatRp(item.sell_price) }}</td>
                                <td class="w-[20%]"> {{ formatRp(item.qty * item.sell_price) }}</td>
                                <td class="w-[15%]">
                                    <div class="flex justify-center items-center gap-2">
                                        <button class="flex justify-center items-center" type="button"
                                                @click="handleDelete(item)">
                                            <i class="bx bxs-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                    <p v-else class="text-center mt-4">No Items Added</p>
                </div>
                <div class="px-2">
                    <p class="text-sm font-medium mb-1">Cash Tendered</p>
                    <input
                        v-model.number="forms.cash_tendered"
                        :step="1000"
                        class="border-slate-500 p-1"
                        min="0"
                        type="number"
                    />
                    <p v-if="forms.errors.cash_tendered" class="text-red-500">
                        {{ forms.errors.cash_tendered }}
                    </p>
                </div>
                <div class="flex flex-col gap-2 p-2 text-sm">
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Total Items</p>
                        <p> {{ forms.items.length }} Items</p>
                    </div>
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Total</p>
                        <p>{{ total >= 0 ? formatRp(total) : formatRp(0) }} </p>
                    </div>
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Cash Tendered</p>
                        <p>{{ formatRp(forms.cash_tendered) }} </p>
                    </div>
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Change</p>
                        <p :class="change < 0 ? 'text-red-500' : ''">
                            {{ formatRp(change) }}
                        </p>
                    </div>
                    <div class="flex gap-2 w-full">
                        <button :disabled="forms.processing || !forms.items.length"
                                class="border border-primary py-2 w-full" type="reset"
                                @click="forms.reset()">
                            Cancel
                        </button>
                        <button
                            :disabled="forms.processing || !forms.items.length || forms.cash_tendered < total"
                            class="bg-primary py-2 w-full flex justify-center items-center"
                            type="submit"
                        >
                            <i v-if="forms.processing" class="bx bx-loader-alt bx-spin"></i>
                            <p v-else>Pay</p>
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {useForm} from '@inertiajs/vue3';
import {computed, InputHTMLAttributes} from 'vue';
import {printPdf} from "@/utils";

const props = defineProps<{
    items: Item[]
}>();

const forms = useForm<{
    items: (Item & { qty: number })[],
    cash_tendered: number,
}>({
    items: [],
    cash_tendered: 0,
});

const change = computed(() => forms.cash_tendered - total.value);
const total = computed(() => forms.items.reduce((prev, next) => prev += next.qty * next.sell_price!, 0))

const handleAddItem = (item: Item) => {
    const exist = forms.items.findIndex(v => v.id == item.id) >= 0;
    const propItem = props.items.find(v => v.id == item.id);
    if (propItem!.stock > 0) {
        if (exist) {
            forms.items.find(v => v.id == item.id)!.qty += 1;
        } else {
            forms.items.push({
                ...item,
                qty: 1,
            });
        }
        propItem!.stock -= 1;
    }
}

const handleQty = (e: Event, item: Item & { qty: number }) => {
    let target = e.currentTarget as InputHTMLAttributes;
    const propItem = props.items.find(v => v.id == item.id);
    const qty = target.value;
    if (propItem!.stock + item.qty >= qty) {
        propItem!.stock += item.qty;
        item.qty = +qty;
        propItem!.stock -= item.qty;
    } else {
        item.qty += propItem!.stock;
        propItem!.stock = 0;
        target.value = item.qty;
    }
}

const handleDelete = (item: Item & { qty: number }) => {
    props.items.find(v => v.id == item.id)!.stock += item.qty;
    forms.items = forms.items.filter(v => v.id != item.id);
}

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
    maximumFractionDigits: 0,
}).format(num);

</script>
