<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Detail Sales</h1>
        </div>
        <div class="bg-white">
            <table cellpadding="16" class="w-full table-auto">
                <thead class="bg-primary rounded-md">
                <tr>
                    <th class="font-light rounded-tl-md">No</th>
                    <th class="font-light">Item</th>
                    <th class="font-light">Quantity</th>
                    <th class="font-light">Price</th>
                    <th class="font-light rounded-tr-md">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, i) in sale.detail_sale" :key="item.id" class="text-center">
                    <td> {{ i + 1 }}</td>
                    <td>
                        <div class="flex flex-row items-center gap-4">
                            <img :alt="item.item.name"
                                 :src="`/storage/${item.item.image}`"
                                 class="w-24 h-24 aspect-square object-cover rounded-sm"
                                 loading="lazy">
                            {{ item.item.name }}
                        </div>
                    </td>
                    <td> {{ item.qty }}</td>
                    <td> {{ formatRp(item.price) }}</td>
                    <td> {{ formatRp(item.total) }}</td>
                </tr>
                </tbody>
                <tfoot class="bg-primary">
                <tr class="text-right">
                    <th class="font-light" colspan="5">
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-start self-end gap-2">
                                <p>Total</p>
                                <p>:</p>
                                <p> {{ formatRp(sale.total) }} </p>
                            </div>
                            <div class="flex justify-start self-end gap-2">
                                <p>Cash Tendered</p>
                                <p>:</p>
                                <p> {{ formatRp(sale.cash_tendered) }} </p>
                            </div>
                            <div class="flex justify-start self-end gap-2">
                                <p>Change</p>
                                <p>:</p>
                                <p> {{ formatRp(sale.change) }} </p>
                            </div>
                        </div>
                    </th>
                    <!-- <th class="font-light text-center"> {{ formatRp(total) }} </th> -->
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>
<script lang="ts" setup>
const props = defineProps<{
    sale: {
        detail_sale: DetailItem[]
    } & Sale
}>();

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
    maximumFractionDigits: 0,
}).format(num);
</script>
