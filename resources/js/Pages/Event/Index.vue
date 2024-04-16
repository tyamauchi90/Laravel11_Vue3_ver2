<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import EventBread from "../../Components/EventBread.vue";

const props = defineProps({
    events: Object,
    links: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <EventBread />
        <FlashMessage />
        <div class="space-y-4 w-11/12 mx-auto">
            <h1 class="my-3">Events</h1>
            <ul v-for="event in events.data" :key="event.id" class="space-y-4">
                <li class="m-4">
                    <div class="bg-white p-8 space-y-4">
                        <Link :href="route('event.show', { event: event.id })">
                            <span
                                class="text-indigo-600 hover:text-indigo-400 font-medium"
                            >
                                イベント日：{{ event.event_date }}
                            </span>
                        </Link>
                        <p>件名：{{ event.title }}</p>
                        <div>
                            イベント内容：
                            <p class="whitespace-pre-line">
                                {{ event.content }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
            <Pagination :links="props.links" />
        </div>
    </AuthenticatedLayout>
</template>
