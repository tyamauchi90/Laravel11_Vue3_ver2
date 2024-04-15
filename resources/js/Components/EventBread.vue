<script setup lang="js">
import {
Breadcrumb,
BreadcrumbItem,
BreadcrumbList,
BreadcrumbSeparator
} from "@/Components/ui/breadcrumb";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Breadcrumb class="mt-8">
        <BreadcrumbList>
            <BreadcrumbItem>
                <Link href="/event"> イベント一覧 </Link>
            </BreadcrumbItem>
            <BreadcrumbSeparator> </BreadcrumbSeparator>
            <BreadcrumbItem>
                <Link href="/event/create"> イベント作成 </Link>
            </BreadcrumbItem>
        </BreadcrumbList>
    </Breadcrumb>
</template>
