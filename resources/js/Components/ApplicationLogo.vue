<template>
    <font-awesome-icon
        class="mx-auto text-green-500 dark:text-blue-400"
        icon="table"
        :size="size"
        fixed-width
    />
</template>
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { computed } from 'vue';

const props = defineProps({
    size: {
        type: String,
        default: 2,
    },
});

const size = computed(() => {
    if (['xs', 'sm', 'md', 'lg', 'xl', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x'].includes(props.size)) {
        return props.size;
    }
});
</script>
