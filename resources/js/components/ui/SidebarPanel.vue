<template>
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:block w-80">
            <div class="bg-white rounded-lg flex flex-col shadow-sm p-6 sticky top-24">
                <nav>
                    <ul>
                        <li>
                            <a @click="handleClick(0, $event)" :class="{
                                'hover:bg-primary/50': true,
                                'bg-primary/50': step === 0,
                                'p-2 rounded-md block cursor-pointer text-lg': true // Apply text-lg here directly
                            }">
                                Ver mis compras
                            </a>
                        </li>
                        <li>
                            <a @click="handleClick(1, $event)" :class="{
                                'hover:bg-primary/50': true,
                                'bg-primary/50': step === 1,
                                'p-2 rounded-md block cursor-pointer text-lg': true // Apply text-lg here directly
                            }">
                                Reportar un problema
                            </a>
                        </li>
                        <li>
                            <a @click="handleClick(2, $event)" :class="{
                                'hover:bg-primary/50': true,
                                'bg-primary/50': step === 2,
                                'p-2 rounded-md block cursor-pointer text-lg': true // Apply text-lg here directly
                            }">
                                Ver problemas
                            </a>
                        </li>
                        <li>
                            <a @click="handleClick(3, $event)" :class="{
                                'hover:bg-primary/50': true,
                                'bg-primary/50': step === 3,
                                'p-2 rounded-md block cursor-pointer text-lg': true // Apply text-lg here directly
                            }">
                                Devoluciones
                            </a>
                        </li>
                        <li>
                            <a @click="handleClick(4, $event)" :class="{
                                'hover:bg-primary/50': true,
                                'bg-primary/50': step === 4,
                                'p-2 rounded-md block cursor-pointer text-lg': true // Apply text-lg here directly
                            }">
                                Compras
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineModel } from "vue";

const step = defineModel(0);
const handleClick = (val, $event) => {
    event.target.classList.toggle("bg-primary/50")
    step.value = val;
}
</script>
