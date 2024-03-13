<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3'
import { PropType, toRefs } from 'vue'
import { PaginatedApiResponse } from '@/types/api.js'
import { Movie } from '@/types/movie.js'
import Pagination from '@/Components/Pagination.vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { route } from 'ziggy-js'

const props = defineProps({
    laravelVersion: {
        type: String,
        required: true
    },
    phpVersion: {
        type: String,
        required: true
    },
    movies: {
        type: Object as PropType<PaginatedApiResponse<Movie>>,
        required: true
    },
    term: {
        type: String,
        required: true
    }
})

const { term } = toRefs(props)
const form = useForm({
    term: term?.value
})

const search = (): void => {
    const url = route('home')

    if (form.term && form.term !== '') return form.get(url)

    router.visit(url)
}
</script>

<template>
    <PublicLayout title="Welcome">
        <h1 class="text-3xl text-center text-gray-500 dark:text-gray-400 mb-6">
            Trending Movies (Daily)
        </h1>

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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Pagination :links="movies.meta.links" />

            <div
                v-if="movies.data.length > 0"
                class="mt-6 grid grid-cols-3 gap-4"
            >
                <div v-for="movie in movies.data" :key="movie.id">
                    <Link
                        :href="route('public.movies.show', { movie: movie.id })"
                    >
                        <div
                            class="relative max-w-sm overflow-hidden rounded-xl bg-white shadow-md duration-200 hover:scale-105 hover:shadow-xl"
                        >
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
                </div>
            </div>

            <Pagination :links="movies.meta.links" />
        </div>
    </PublicLayout>
</template>
