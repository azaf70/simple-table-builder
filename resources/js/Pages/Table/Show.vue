<template>
    <Head title="Show" />
    <AuthenticatedLayout>
        <div class="p-d-flex mx-16 py-8">
            <h1 class="text-xl py-8 px-2">
                {{ props.tableData.name }}
            </h1>
            <DataTable
                :value="dataToDisplay"
                striped-rows
                table-style="min-width: 50rem"
            >
                <Column
                    v-for="(column, index) in tableData.columns"
                    :key="index"
                    :field="column.name"
                    :header="column.name"
                />
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { onMounted, ref } from 'vue';

const props = defineProps({
    tableData: {
        type: Object,
        required: true,
    },
});

const dataToDisplay = ref([]);

onMounted(() => {
    props.tableData.columns.forEach((column) => {
        column.rows.map((row, index) => {
            if (dataToDisplay.value[index] === undefined) {
                dataToDisplay.value[index] = {};
            }
            dataToDisplay.value[index][column.name] = row.value;
        });
    });
});


</script>

<style scoped>

</style>
