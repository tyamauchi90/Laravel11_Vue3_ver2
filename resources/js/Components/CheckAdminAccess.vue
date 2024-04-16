<script setup>
import axios from "axios";
import { onMounted } from "vue";

onMounted(async () => {
    try {
        const response = await axios.get("/admin/*");
        // return response;
    } catch (error) {
        if (error.response && error.response.status === 403) {
            alert(error.response.data.message);
        }
    }
});
</script>

<template>
    <div>
        <p>エラーメッセージ</p>
        <!-- {{ response }} -->
    </div>
</template>
