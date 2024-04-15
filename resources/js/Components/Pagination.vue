<script setup lang="js">
import { Link } from "@inertiajs/vue3";

defineProps({
  links: Object,
})
</script>

<template>
    <div v-if="links.length > 3" class="flex items-center justify-center py-8">
        <div class="flex flex-wrap -mb-1">
            <template v-for="link in links" :key="link.label">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                ></div>
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{
                        'bg-indigo-700 text-white hover:text-indigo-700':
                            link.active,
                    }"
                    :href="link.url"
                    v-html="link.label"
                >
                </Link>
            </template>
        </div>
    </div>
</template>
