<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    { canRegister: true }
);
</script>

<template>
    <Head title="Welcome" />

    <div
        class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 p-6 text-gray-900 dark:text-gray-100"
    >
       
        <div class="mb-12 flex flex-col items-center">
            <img
                src="https://syscfw.conserflow.com.mx/img/conserflow.png"
                alt="ConserFlow.ERP"
                class="w-full h-28 mb-4"
            />
            <h1 class="text-4xl font-extrabold text-[#1E40AF] dark:text-[#60A5FA]">ConserFlow.ERP</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-lg text-center">
                Gestiona tu empresa de manera fácil y rápida
            </p>
        </div>

       
        <div class="flex flex-col sm:flex-row gap-6">
            <Link
                :href="login()"
                class="px-8 py-4 rounded-full bg-[#1E40AF] text-white font-semibold text-lg shadow-lg hover:bg-[#3749B0] transition transform hover:-translate-y-1"
            >
                Iniciar sesión
            </Link>
            <Link
                v-if="canRegister"
                :href="register()"
                class="px-8 py-4 rounded-full border-2 border-[#1E40AF] text-[#1E40AF] font-semibold text-lg hover:bg-[#1E40AF] hover:text-white transition transform hover:-translate-y-1"
            >
                Registro
            </Link>
        </div>
    </div>
</template>
