<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Sales</h1>
        </div>
        <div class="flex justify-between items-center bg-transparent">
            <div>
                <select v-model="sort" class="bg-transparent appearance-auto" @change.prevent="router.get('', {
                    sort
                })">
                    <option value="">No Sort</option>
                    <option value="created_at">Date</option>
                    <option value="total">Total</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button class="bg-red-500 px-3 py-1 rounded-sm flex gap-2 items-center text-white font-medium"
                        @click="menuExportPDF = true">
                    <i class='bx bxs-file-pdf'></i>
                    PDF
                </button>
                <button class="bg-green-500 px-3 py-1 rounded-sm flex gap-2 items-center text-white font-medium"
                        @click="menuExportExcel = true">
                    <i class='bx bxs-file-blank'></i>
                    Excel
                </button>
            </div>
        </div>
        <div class="bg-white">
            <table cellpadding="16" class="w-full table-auto">
                <thead class="bg-primary text-white rounded-md">
                <tr>
                    <th class="font-light rounded-tl-md">No</th>
                    <th class="font-light">Date</th>
                    <th class="font-light">Total</th>
                    <th class="font-light">Detail</th>
                    <th class="font-light rounded-tr-md">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(sale, i) in sales.data" :key="sale.id" class="text-center">
                    <td> {{ i + 1 }}</td>
                    <td> {{ moment(sale.created_at).format("MMM D YYYY, h:mm:ss a") }}</td>
                    <td> {{ formatRp(sale.total) }}</td>
                    <td>
                        <Link :href="route('sales.show', sale.id)" class="rounded-sm bg-primary py-2 px-4">
                            Detail
                        </Link>
                    </td>
                    <td class="flex justify-center items-center gap-2">
                        <button @click="printPdf(route('sales.print', sale.id))">
                            <i class="bx bxs-printer"></i>
                        </button>
                        <button @click="router.delete(route('sales.destroy', sale.id))">
                            <i class="bx bxs-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase">
            <span class="flex items-center col-span-3">
                Showing {{ sales.from }}-{{ sales.to }} of {{ sales.total }}
            </span>
            <span class="col-span-2"></span>
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <!-- <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                            aria-label="Previous">
                            <i class="bx bx-chevron-left"></i>
                        </button> -->
                        <li v-for="link in sales.links" :key="link.label">
                            <Link v-if="link.url != null"
                                  :class="{ 'bg-white text-black': link.active }"
                                  :href="link.url"
                                  class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                                  v-html="link.label">
                            </Link>
                        </li>
                        <!-- <li>
                            <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                aria-label="Next">
                                <i class="bx bx-chevron-right"></i>
                            </button>
                        </li> -->
                    </ul>
                </nav>
            </span>
        </div>
        <div v-if="menuExportPDF"
             class="flex justify-center items-center fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/30 w-full h-full"
             @click.self="menuExportPDF = false">
            <div class="bg-white rounded-sm w-96 p-4 flex flex-col justify-center items-center gap-4">
                <p class="text-2xl">Generate Report PDF</p>
                <div class="w-full flex flex-col gap-2">
                    <div>
                        <p class="text-lg">Date</p>
                        <VueDatePicker
                            v-model="dates"
                            :class="{ 'border border-red-500': $page.props.errors?.startDate || $page.props.errors?.endDate }"
                            :enable-time-picker="false" auto-apply placeholder="Select Dates"
                            position="center" range/>
                        <p v-if="$page.props.errors?.startDate || $page.props.errors?.endDate"
                           class="text-red-500 text-sm"> Please select the dates
                        </p>
                    </div>
                    <!-- <button :disabled="!(dates?.[0] && dates?.[1]) || state" @click="router.get(route('sales.report.pdf'), {
                        startDate: dates[0],
                        endDate: dates[1]
                    }, {
                        preserveState: true,
                        onStart: () => state = true,
                        onFinish: () => state = false
                    })" class="bg-primary py-2 px-1 flex justify-center items-center">
                        <i v-if="state" class="bx bx-loader-alt bx-spin"></i>
                        <p v-else>
                            Generate Report PDF
                        </p>
                    </button> -->
                    <a :disabled="!(dates?.[0] && dates?.[1]) || state" :href="route('sales.report.pdf', {
                        _query: {
                            startDate: dates[0],
                            endDate: dates[1]
                        },
                    })" class="bg-primary py-2 px-1 flex justify-center items-center">
                        <i v-if="state" class="bx bx-loader-alt bx-spin"></i>
                        <p v-else>
                            Generate Report PDF
                        </p>
                    </a>
                </div>
            </div>
        </div>
        <div v-if="menuExportExcel"
             class="flex justify-center items-center fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/30 w-full h-full"
             @click.self="menuExportExcel = false">
            <div class="bg-white rounded-sm w-96 p-4 flex flex-col justify-center items-center gap-4">
                <p class="text-2xl">Generate Report Excel</p>
                <div class="w-full flex flex-col gap-2">
                    <div>
                        <p class="text-lg">Date</p>
                        <VueDatePicker
                            v-model="dates"
                            :class="{ 'border border-red-500': $page.props.errors?.startDate || $page.props.errors?.endDate }"
                            :enable-time-picker="false" auto-apply placeholder="Select Dates"
                            position="center" range/>
                        <p v-if="$page.props.errors?.startDate || $page.props.errors?.endDate"
                           class="text-red-500 text-sm"> Please select the dates
                        </p>
                    </div>
                    <a :disabled="!(dates?.[0] && dates?.[1]) || state" :href="route('sales.report.excel', {
                        _query: {
                            startDate: dates[0],
                            endDate: dates[1]
                        },
                    })" class="bg-primary py-2 px-1 flex justify-center items-center">
                        <i v-if="state" class="bx bx-loader-alt bx-spin"></i>
                        <p v-else>
                            Generate Report Excel
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import {Link, router, usePage} from '@inertiajs/vue3';
import moment from "moment";
import {Ref, ref, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import VueDatePicker from '@vuepic/vue-datepicker';
import {printPdf} from "@/utils";

const menuExportPDF: Ref<boolean> = ref(false);
const menuExportExcel: Ref<boolean> = ref(false);
const state: Ref<boolean> = ref(false);
const dates: Ref<Array<[Date, Date]>> = ref([]);

const sort: Ref<null | string | "date" | "total"> = ref(new URLSearchParams(window.location.search).get("sort") || "");

const props = defineProps<{
    sales: {
        from: number,
        to: number,
        total: number,
        data: Sale[]
        links: Link[],
    }
}>();

watch(dates, () => usePage().props.errors = {})

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
}).format(num);
</script>
