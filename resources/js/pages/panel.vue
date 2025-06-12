<template>
    <div class="container flex  gap-2 min-h-[70vh] mt-4">
        <SidebarPanel v-model="step" />
        <div class="w-3/4">
            <div v-if="step == 0">
                <verCompras></verCompras>
            </div>
            <div v-if="step == 1">
                <IssuesForm></IssuesForm>
            </div>
            <div v-if="step == 2">
                <SeeIssues></SeeIssues>
            </div>

            <div v-if="step == 3">
                <Returns></Returns>
            </div>

            <div v-if="step == 4">
                <SeeAllOrders></SeeAllOrders>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watch } from "vue"
import SidebarPanel from '@components/ui/SidebarPanel.vue'
import VerCompras from "@components/VerCompras.vue"
import IssuesForm from "@components/IssueForm.vue"
import SeeIssues from "@components/SeeIssues.vue"
import Returns from "@components/Returns.vue"
import SeeAllOrders from "@components/SeeAllOrders.vue"
const step = ref(0);
</script>
