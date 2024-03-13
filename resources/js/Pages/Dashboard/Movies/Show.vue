<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Movie } from '@/types/movie'
import { route } from 'ziggy-js'
import { Link, router } from '@inertiajs/vue3'

defineProps<{
    movie: {
        data: Movie
    }
}>()

const deleteMovie = (movie: Movie) => {
    if (confirm(`Are you sure you want to delete "${movie.title}"?`)) {
        router.delete(
            route('dashboard.movies.show', {
                movie: movie.id
            })
        )
    }
}
</script>

<template>
    <AppLayout :title="movie.data.title">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ movie.data.title }}
            </h2>
        </template>

        <section class="body-font text-gray-800 dark:text-gray-200">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap"
            >
                <img
                    :src="movie.data.poster_url"
                    :alt="movie.data.title"
                    class="lg:w-1/2 w-full object-cover object-center rounded"
                />

                <div
                    class="space-y-4 lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0"
                >
                    <h1
                        class="text-gray-800 dark:text-gray-200 text-3xl title-font font-medium"
                    >
                        {{ movie.data.title }}
                    </h1>
                    <div
                        v-if="movie.data.genres && movie.data.genres.length > 0"
                    >
                        <span
                            v-for="genre in movie.data.genres" :key="genre.id"
                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300"
                        >
                            {{ genre.name }}
                        </span>
                    </div>
                    <h2
                        v-if="movie.data.title === movie.data.original_title"
                        class="text-sm title-font dark:text-gray-200 tracking-widest"
                    >
                        <b class="font-semibold text-gray-500 uppercase"
                            >Original Name:</b
                        ><br />
                        {{ movie.data.original_title }}
                    </h2>
                    <p class="text-sm">
                        <b class="font-semibold text-gray-500 uppercase"
                            >Released date:</b
                        ><br />
                        {{
                            new Date(
                                movie.data.release_date
                            ).toLocaleDateString()
                        }}
                    </p>
                    <p class="text-sm">
                        <b class="font-semibold text-gray-500 uppercase"
                            >Rating:</b
                        ><br />
                        {{ movie.data.vote_average }} ({{
                            movie.data.vote_count
                        }}
                        votes)
                    </p>
                    <div>
                        <h4
                            class="text-xl font-semibold text-gray-500 uppercase mb-2"
                        >
                            Overview
                        </h4>
                        <p class="leading-relaxed">{{ movie.data.overview }}</p>
                    </div>
                    <div
                        class="flex flex-row bg-white dark:bg-gray-800"
                        role="group"
                    >
                        <Link
                            :href="
                                route('dashboard.movies.edit', {
                                    movie: movie.data.id
                                })
                            "
                            class="basis-full bg-gray-700 px-6 pb-2 pt-2.5 text-center text-xs font-medium uppercase leading-normal text-black dark:text-white transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                        >
                            Edit
                        </Link>
                        <button
                            type="button"
                            class="basis-full bg-red-500 px-6 pb-2 pt-2.5 text-center text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-red-700 focus:bg-red-700 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                            @click.prevent="deleteMovie(movie.data)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
