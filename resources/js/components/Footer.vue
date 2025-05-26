<template>
    <footer class="**:text-left text-neutral-50 bg-primary text-left p-2 ">
        <div class="pr-20 flex flex-col gap-4">
            <div class="*:my-4">
                <h4 class="text-base font-bold! text-neutral-50">
                    MajaStore
                </h4>
                <p class="text-sm!">Muebles de calidad para cadad casa, construidos con cuidado y diseñados para el
                    confort
                </p>
                <div class="*:fill-neutral-50 flex gap-1">
                    <a href="">
                        <twitterIcon class="size-4"></twitterIcon>
                    </a>
                    <a href="">
                        <instagramIcon class="size-4"></instagramIcon>
                    </a>
                    <a href="">
                        <facebookIcon class="size-4"></facebookIcon>
                    </a>
                </div>
            </div>

            <div v-for="(items, title) in data" :key="title" class="mb-4">
                <h4 class="text-base font-bold! mb-2">{{ title.replace(/-/g, ' ') }}</h4>
                <div class="flex flex-col gap-1">
                    <a v-for="item in items" :key="item" :href="'#' + item" class="text-sm!">
                        {{ item.replace(/-/g, ' ') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t-1 border-primary-light py-6">
            <p class="text-center!">&copy;MajaStore Todos los derechos reservados</p>
        </div>
    </footer>
</template>
<script setup>
import twitterIcon from "@svg/twitter.vue"
import instagramIcon from "@svg/instagram.vue"
import facebookIcon from "@svg/facebook.vue"
const data = { "Quick-Links": ["About Us", "Our Products", "Contact Us"], "Customer-Service": ["FAQ", "Shipping & Returns", "Warranty"], "Contact-Us": ["direccion", "ntelefono", "email"] }
</script>
