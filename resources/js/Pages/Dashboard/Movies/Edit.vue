<script setup lang="ts">
import {type PropType} from "vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import {Movie} from "@/types/movie";

defineProps({
    movie: Object as PropType<Movie>,
});
</script>

<template>
    <AppLayout :title="movie.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Movie: {{ movie.title }}
            </h2>
        </template>


    </AppLayout>
</template>
