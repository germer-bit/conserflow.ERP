<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <AuthBase>
        <Head title="Iniciar sesión" />

        <div class="flex flex-col items-center mb-8">
            <img
                src="https://syscfw.conserflow.com.mx/img/conserflow.png"
                alt="ConserFlow.ERP"
                class="w-full h-28 mb-4"
            />
            <h1 class="text-3xl font-bold text-[#1E40AF] dark:text-[#60A5FA]">ConserFlow.ERP</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-1 text-center">
                Ingresa tu correo y contraseña para acceder
            </p>
        </div>

        
        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6 bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg w-full max-w-md mx-auto"
        >
            <!-- Email -->
            <div class="grid gap-2">
                <Label for="email" class="text-gray-700 dark:text-gray-200">Correo electrónico</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="correo@ejemplo.com"
                    class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password" class="text-gray-700 dark:text-gray-200">Contraseña</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                        :tabindex="5"
                    >
                        ¿Olvidaste tu contraseña?
                    </TextLink>
                </div>
                <Input
                    id="password"
                    type="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Contraseña"
                    class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                />
                <InputError :message="errors.password" />
            </div>

            <!-- Remember me -->
            <div class="flex items-center space-x-2">
                <Checkbox id="remember" name="remember" :tabindex="3" />
                <Label for="remember" class="text-gray-700 dark:text-gray-200">Recuérdame</Label>
            </div>

           
            <Button
                type="submit"
                class="mt-4 w-full bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                :tabindex="4"
                :disabled="processing"
            >
                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin mr-2 inline-block" />
                Iniciar sesión
            </Button>

          
            <div
                class="text-center text-sm text-gray-500 dark:text-gray-400 mt-4"
                v-if="canRegister"
            >
                ¿No tienes cuenta?
                <TextLink :href="register()" class="text-blue-600 hover:underline dark:text-blue-400" :tabindex="5">
                    Registrarse
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
