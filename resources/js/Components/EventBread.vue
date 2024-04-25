<script setup lang="js">
import {
Breadcrumb,
BreadcrumbItem,
BreadcrumbList,
BreadcrumbSeparator
} from "@/Components/ui/breadcrumb";
import { useAdminOrMaster } from "@/Hooks/useAdminOrMaster";
import { Link, usePage } from "@inertiajs/vue3";

const { auth } = usePage().props;
const { isAdminOrMaster } = useAdminOrMaster(auth.user.role);
</script>

<template>
    <Breadcrumb class="mt-8 max-w-7xl mx-auto">
        <BreadcrumbList>
            <BreadcrumbItem>
                <Link href="/event"> イベント一覧 </Link>
            </BreadcrumbItem>
            <BreadcrumbSeparator> </BreadcrumbSeparator>
            <BreadcrumbItem v-if="isAdminOrMaster">
                <Link href="/event/create"> イベント作成 </Link>
            </BreadcrumbItem>
        </BreadcrumbList>
    </Breadcrumb>
</template>
