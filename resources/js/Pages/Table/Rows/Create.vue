<template>
    <Head title="Create Rows" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Rows
            </h2>
        </template>

        <div class="container px-8">
            <div class="row">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight py-4">
                    {{ tableData.name }}
                </h2>
                <Toolbar class="mb-4">
                    <template #start>
                        <Button
                            label="New"
                            icon="pi pi-plus"
                            severity="success"
                            class="mr-2"
                            @click="openModal"
                        />
                    </template>
                </Toolbar>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                                >
                                    Columns
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                                >
                                    Column Type
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                                >
                                    Validation Rules
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-800"
                                >
                                    Created At
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="col in columns"
                                :key="col.id"
                                class="border-b border-gray-200 dark:border-gray-700"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                                >
                                    {{ col.name }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                                >
                                    {{ col.type }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                                >
                                    {{ col.validation_rules.flatMap(rule => rule).join(', ') }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800"
                                >
                                    {{ col.created_at }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <Dialog
                    v-model:visible="tableDialog"
                    :style="{width: '450px'}"
                    header="Add Details"
                    :modal="true"
                    class="p-fluid"
                >
                    <div
                        v-for="(item, index) in form.items"
                        :key="index"
                        class="p-field p-col-12 p-md-4"
                    >
                        <div
                            v-if="item.column !== 'Created At' && item.column !== 'Deleted At'"
                            class="my-4"
                        >
                            <label
                                class="block"
                                :for="item.column"
                            >{{ item.column }}</label>
                            <Dropdown
                                v-if="item.type === 'Boolean'"
                                :id="item.column"
                                v-model="item.value"
                                :options="[true, false]"
                                required="true"
                                autofocus
                                class="mt-0 block w-full sm:text-sm border-gray-300 rounded-md"
                                :class="{'p-invalid': form.errors['items.' + index + '.value']}"
                            />
                            <InputText
                                v-else
                                :id="item.column"
                                v-model="item.value"
                                :type="item.type"
                                required="true"
                                autofocus
                                class="mt-0 block w-full sm:text-sm border-gray-300 rounded-md"
                                :class="{'p-invalid': form.errors['items.' + index + '.value']}"
                            />
                            <small
                                v-if="form.errors['items.' + index + '.value']"
                                class="p-error"
                            >{{ form.errors['items.' + index + '.value'] }}</small>
                        </div>
                    </div>
                    <template #footer>
                        <Button
                            label="Cancel"
                            icon="pi pi-times"
                            text
                            @click="hideDialog"
                        />
                        <Button
                            label="Save"
                            icon="pi pi-check"
                            text
                            @click="submit"
                        />
                    </template>
                </Dialog>
            </div>
        </div>
        <Toast />
    </AuthenticatedLayout>
</template>

<script setup>

import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import { onMounted, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    tableData: {
        type: Array,
        required: true
    }
});

const form = useForm({
    items: [],
    table_id: props.tableData.id,
});
const toast = useToast();
const tableDialog = ref(false);
const submitted = ref(false);

onMounted(() => {
    props.columns.forEach((column) => {
        form.items.push({
            column_id: column.id,
            column: column.name,
            type: column.type,
            validation_rules: column.validation_rules,
            value: '',
        });
    });
});

const openModal = () => {
    submitted.value = false;
    tableDialog.value = true;
};
const hideDialog = () => {
    tableDialog.value = false;
    submitted.value = false;
};
const submit = () => {
    form.post(route('row.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: 'Product Created', life: 3000 });
            form.items.forEach((item) => {
                item.value = '';
            });
            hideDialog();
        },
        onError: (error) => {
            const errorArray = [...Object.values(error)];
            errorArray.forEach((error, errorIndex) => {
                props.columns.find((column, colIndex) => {
                    if (colIndex === errorIndex) {
                        [...Object.values(form.errors)].map((err) => {
                            if (err.includes('items.' + errorIndex + '.value')) {
                                form.errors['items.' + errorIndex + '.value'] = err.replace('items.' + errorIndex + '.value', column.name);
                            }
                        });
                    }
                });
            });
            toast.add({ severity: 'error', summary: 'Error', detail: 'Item could not be added', life: 3000 });
        },
    });
};

</script>

<style scoped>

</style>
