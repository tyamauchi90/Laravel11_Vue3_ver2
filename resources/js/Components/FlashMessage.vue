<script setup lang="js">
defineProps({
    flash: {
      status: String,
      message: String,
      erroe: String,
    }
  });
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'">
        <div class="bg-blue-300 text-white p-4">
            <p>{{ $page.props.flash.message }}</p>
        </div>
    </div>
    <div v-else-if="$page.props.flash.status === 'danger'">
        <div class="bg-red-300 text-white p-4">
            <p>{{ $page.props.flash.message }}</p>
        </div>
    </div>
    <div v-else-if="$page.props.flash.status === 'error'">
        <div class="bg-red-300 text-white p-4">
            <p>{{ $page.props.flash.message }}</p>
        </div>
    </div>
</template>
