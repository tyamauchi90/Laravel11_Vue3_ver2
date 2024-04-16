<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { events, links } = defineProps({
    events: Object,
    links: Object,
});
</script>

<template>
    <FlashMessage />
    <AuthenticatedLayout>
        <div class="space-y-4 w-11/12 mx-auto">
            <h1 class="my-3">管理者ページ</h1>
            <hr class="my-8" />
            <h2>申込者一覧</h2>
            <ul v-for="event in events.data" :key="event.id" class="space-y-4">
                <li>
                    <div class="bg-white p-8 space-y-4">
                        <p>イベント日：{{ event.event_date }}</p>
                        <p>申込人数：{{ event.applications.length }}名</p>
                        <div>
                            <span class="text-lg font-semibold">申込者：</span>
                            <ul
                                v-for="(
                                    application, index
                                ) in event.applications"
                                :key="application.id"
                                class="ml-4"
                            >
                                <li class="">
                                    {{ index + 1 }}.
                                    {{ application.user.name }}（{{
                                        application.is_paid == 1
                                            ? "支払済み"
                                            : "当日支払い"
                                    }}）
                                </li>
                            </ul>
                        </div>
                        <div>
                            <span class="text-lg font-semibold"
                                >イベント内容：</span
                            ><br />
                            <p class="ml-4 whitespace-pre-wrap">
                                {{ event.content }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
            <Pagination :links="links" />
        </div>
    </AuthenticatedLayout>
</template>
