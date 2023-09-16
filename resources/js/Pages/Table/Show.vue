<template>
    <Head title="Show" />
    <AuthenticatedLayout>
        <div class="p-d-flex mx-16 py-8">
            <h1 class="text-xl py-8 px-2">
                {{ props.tableData.name }}
            </h1>
            <div v-if="tableData.columns[0].rows.length === 0">
                <Message
                    severity="info"
                    sticky
                >
                    <div class="p-d-flex p-ai-center">
                        <span class="p-mr-2">No data to display. Please add rows to view table.</span>
                    </div>
                </Message>
            </div>
            <DataTable
                v-else
                :value="dataToDisplay"
                striped-rows
                table-style="min-width: 50rem"
                :rows="11"
                paginator
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
import Message from 'primevue/message';
import Button from 'primevue/button';
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
