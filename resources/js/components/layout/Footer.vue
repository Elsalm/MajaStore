<template>
    <footer class="bg-primary text-white text-left">
        <div class="container py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">MajaStore</h3>
                    <p class="text-sm text-neutral-200 mb-4">
                        Muebles de calidad para cada casa, construidos con cuidado y diseñados para el confort.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-white hover:text-primary-lighter">
                            <FacebookIcon class="size-5" />
                        </a>
                        <a href="#" class="text-white hover:text-primary-lighter">
                            <InstagramIcon class="size-5" />
                        </a>
                        <a href="#" class="text-white hover:text-primary-lighter">
                            <TwitterIcon class="size-5" />
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li v-for="item in data['Quick-Links']" :key="item">
                            <a :href="'#' + item" class="text-sm text-neutral-200 hover:text-white transition">
                                {{ item }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Atención al Cliente</h3>
                    <ul class="space-y-2">
                        <li v-for="item in data['Customer-Service']" :key="item">
                            <a :href="'#' + item" class="text-sm text-neutral-200 hover:text-white transition">
                                {{ item }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contáctanos</h3>
                    <ul class="space-y-3 text-sm text-neutral-200">
                        <li class="flex items-start">
                            <MapPinIcon class="size-5 mr-2 mt-1" />
                            <span>123 Calle Diseño, Ciudad Muebles, 12345</span>
                        </li>
                        <li class="flex items-center">
                            <PhoneIcon class="size-5 mr-2" />
                            <span>+52 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <MailIcon class="size-5 mr-2" />
                            <span>contacto@majastore.com</span>
                        </li>
                        <li class="flex items-center">
                            <ClockIcon class="size-5 mr-2" />
                            <span>Lun-Vie: 9am-6pm, Sáb: 10am-2pm</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-primary-light mt-8 pt-6 text-center text-sm text-neutral-300">
                <p>&copy; {{ new Date().getFullYear() }} MajaStore. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { FacebookIcon, InstagramIcon, TwitterIcon, MapPinIcon, PhoneIcon, MailIcon, ClockIcon } from 'lucide-vue-next'

const data = {
    'Quick-Links': ['Sobre Nosotros', 'Nuestros Productos', 'Blog', 'Contáctanos'],
    'Customer-Service': ['FAQ', 'Envíos y Devoluciones', 'Garantía', 'Cuidado del Producto'],
}
</script>
