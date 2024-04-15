<script setup>
import { Button } from "@/Components/ui/button";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import EventBread from "../../Components/EventBread.vue";

const { eventData } = defineProps({
    eventData: Object,
});

const form = reactive({
    user_id: eventData.user_id,
    title: eventData.title,
    event_date: eventData.event_date,
    content: eventData.content,
});

const updateEvent = () => {
    router.visit(`/event/${eventData.id}`, {
        method: "put",
        data: form,
    });
};
</script>
<template>
    <AuthenticatedLayout>
        <EventBread />
        <div class="flex flex-col items-center w-full">
            <h2>イベント編集</h2>
            <form @submit.prevent="updateEvent" class="space-y-8">
                <div>
                    <span
                        >前回登録者：{{ eventData.user.name }}(No.{{
                            eventData.user.id
                        }})</span
                    >
                </div>
                <div class="form-group">
                    <label for="title">タイトル</label><br />
                    <input
                        class="min-w-[400px]"
                        type="text"
                        v-model="form.title"
                        id="title"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="event_date">イベント日</label><br />
                    <input
                        class="min-w-[400px]"
                        type="date"
                        v-model="form.event_date"
                        id="event_date"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="content">イベント内容</label><br />
                    <textarea
                        class="min-w-[400px] min-h-[200px]"
                        v-model="form.content"
                        id="content"
                        required
                    ></textarea>
                </div>
                <Button
                    class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                    type="submit"
                >
                    更新
                </Button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
