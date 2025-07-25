<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import ChangeLogs from '@/components/HTML/ChangeLogs.vue';
import ResetSaveButtons from '@/components/HTML/ResetSaveButtons.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';
import { DataTable } from '@/DataTable/types';
import { OrderStatus } from '@/enums/OrderStatus';
import Tick from '@/icons/Tick.vue';
import { type BreadcrumbItem, ChangeLog, Order, OrderForm } from '@/types';
import { replaceEnumUnderscores, withFlash } from '@/utils';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
    order: Order;
    changeLogs?: DataTable<ChangeLog>;
}>();

const form = useForm<OrderForm>({
    _method: 'put',
    id: props.order.id,
    status: props.order.status,
    delivery_address: props.order.delivery_address,
    phone: props.order.phone,
    additional_requirements: props.order.additional_requirements,
    total_price: props.order.total_price,
    delivery_date: props.order.delivery_date,
    name: props.order.name,
    email: props.order.email,
});

const save = async (only?: Array<string>) => {
    return new Promise<void>((resolve, reject) => {
        form.post(route('admin.orders.update', props.order.id as number), {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true, // preserves all form data
            only: withFlash(only),
            onSuccess: () => {
                resolve();
            },
            onError: () => {
                reject(new Error('Error, during update'));
            },
        });
    });
};

const checkClickableStatus = (status: number) => {
    return status > props.order.status;
};

const handleStatusUpdate = async (status: number) => {
    if (!checkClickableStatus(status)) {
        return;
    }

    form.status = status;

    await save();
};

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
        title: 'Edit',
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
                                            :class="{
                                                'cursor-pointer':
                                                    checkClickableStatus(
                                                        status.value as number,
                                                    ),
                                            }"
                                            @click="
                                                handleStatusUpdate(
                                                    status.value as number,
                                                )
                                            "
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
                            <form
                                class="mt-6 space-y-6"
                                @submit.prevent="save()"
                            >
                                <div>
                                    <InputLabel for="name" value="Name" />

                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="phone"
                                        value="Delivery Phone"
                                    />

                                    <TextInput
                                        id="phone"
                                        v-model="form.phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.phone"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="delivery_address"
                                        value="Delivery Address"
                                    />

                                    <TextInput
                                        id="delivery_address"
                                        v-model="form.delivery_address"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.delivery_address"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="additional_requirements"
                                        value="Additional Requirements"
                                    />

                                    <TextInput
                                        id="additional_requirements"
                                        v-model="form.additional_requirements"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="
                                            form.errors.additional_requirements
                                        "
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="total_price"
                                        value="Total Price"
                                    />

                                    <TextInput
                                        id="total_price"
                                        v-model="form.total_price"
                                        type="number"
                                        step="0.01"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="
                                            form.errors.total_price
                                        "
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="delivery_date"
                                        value="Delivery Date"
                                    />

                                    <TextInput
                                        id="delivery_date"
                                        v-model="form.delivery_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.delivery_date"
                                    />
                                </div>

                                <ResetSaveButtons
                                    :processing="form.processing"
                                    :recently-successful="
                                        form.recentlySuccessful
                                    "
                                    @reset="form.reset()"
                                />
                            </form>
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
