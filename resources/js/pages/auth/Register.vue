<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthBase :logo="null">
        <Head title="Registrarse" />

        <div class="flex flex-col items-center mb-8">
            <img
                src="https://syscfw.conserflow.com.mx/img/conserflow.png"
                alt="ConserFlow.ERP"
                class="w-full h-28 mb-4"
            />
            <h1 class="text-3xl font-bold text-[#1E40AF] dark:text-[#60A5FA]">ConserFlow.ERP</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-1 text-center">
                Ingresa tus datos para crear tu cuenta
            </p>
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6 bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg w-full max-w-md mx-auto"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-gray-700 dark:text-gray-200">Nombre completo</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Nombre completo"
                        class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-gray-700 dark:text-gray-200">Correo electrónico</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="correo@ejemplo.com"
                        class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-gray-700 dark:text-gray-200">Contraseña</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Contraseña"
                        class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-gray-700 dark:text-gray-200">Confirmar contraseña</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirmar contraseña"
                        class="border-gray-300 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                    tabindex="5"
                    :disabled="processing"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin mr-2 inline-block"
                    />
                    Registrarse
                </Button>
            </div>

            <div class="text-center text-sm text-gray-500 dark:text-gray-400 mt-4">
                ¿Ya tienes cuenta?
                <TextLink :href="login()" class="text-blue-600 hover:underline dark:text-blue-400" :tabindex="6">
                    Iniciar sesión
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
