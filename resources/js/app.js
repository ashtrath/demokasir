import "../css/app.css";
import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, h } from "vue";
import VueApexCharts from "vue3-apexcharts";
import { ZiggyVue } from "ziggy-js";
import layout from "./Pages/layout.vue";

createInertiaApp({
	title: (title) => `${title ? `${title} |` : "Laravel"}`,
	progress: {
		color: "#181818",
	},
	resolve: (name) => {
		const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
		const page = pages[`./Pages/${name}.vue`];
		page.default.layout = ["login", "report"].includes(name)
			? undefined
			: page.default.layout || layout;
		return page;
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.use(VueApexCharts)
			.mount(el);
	},
});
