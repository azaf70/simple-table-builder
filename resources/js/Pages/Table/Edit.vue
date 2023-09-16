<template>
    <Head title="Edit" />
    <AuthenticatedLayout>
        <div class="container">
            <div class="row">
                <h1 class="bg-gray-100">
                    Table Template
                </h1>
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
                <DataTable
                    :value="items"
                    data-key="label"
                >
                    <Column
                        v-for="(item, index) in items"
                        :key="index"
                        :header="item.field"
                    />
                </DataTable>
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
                            v-if="item.field !== 'Created At' && item.field !== 'Deleted At'"
                            class="my-4"
                        >
                            <label
                                class="block"
                                :for="item.field"
                            >{{ item.field }}</label>
                            <InputText
                                :id="item.field"
                                v-model="item.value"
                                :type="item.type"
                                required="true"
                                autofocus
                                class="mt-0 block w-full sm:text-sm border-gray-300 rounded-md"
                                :class="{'p-invalid': form.errors[item.field]}"
                            />
                            <small
                                v-if="submitted && form.errors[item.field]"
                                class="p-error"
                            >{{ form.errors[item.field] }}</small>
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
    </AuthenticatedLayout>
</template>

<script setup>

import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { onMounted, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';

const props = defineProps({
    tableTemplate: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    items: [],
});
const items = ref([]);
const toast = useToast();
const tableDialog = ref(false);
const product = ref({});
const submitted = ref(false);

onMounted(() => {
    props.tableTemplate.column_data.forEach((item) => {
        items.value.push({
            field: item.name,
            type: item.type,
        });
    });

    items.value.forEach((item, index) => {
        form.items.push({
            field: item.field,
            type: item.type,
            value: '',
        });
    });
});

const openModal = () => {
    product.value = {};
    submitted.value = false;
    tableDialog.value = true;
};
const hideDialog = () => {
    tableDialog.value = false;
    submitted.value = false;
};
const submit = () => {
    form.post(route('table-template.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.items = [];
            toast.add({ severity: 'success', summary: 'Success', detail: 'Product Created', life: 3000 });
            hideDialog();
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Product Not Created', life: 3000 });
        },
    });
};
</script>

<style scoped>

</style>
