import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export type FormMethod = {
    _method?: string;
};

export type Form = {
    [key: string]: any;
};

export interface Product {
    id: number;
    creator_id: number;
    creator: User
    image: string;
    slug: string;
    title: string;
    description: string;
    price: number;
}

export interface ProductForm extends Form, FormMethod {

}

export interface DeleteForm {
    id: number;
    name: string;
    amount?: number;
    created_at?: Date;
}
