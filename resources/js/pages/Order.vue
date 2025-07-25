<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextInput from '@/components/TextInput.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { OrderForm, Product } from '@/types';
import { TrashIcon } from '@heroicons/vue/20/solid';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    cartItems: Product[];
    cart: any;
    totalPrice: number;
}>();

const form = useForm<OrderForm>({
    email: null!,
    name: null!,
    phone: null!,
    delivery_address: null!,
    additional_requirements: null!,
});

const deleteForm = useForm<{
    product_id: number;
}>({
    product_id: null!,
});

const quantityForm = useForm<any>({
    ...props.cart,
});

const submit = async () => {
    return new Promise<void>((resolve, reject) => {
        form.post(route('cart.save'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resolve();
            },
            onError: () => {
                reject(new Error('Error, during update'));
            },
        });
    });
};

const removeFromCart = async (productId: number) => {
    deleteForm.product_id = productId;
    return new Promise<void>((resolve, reject) => {
        deleteForm.post(route('cart.remove'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                deleteForm.reset();
                resolve();
            },
            onError: () => {
                reject(new Error('Error during removal'));
            },
        });
    });
};

const handleQuantityChange = () => {
    return new Promise<void>((resolve, reject) => {
        quantityForm.post(route('cart.change-quantity'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resolve();
            },
            onError: () => {
                reject(new Error('Error during quantity change'));
            },
        });
    });
};
</script>

<template>
    <Head title="Cart" />

    <GuestLayout :nav-transparent="false">
        <div class="mt-10 bg-gray-50 pb-16">
            <div
                class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8"
            >
                <h2 class="sr-only">Checkout</h2>
                <div v-if="cartItems.length === 0" class="py-20 text-center">
                    <h2 class="text-2xl font-semibold text-gray-700">
                        Cart is empty
                    </h2>

                    <Link
                        :href="route('products')"
                        class="mt-4 inline-block rounded-md bg-cyan-500 px-6 py-3 text-white hover:bg-cyan-700"
                    >
                        Continue with shopping
                    </Link>
                </div>
                <div v-else>
                    <form
                        class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16"
                        @submit.prevent="submit"
                    >
                        <div>
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">
                                    Your information
                                </h2>

                                <div class="mt-4">
                                    <div>
                                        <label
                                            for="name"
                                            class="mt-3 block text-sm font-medium text-gray-700"
                                            >Name *</label
                                        >

                                        <div class="mt-1">
                                            <input
                                                type="text"
                                                id="name"
                                                v-model="form.name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                required
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.name"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label
                                            for="phone"
                                            class="mt-3 block text-sm font-medium text-gray-700"
                                            >Phone *</label
                                        >

                                        <div class="mt-1">
                                            <input
                                                id="phone"
                                                type="text"
                                                v-model="form.phone"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                required
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.phone"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label
                                            for="email"
                                            class="mt-3 block text-sm font-medium text-gray-700"
                                            >Email</label
                                        >

                                        <div class="mt-1">
                                            <input
                                                id="email"
                                                type="email"
                                                v-model="form.email"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.email"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label
                                            for="delivery_address"
                                            class="mt-3 block text-sm font-medium text-gray-700"
                                            >Delivery Address</label
                                        >

                                        <div class="mt-1">
                                            <input
                                                id="delivery_address"
                                                type="text"
                                                v-model="form.delivery_address"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.delivery_address"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label
                                            for="additional_requirements"
                                            class="mt-3 block text-sm font-medium text-gray-700"
                                            >Additional requirements</label
                                        >

                                        <div class="mt-1">
                                            <input
                                                id="additional_requirements"
                                                type="text"
                                                v-model="
                                                    form.additional_requirements
                                                "
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.additional_requirements"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order summary -->
                        <div>
                            <div class="mt-10 lg:mt-0">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Products in cart
                                </h2>

                                <div
                                    class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm"
                                >
                                    <h3 class="sr-only">Items in your cart</h3>
                                    <ul
                                        role="list"
                                        class="divide-y divide-gray-200"
                                    >
                                        <li
                                            v-for="cartItem in cartItems"
                                            :key="cartItem.id"
                                            class="flex items-start gap-4 rounded-lg border border-gray-200 bg-white px-4 py-6 shadow-sm sm:px-6"
                                        >
                                            <!-- Product image -->
                                            <img
                                                :src="`/storage/${cartItem.image}`"
                                                alt="alt"
                                                class="h-20 w-20 rounded-md object-cover"
                                            />

                                            <!-- Product details and actions -->
                                            <div class="flex flex-1 flex-col justify-between">
                                                <!-- Top row: title + remove -->
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-base font-medium text-gray-900">
                                                            <Link
                                                                :href="route('product', cartItem.slug)"
                                                                class="hover:underline hover:text-indigo-600"
                                                            >
                                                                <div>
                                                                    {{ cartItem.title }}
                                                                </div>
                                                                <div v-if="cartItem.category">
                                                                    {{ cartItem.category.title }}
                                                                </div>
                                                            </Link>
                                                        </h4>
                                                        <p class="text-sm text-gray-500">
                                                            {{ cartItem.price }} lv. each
                                                        </p>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        @click="removeFromCart(cartItem.id)"
                                                        class="text-gray-400 hover:text-red-500 transition"
                                                        title="Remove item"
                                                    >
                                                        <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                                    </button>
                                                </div>

                                                <!-- Bottom row: quantity & subtotal -->
                                                <div class="mt-4 flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-2">
                                                        <label
                                                            for="quantity"
                                                            class="text-sm text-gray-700"
                                                        >
                                                            Qty:
                                                        </label>
                                                        <TextInput
                                                            id="quantity"
                                                            name="quantity"
                                                            type="number"
                                                            step="1"
                                                            min="0"
                                                            class="w-20 rounded-md border border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                            v-model="quantityForm[cartItem.id].quantity"
                                                            @change="handleQuantityChange"
                                                        />
                                                    </div>

                                                    <div class="text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                        {{ (quantityForm[cartItem.id].quantity * cartItem.price).toFixed(2) }} lv.
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <dl
                                        class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6"
                                    >
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <dt class="text-base font-medium">
                                                Total Price
                                            </dt>
                                            <dd
                                                class="text-base font-medium text-gray-900"
                                            >
                                                {{ totalPrice }} lv.
                                            </dd>
                                        </div>
                                    </dl>

                                    <div
                                        class="border-t border-gray-200 px-4 py-6 sm:px-6"
                                    >
                                        <button
                                            class="w-full rounded-md border border-transparent bg-cyan-500 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50"
                                            :disabled="form.processing"
                                        >
                                            Send Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
