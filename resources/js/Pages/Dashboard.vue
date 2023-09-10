<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white align-middle dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
                        <h2 class="mb-6 text-3xl font-extrabold leading-tight tracking-tight text-gray-900 lg:text-center dark:text-white md:text-4xl">
                            <span class="block">Build your next</span>
                            <span
                                class="inline-block text-indigo-600"
                            >Custom Table</span>
                            <span class="block">faster</span>
                        </h2>
                        <p class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl lg:px-64 lg:mb-16">
                            Here you can build your own custom tables, view them, edit them and delete them.
                        </p>
                        <div class="space-y-4 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 xl:gap-8 sm:space-y-0 md:mt-12 mx-8">
                            <div
                                class="cursor-pointer block px-8 py-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-lg dark:hover:shadow-lg-light"
                                @click="visible = true"
                            >
                                <font-awesome-icon
                                    icon="add"
                                    class="w-12 h-12 mx-auto text-indigo-600"
                                />
                                <h3 class="font-semibold text-xl text-gray-900 dark:text-white mt-3.5">
                                    Create Table
                                </h3>
                            </div>
                            <div class="card flex align-items-center justify-content-center">
                                <Card
                                    v-for="(item, index) in tableData"
                                    :key="index"
                                >
                                    <template #title>
                                        {{ item.name }}
                                    </template>
                                    <template #footer>
                                        <a
                                            class="p-button-success p-button-rounded"
                                            size="small"
                                            icon="pi pi-check"
                                            label="View"
                                            :href="route('row.create', item.id)"
                                        >
                                            Edit
                                        </a>
                                        <Button
                                            size="small"
                                            icon="pi pi-times"
                                            label="Delete"
                                            severity="danger"
                                            style="margin-left: 0.5em"
                                        />
                                    </template>
                                </Card>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Sidebar
            v-model:visible="visible"
            position="full"
        >
            <div class="w-full bg-indigo-600 px-6 py-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-base font-semibold text-white lg:text-xl dark:text-white">
                    Table builder
                </h3>
            </div>
            <div class="p-6">
                <div class="my-2 gap-8">
                    <div class="flex gap-2">
                        <div class="flex flex-col">
                            <label for="username">Table Name</label>
                            <InputText
                                id="table_name"
                                v-model="form.name"
                                aria-describedby="table_name"
                            />
                        </div>
                        <div class="flex flex-col">
                            <label for="username">Columns</label>
                            <InputText
                                id="column"
                                v-model="newColumns"
                                type="number"
                                aria-describedby="username-help"
                            />
                        </div>
                        <div class="flex flex-col">
                            <label
                                class="opacity-0"
                                for="username"
                            >Generate</label>
                            <Button
                                :icon="isTableGenerating ? 'pi pi-spin pi-spinner' : 'pi pi-table'"
                                label="Generate"
                                @click.prevent="buildTable"
                            />
                        </div>
                    </div>
                </div>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Rows can be added later dynamically
                </p>
                <div
                    v-if="showGeneratedTable"
                    class="card flex gap-x-8 p-fluid mt-6"
                >
                    <div class="flex gap-x-8">
                        <div
                            v-for="(column, index) in columns"
                            class="flex flex-col"
                        >
                            <label for="username">Column name ({{ index + 1 }})</label>
                            <InputText
                                id="username"
                                v-model="form.columnNames[index]"
                                aria-describedby="username-help"
                            />
                            <div class="card flex justify-content-center mt-3">
                                <Dropdown
                                    v-model="form.columnTypes[index]"
                                    :options="colTypes"
                                    placeholder="Select a column type"
                                    class="w-full md:w-14rem"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <Button
                    label="Create Tables"
                    :icon="isTableOpen ? 'pi pi-spin pi-spinner' : 'pi pi-table'"
                    class="mt-6"
                    @click.prevent="submitTableData"
                >
                    Create Table
                </Button>
            </div>
        </Sidebar>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Sidebar from 'primevue/sidebar';
import Button from 'primevue/button';
import Dropdown from 'primevue/listbox';
import InputText from 'primevue/inputtext';
import Card from 'primevue/card';
import { useToast } from 'primevue/usetoast';

defineProps({
    tableData: {
        type: Array,
        required: true,
    },
});

const isTableOpen = ref(false);
const newColumns = ref();
const newRows = ref();
const columns = ref([]);
const rows = ref([]);
const isTableGenerating = ref(false);
const showGeneratedTable = ref(false);
const visible = ref(false);
const toast = useToast();

const form = useForm({
    name: '',
    columns: [],
    columnNames: [],
    columnTypes: [],
});

const colTypes = ref([
    'Text',
    'Number',
    'Date',
    'Time',
    'DateTime',
    'Boolean',
    'Email',
]);

function buildTable() {
    isTableGenerating.value = true;
    return new Promise((resolve, reject) => {
        columns.value = [];
        form.columnNames = [];

        for (let i = 0; i < newColumns.value; i++) {
            columns.value.push(`Column ${i + 1}`);
            form.columnNames.push('');
        }

        resolve();
    }).then(() => {
        setTimeout(() => {
            isTableGenerating.value = false;
            showGeneratedTable.value = true;
        }, 500);
    });
}

function submitTableData() {
    form
        .post(route('column.store'), {
            onSuccess: () => {
                // isTableOpen.value = false;
                // showGeneratedTable.value = false;
                form.reset();
                columns.value = [];
                rows.value = [];
                visible.value = false;
            },
        });
}
</script>
