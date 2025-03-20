import "vue";

declare global {
    interface Link {
        url: string;
        label: string;
        active: boolean;
    }

    interface Category {
        id: number;
        code: string;
        name: string;
        created_at: Date;
        updated_at: Date;
    }

    interface Item {
        id: number;
        category_id: number | null;
        category: Category;
        name: string;
        image: string | null;
        stock: number;
        sell_price: number;
        buy_price: number;
        created_at: Date;
        updated_at: Date;
    }

    interface Sale {
        id: number;
        cash_tendered: number;
        total: number;
        change: number;
        created_at: Date;
        updated_at: Date;
    }

    interface DetailItem {
        id: number;
        item: Item;
        price: number;
        total: number;
        qty: number;
        created_at: Date;
        updated_at: Date;
    }
}

// Define Ziggy types locally
type Config = {
    url: string;
    port: number | null;
    defaults: Record<string, any>;
    routes: Record<string, any>;
};

type RouteParam = string | number | boolean | Record<string, any>;

type RouteParamsWithQueryOverload =
    | Record<string, RouteParam>
    | Record<string, RouteParam>[];

// Declare the global route function
declare function route(
    name: string,
    params?: RouteParamsWithQueryOverload | RouteParam,
    absolute?: boolean,
    config?: Config,
): string;

// Properly extend Vue types
declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        route: typeof route;
    }
}

// Add to Window interface
interface Window {
    route: typeof route;
}
