<script setup>
import Button from "@/Components/ui/button/Button.vue";
// import { useMaster } from "@/Hooks/useMaster";
import { router, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

const { auth } = usePage().props;
// const { isMaster } = useMaster(auth);

const form = reactive({
    kana: auth.user.kana,
    role: auth.user.role,
    birthday: auth.user.birthday,
});

const editProfile = () => {
    router.visit(`/user/${auth.user.id}`, {
        method: "put",
        data: form,
    });
};
</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <form @submit.prevent="editProfile" class="space-y-4">
            <div>
                <label for="kana"
                    >カナ：
                    <input id="kana" v-model="form.kana" type="text" />
                </label>
            </div>
            <div>
                <!-- <div v-if="isMaster"> -->
                <label for="role"
                    >ステータス：
                    <select id="role" v-model="form.role">
                        <option value="member">メンバー</option>
                        <option value="admin">アドミン</option>
                        <option value="master">マスター</option>
                    </select>
                </label>
            </div>
            <div>
                <label for="birthday"
                    >誕生日：
                    <input id="birthday" v-model="form.birthday" type="date" />
                </label>
            </div>
            <Button> 更新 </Button>
        </form>
    </div>
</template>
