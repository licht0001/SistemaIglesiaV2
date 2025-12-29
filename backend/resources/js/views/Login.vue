<template>
    <div class="min-h-screen flex items-center justify-center bg-slate-100">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">
            <div class="flex items-center gap-3 justify-center">
                <div class="h-10 w-10 rounded-full bg-emerald-600 flex items-center justify-center text-xs font-bold text-white">
                    SI
                </div>
                <div class="text-center">
                    <p class="text-sm font-semibold text-slate-900">Sistema Iglesia</p>
                    <p class="text-xs text-slate-500">Acceso al panel administrativo</p>
                </div>
            </div>

            <form class="space-y-4" @submit.prevent="handleLogin">
                <div v-if="errorMessage" class="p-3 bg-red-50 border border-red-200 rounded-lg text-xs text-red-700">
                    {{ errorMessage }}
                </div>

                <div class="space-y-1 text-xs">
                    <label class="block text-slate-600">Correo electrónico</label>
                    <InputText 
                        v-model="form.email" 
                        type="email" 
                        class="w-full text-sm" 
                        placeholder="correo@iglesia.com"
                        :disabled="loading"
                    />
                </div>
                <div class="space-y-1 text-xs">
                    <label class="block text-slate-600">Contraseña</label>
                    <Password 
                        v-model="form.password" 
                        :feedback="false" 
                        toggleMask 
                        class="w-full" 
                        inputClass="w-full text-sm"
                        :disabled="loading"
                    />
                </div>
                <div class="flex items-center justify-between text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.remember" binary inputId="remember" :disabled="loading" />
                        <label for="remember">Recuérdame</label>
                    </div>
                    <button type="button" class="text-emerald-700 hover:underline">
                        Olvidé mi contraseña
                    </button>
                </div>
                <Button 
                    type="submit"
                    label="Iniciar sesión" 
                    icon="pi pi-sign-in" 
                    class="w-full !text-sm" 
                    :loading="loading"
                    :disabled="loading"
                    @click="handleLogin"
                />
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import { useAuth } from '../services/auth';

const router = useRouter();
const { login } = useAuth();

const form = reactive({
    email: '',
    password: '',
    remember: true,
});

const loading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
    // Validación básica
    if (!form.email || !form.password) {
        errorMessage.value = 'Por favor completa todos los campos';
        return;
    }

    loading.value = true;
    errorMessage.value = '';

    try {
        const result = await login(form.email, form.password, form.remember);

        if (result.success) {
            router.push('/dashboard');
        } else {
            errorMessage.value = result.message || 'Error al iniciar sesión';
        }
    } catch (error) {
        console.error('Error en handleLogin:', error);
        errorMessage.value = 'Ocurrió un error inesperado. Por favor intenta nuevamente.';
    } finally {
        loading.value = false;
    }
};
</script>
