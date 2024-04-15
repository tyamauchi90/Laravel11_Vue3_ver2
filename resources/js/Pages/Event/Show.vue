<script setup>
import { Button } from "@/Components/ui/button";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import EventBread from "../../Components/EventBread.vue";

const { event, applications } = defineProps({
    event: Object,
    applications: Object,
});

const { auth } = usePage().props;

// 申込み状態のチェック
const isUserApplied = applications.some(
    (application) => application.user.id === auth.user.id
);

// 申込情報を特定
const currentUserApplicationId = computed(() => {
    return applications.find(
        (application) => application.user.id === auth.user.id
    )?.id;
});

const applyEvent = () => {
    router.post(`/application/`, {
        event_id: event.id,
        apply_date: new Date().toISOString().split("T")[0],
        is_paid: 0,
    });
};

const cancelEvent = (currentUserApplicationId) => {
    router.delete(`/application/${currentUserApplicationId}`, {
        onBefore: () => confirm("本当にキャンセルしますか？"),
    });
};

const deleteEvent = (id) => {
    router.delete(`/event/${id}`, {
        onBefore: () => confirm("本当に削除しますか？"),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <EventBread />
        <div
            class="space-y-4 flex flex-col justify-center w-full max-w-[400px] mx-auto"
        >
            <h1 class="my-3">Event詳細</h1>
            <div class="space-y-4">
                <div>件名：{{ event.title }}</div>
                <div>イベント日：{{ event.event_date }}</div>
                <div>イベント内容：{{ event.content }}</div>
                <div>
                    申込み者：{{ applications.length }}名
                    <ul>
                        <li
                            v-for="application in applications"
                            :key="application.id"
                        >
                            ・{{ application.user.name }}　（申込日：{{
                                application.apply_date
                            }}）
                        </li>
                    </ul>
                </div>
            </div>
            <div class="space-x-4">
                <Button
                    v-if="!isUserApplied"
                    @click="applyEvent()"
                    class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded"
                >
                    申込む
                </Button>
                <Button
                    v-else
                    @click="cancelEvent(currentUserApplicationId)"
                    class="text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded"
                >
                    キャンセル
                </Button>
                <Link
                    as="button"
                    :href="route('event.edit', { event: event.id })"
                    class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded"
                >
                    編集する
                </Link>
                <Button
                    @click="deleteEvent(event.id)"
                    class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded"
                >
                    削除する
                </Button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
