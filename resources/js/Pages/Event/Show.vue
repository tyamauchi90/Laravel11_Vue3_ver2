<script setup>
import ApplyEvent from "@/Components/ApplyEvent.vue";
import ApplyForm from "@/Components/ApplyForm.vue";
import EventBread from "@/Components/EventBread.vue";
import { Button } from "@/Components/ui/button";
import { useAdminOrMaster } from "@/Hooks/useAdminOrMaster.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed, reactive, ref } from "vue";

const { event, applications } = defineProps({
    event: Object,
    applications: Object,
});

const { auth } = usePage().props;
const { isAdminOrMaster } = useAdminOrMaster(auth.user.role);

const isFormVisible = ref(false);
const form = reactive({
    name: auth.user.name,
    email: auth.user.email,
    is_paid: "default",
});

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

const toggleReservationForm = () => {
    isFormVisible.value = !isFormVisible.value;
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
            <h1 class="my-3">イベント詳細</h1>
            <div class="space-y-4">
                <div>件名：{{ event.title }}</div>
                <div>イベント日：{{ event.event_date }}</div>
                <div>イベント内容：{{ event.content }}</div>
                <div>申込人数：{{ applications.length }}名</div>
            </div>
            <div class="space-x-4">
                <Button
                    v-if="!isUserApplied"
                    @click="toggleReservationForm()"
                    class="text-white bg-green-500 border-0 py-2 px-4 focus:outline-none hover:bg-green-600 rounded"
                >
                    申込む
                </Button>
                <Button
                    v-else
                    @click="cancelEvent(currentUserApplicationId)"
                    class="text-white bg-yellow-500 border-0 py-2 px-4 focus:outline-none hover:bg-yellow-600 rounded"
                >
                    キャンセル
                </Button>
                <Link
                    v-if="isAdminOrMaster"
                    as="button"
                    :href="route('event.edit', { event: event.id })"
                    class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded"
                >
                    編集する
                </Link>
                <Button
                    v-if="isAdminOrMaster"
                    @click="deleteEvent(event.id)"
                    class="text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded"
                >
                    削除する
                </Button>
            </div>
            <div v-if="!isUserApplied & isFormVisible">
                <div
                    class="bg-slate-800 bg-opacity-80 z-10 w-screen h-screen fixed inset-0 p-8"
                >
                    <div
                        class="bg-slate-100 z-50 absolute inset-4 max-w-[800px] mx-auto p-8 overflow-y-scroll"
                    >
                        <h1 class="text-lg font-semibold mb-4">
                            申込みフォーム
                        </h1>
                        <h2 class="text-lg font-semibold mb-4">
                            イベント日：{{ event.event_date }}
                        </h2>

                        <div class="form-group mb-4">
                            <label for="is_paid">申込み方法</label><br />
                            <select
                                v-model="form.is_paid"
                                required
                                class="h-11 p-2"
                            >
                                <option value="default" selected disabled>
                                    選択する
                                </option>
                                <option value="1">事前決済</option>
                                <option value="0">当日支払い</option>
                            </select>
                            <div
                                class="text-red-300"
                                v-if="form.is_paid === 'default'"
                            >
                                ※申込み方法を選択してください
                            </div>
                        </div>

                        <div class="transition duration-1000 ease-in-out">
                            <div v-if="form.is_paid === '1'">
                                <ApplyForm :auth="auth" :event="event" />
                            </div>
                            <div v-if="form.is_paid === '0'">
                                <ApplyEvent :auth="auth" :event="event" />
                            </div>
                            <Button
                                class="my-4"
                                @click="toggleReservationForm()"
                            >
                                戻る
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
