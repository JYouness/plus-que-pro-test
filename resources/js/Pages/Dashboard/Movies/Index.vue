<script setup lang="ts">
import { toRefs } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { PaginatedApiResponse } from '@/types/api'
import { Movie } from '@/types/movie'
import { route } from 'ziggy-js'

const props = defineProps<{
    movies: PaginatedApiResponse<Movie>
    term: String
}>()

const { term } = toRefs(props)
const form = useForm({
    term: term?.value
})

const search = (): void => {
    const url = route('dashboard.movies.index')

    if (form.term && form.term !== '') return form.get(url)

    router.visit(url)
}

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
    <AppLayout title="Dashboard">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Trending Movies (Daily)
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <Link
                        :href="route('dashboard.movies.create')"
                        class="inline-block uppercase bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded"
                        >Add Movie</Link
                    >
                </div>

                <form class="max-w-md mx-auto" @submit.prevent="search">
                    <label
                        for="search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                        >Search</label
                    >
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            id="search"
                            v-model="form.term"
                            type="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search Mockups, Logos..."
                        />
                        <button
                            type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Search
                        </button>
                    </div>
                </form>

                <Pagination :links="movies.meta.links" />

                <div
                    v-if="movies.data.length > 0"
                    class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3"
                >
                    <div
                        v-for="movie in movies.data"
                        :key="movie.id"
                        class="overflow-hidden rounded-xl shadow-md hover:shadow-xl hover:scale-105 duration-200"
                    >
                        <Link
                            :href="
                                route('dashboard.movies.show', {
                                    movie: movie.id
                                })
                            "
                        >
                            <div class="relative">
                                <img
                                    :src="movie.backdrop_url"
                                    :alt="movie.title"
                                    class="h-auto w-full"
                                />
                                <p
                                    class="absolute left-0 bottom-0 text-white w-full p-2 bg-black bg-opacity-50"
                                >
                                    {{ movie.title }}
                                </p>
                            </div>
                        </Link>
                        <div
                            class="flex flex-row bg-white dark:bg-gray-800"
                            role="group"
                        >
                            <Link
                                :href="
                                    route('dashboard.movies.edit', {
                                        movie: movie.id
                                    })
                                "
                                class="basis-full bg-gray-700 px-6 pb-2 pt-2.5 text-center text-xs font-medium uppercase leading-normal text-black dark:text-white transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                class="basis-full bg-red-500 px-6 pb-2 pt-2.5 text-center text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-red-700 focus:bg-red-700 focus:outline-none focus:ring-0 active:bg-primary-600 motion-reduce:transition-none"
                                @click.prevent="deleteMovie(movie)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <Pagination :links="movies.meta.links" />
            </div>
        </div>
    </AppLayout>
</template>
