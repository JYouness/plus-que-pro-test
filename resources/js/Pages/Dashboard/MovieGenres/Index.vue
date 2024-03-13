<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { CollectionApiResponse } from '@/types/api'
import { MovieGenre } from '@/types/movie'

defineProps<{
    genres: CollectionApiResponse<MovieGenre>
}>()
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Movie Genres
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Genre</th>
                                <th scope="col" class="px-6 py-3 text-end">
                                    Movies Count
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="genre in genres.data"
                                :key="genre.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ genre.name }}
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ genre.movies_count }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
