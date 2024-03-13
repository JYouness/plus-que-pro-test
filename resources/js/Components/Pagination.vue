<script setup lang="ts">
import type { PaginatedLink } from '@/types/api'
import { Link } from '@inertiajs/vue3'

defineProps<{
    links: PaginatedLink[]
}>()
</script>

<template>
    <nav
        v-if="links.length > 3"
        class="flex flex-wrap -mb-1 justify-center mt-6"
    >
        <template v-for="(link, p) in links" :key="p">
            <div
                v-if="link.url === null"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 rounded"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 rounded focus:border-indigo-500 focus:text-indigo-500"
                :class="{
                    'bg-white dark:bg-gray-800 dark:text-white': link.active,
                    'cursor-pointer dark:text-white bg-gray-100 dark:bg-gray-900 hover:bg-white hover:text-black':
                        !link.active
                }"
                v-html="link.label"
            />
        </template>
    </nav>
</template>
