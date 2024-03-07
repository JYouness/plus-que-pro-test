<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import {PropType} from "vue";
import {Movie} from "@/types/movie.js";

defineProps({
    movie: Object as PropType<Movie>,
});
</script>

<template>
    <Head title="Welcome" />

    {{ movie }}
</template>
