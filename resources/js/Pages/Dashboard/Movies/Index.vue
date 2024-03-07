<script setup lang="ts">
import {type PropType} from "vue";
import {Link, router} from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import {PaginatedApiResponse} from "@/types/api";
import {Movie} from "@/types/movie";
import {route} from "ziggy-js";

defineProps({
    movies: Object as PropType<PaginatedApiResponse<Movie>>,
});

const deleteMovie = (movie: Movie) => {
    if (confirm(`Are you sure you want to delete "${movie.title}"?`)) {
        router.delete(route('dashboard.movies.show', {
            'movie': movie.id,
        }))
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Trending Movies (Daily)
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="movies.data.length > 0" class="grid grid-cols-3 gap-4">
                    <div v-for="movie in movies.data" :key="movie.id" class="max-w-sm overflow-hidden rounded-xl shadow-md hover:scale-105 hover:shadow-xl duration-200">
                        <Link :href="route('dashboard.movies.show', {movie: movie.id})">
                            <div class="relative ">
                                <img :src="movie.backdrop_url" :alt="movie.title" class="h-auto w-full" />
                                <p class="absolute left-0 bottom-0 text-white w-full p-2 bg-black bg-opacity-50">{{ movie.title }}</p>
                            </div>
                        </Link>
                        <div
                            class="flex rounded-md shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-1 dark:focus:shadow-dark-1 dark:active:shadow-dark-1"
                            role="group">
                            <Link
                                :href="route('dashboard.movies.edit', {movie: movie.id})"
                                class="bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 focus:bg-primary-accent-300 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                            >
                                Edit
                            </Link>
                            <button
                                @click.prevent="deleteMovie(movie)" type="button"
                                class="bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 focus:bg-primary-accent-300 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <Pagination :links="movies.meta.links"/>
            </div>
        </div>
    </AppLayout>
</template>
