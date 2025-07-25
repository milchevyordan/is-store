<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import ChangeLogs from '@/components/HTML/ChangeLogs.vue';
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';
import { DataTable } from '@/DataTable/types';
import { OrderStatus } from '@/enums/OrderStatus';
import Tick from '@/icons/Tick.vue';
import { type BreadcrumbItem, ChangeLog, Order } from '@/types';
import { replaceEnumUnderscores } from '@/utils';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{
    order: Order;
    changeLogs?: DataTable<ChangeLog>;
}>();

const statuses = Object.entries(OrderStatus)
    .filter(([name]) => isNaN(Number(name)))
    .map(([name, value]) => ({
        name,
        value,
    }));

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Order',
        href: '',
    },
    {
        title: 'Show',
        href: '',
    },
];
</script>

<template>
    <Head :title="'Order'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="mt-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid gap-4 lg:grid-cols-1 xl:grid-cols-2">
                            <div class="mt-6 space-y-6">
                                <div class="p-2 pt-8">
                                    <ol class="flex items-center">
                                        <li
                                            v-for="(status, index) in statuses"
                                            :key="index"
                                            class="relative mb-6 w-full"
                                        >
                                            <div class="flex items-center">
                                                <div
                                                    class="z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-full ring-0 ring-white sm:ring-8 dark:ring-gray-900"
                                                    :class="{
                                                        'bg-blue-600 dark:bg-blue-900':
                                                            order.status >=
                                                            (status.value as number),
                                                        'bg-gray-200 dark:bg-gray-700':
                                                            order.status <
                                                            (status.value as number),
                                                    }"
                                                >
                                                    <Tick />
                                                </div>
                                                <div
                                                    v-if="
                                                        (status.value as number) <
                                                        statuses.length
                                                    "
                                                    class="flex h-0.5 w-full bg-gray-200 dark:bg-gray-700"
                                                />
                                            </div>
                                            <div class="mt-3">
                                                <h3
                                                    class="font-medium"
                                                    :class="{
                                                        'text-gray-900 dark:text-white':
                                                            order.status >=
                                                            (status.value as number),
                                                        'text-gray-200 dark:text-gray-700':
                                                            order.status <
                                                            (status.value as number),
                                                    }"
                                                >
                                                    {{
                                                        replaceEnumUnderscores(
                                                            status.name,
                                                        )
                                                    }}
                                                </h3>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid gap-4 lg:grid-cols-1 xl:grid-cols-2">
                            <div class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="name" value="Name" />

                                    <TextInput
                                        id="name"
                                        :model-value="order.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="phone"
                                        value="Delivery Phone"
                                    />

                                    <TextInput
                                        id="phone"
                                        :model-value="order.phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        :model-value="order.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="delivery_address"
                                        value="Delivery Address"
                                    />

                                    <TextInput
                                        id="delivery_address"
                                        :model-value="order.delivery_address"
                                        type="text"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="additional_requirements"
                                        value="Additional Requirements"
                                    />

                                    <TextInput
                                        id="additional_requirements"
                                        :model-value="
                                            order.additional_requirements
                                        "
                                        type="text"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="total_price"
                                        value="Total Price"
                                    />

                                    <TextInput
                                        id="total_price"
                                        :model-value="order.total_price"
                                        type="number"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="delivery_date"
                                        value="Delivery Date"
                                    />

                                    <TextInput
                                        id="delivery_date"
                                        :model-value="order.delivery_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ChangeLogs
                    :change-logs-limited="order.change_logs_limited"
                    :change-logs="changeLogs"
                />
            </div>
        </div>
    </AppLayout>
</template>
