<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { MovieGenre } from '@/types/movie'
import { CollectionApiResponse } from '@/types/api'

defineProps<{
    genres: CollectionApiResponse<MovieGenre>
    languages: Record<string, string>
}>()

const form = useForm({
    title: '',
    original_title: '',
    overview: '',
    original_language: '',
    release_date: '',
    genre_ids: []
})

const submit = (): void => {
    if (form.processing) return

    form.clearErrors()

    form.post(route('dashboard.movies.store'))
}
</script>

<template>
    <AppLayout title="New Movie">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Add a new Movie
            </h2>
        </template>

        <section class="body-font text-gray-800 dark:text-gray-200">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap"
            >
                <div
                    class="w-full bg-white dark:bg-gray-800 rounded shadow-lg p-4 px-4 md:p-8 mb-6"
                >
                    <div
                        class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3"
                    >
                        <div class="text-gray-600 dark:text-gray-400">
                            <p class="font-medium text-lg">Movie Details</p>
                            <p>Please fill out the fields.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <form @submit.prevent="submit">
                                <div
                                    class="grid gap-4 text-sm grid-cols-1 md:grid-cols-5"
                                >
                                    <div class="md:col-span-5">
                                        <label
                                            for="title"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Title</label
                                        >
                                        <input
                                            id="title"
                                            v-model="form.title"
                                            type="text"
                                            name="title"
                                            placeholder="Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.title"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.title"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="original_title"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Original Title</label
                                        >
                                        <input
                                            id="original_title"
                                            v-model="form.original_title"
                                            type="text"
                                            name="original_title"
                                            placeholder="Original Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.original_title"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.original_title"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <h3
                                            class="mb-4 font-semibold text-gray-900 dark:text-white"
                                        >
                                            Genres
                                        </h3>

                                        <div class="grid grid-cols-4 gap-3">
                                            <div
                                                v-for="genre in genres.data"
                                                :key="genre.id"
                                                class=""
                                            >
                                                <input
                                                    :id="`genre[${genre.id}]`"
                                                    v-model="form.genre_ids"
                                                    type="checkbox"
                                                    :value="genre.tmbd_id"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                />
                                                <label
                                                    :for="`genre[${genre.id}]`"
                                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >{{ genre.name }}</label
                                                >
                                            </div>
                                        </div>

                                        <span
                                            v-if="form.errors.genre_ids"
                                            class="mt-4 inline-block text-sm text-red-500"
                                            v-text="form.errors.genre_ids"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="overview"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Overview</label
                                        >
                                        <textarea
                                            id="overview"
                                            v-model="form.overview"
                                            name="overview"
                                            class="h-30 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        ></textarea>
                                        <span
                                            v-if="form.errors.overview"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.overview"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="original_language"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Original Language</label
                                        >
                                        <select
                                            id="original_language"
                                            v-model="form.original_language"
                                            name="original_language"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            <option value="">
                                                Select Original Language
                                            </option>
                                            <option
                                                v-for="(
                                                    language, key
                                                ) in languages"
                                                :key="key"
                                                :value="key"
                                                :selected="
                                                    form.original_language ===
                                                    language
                                                "
                                                v-text="language"
                                            />
                                        </select>

                                        <span
                                            v-if="form.errors.original_language"
                                            class="text-sm text-red-500"
                                            v-text="
                                                form.errors.original_language
                                            "
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="release_date"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Release Date</label
                                        >
                                        <input
                                            id="release_date"
                                            v-model="form.release_date"
                                            type="date"
                                            name="release_date"
                                            placeholder="Original Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.release_date"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.release_date"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5 text-right">
                                        <div class="inline-flex items-end">
                                            <button
                                                type="submit"
                                                :disabled="form.processing"
                                                class="uppercase bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded disabled:opacity-25"
                                                v-text="
                                                    form.processing
                                                        ? 'Processing...'
                                                        : 'Submit'
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
