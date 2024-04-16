<script setup>
import { Button } from "@/Components/ui/button";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import EventBread from "../../Components/EventBread.vue";
// import FlashMessage from "../../Components/FlashMessage.vue";
// import ValidationErrors from "../../Components/ValidationErrors.vue";

// defineProps({
//     errors: Object,
// });

const event = reactive({
    title: null,
    content: null,
    event_date: null,
});

const storeEvent = () => {
    router.post("/event", event);
};
</script>

<template>
    <AuthenticatedLayout>
        <EventBread />
        <div class="flex flex-col items-center w-full">
            <h2>イベント作成</h2>
            <!-- <ValidationErrors :errors="errors" /> -->
            <form @submit.prevent="storeEvent" class="space-y-8">
                <!-- <FlashMessage /> -->
                <div class="form-group">
                    <label for="title">タイトル</label><br />
                    <input
                        class="min-w-[400px]"
                        name="title"
                        type="text"
                        v-model="event.title"
                        id="title"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="event_date">イベント日</label><br />
                    <input
                        class="min-w-[400px]"
                        name="event_date"
                        type="date"
                        v-model="event.event_date"
                        id="event_date"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="content">イベント内容</label><br />
                    <textarea
                        class="min-w-[400px] min-h-[200px]"
                        name="content"
                        v-model="event.content"
                        id="content"
                        required
                    >
                    </textarea>
                </div>
                <Button type="submit">イベント登録</Button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
