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
                {{ movie.title }}
            </h2>
        </template>

        <section class="body-font text-gray-800 dark:text-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap">
                <img
                    :src="movie.poster_url" :alt="movie.title"
                    class="lg:w-1/2 w-full object-cover object-center rounded"
                >

                <div class="space-y-4 lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h1 class="text-gray-800 dark:text-gray-200 text-3xl title-font font-medium">{{ movie.title }}</h1>
                    <h2 v-if="movie.title !== movie.original_title"
                        class="text-sm title-font text-gray-800 dark:text-gray-200 tracking-widest">
                        <b class="font-semibold">Original Name:</b> {{ movie.original_title }}
                    </h2>
                    <div class="flex flex-col">
                        <p class="text-sm">
                            <b class="font-semibold">Released date:</b>
                            {{ new Date(movie.release_date).toLocaleDateString() }}
                        </p>
                        <p class="text-sm">
                            <b class="font-semibold">Rating:</b>
                            {{ movie.vote_average }} ({{ movie.vote_count }} votes)
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold mb-2">Overview</h4>
                        <p class="leading-relaxed">{{ movie.overview }}</p>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
