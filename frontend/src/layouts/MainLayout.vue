<template>
    <div class="min-h-screen bg-slate-100 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-100 hidden md:flex flex-col">
            <div class="h-16 px-4 flex items-center border-b border-slate-800">
                <div class="h-9 w-9 rounded-full bg-emerald-600 flex items-center justify-center text-xs font-bold">
                    SI
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold">Sistema Iglesia</p>
                    <p class="text-[11px] text-slate-400">Panel administrativo</p>
                </div>
            </div>
            <nav class="flex-1 px-2 py-4 text-sm">
                <p class="px-3 text-[11px] uppercase tracking-wide text-slate-500 mb-2">Principal</p>
                <ul class="space-y-1">
                    <li>
                        <router-link to="/dashboard" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-home text-xs"></i>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/members" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-id-card text-xs"></i>
                            <span>Miembros</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/finances" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-wallet text-xs"></i>
                            <span>Finanzas</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/activities" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-calendar text-xs"></i>
                            <span>Actividades</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/service-areas" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-users text-xs"></i>
                            <span>Áreas de servicio</span>
                        </router-link>
                    </li>

                </ul>

                <p class="px-3 text-[11px] uppercase tracking-wide text-slate-500 mt-5 mb-2">Configuración</p>
                <ul class="space-y-1">
                    <li>
                        <router-link to="/users" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-user text-xs"></i>
                            <span>Usuarios y permisos</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/settings" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-cog text-xs"></i>
                            <span>Configuración del sistema</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/landing-settings" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-globe text-xs"></i>
                            <span>Administrar Web</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/prayer-requests" active-class="bg-slate-800 text-emerald-200" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-800/80 text-xs text-slate-300">
                            <i class="pi pi-heart text-xs"></i>
                            <span>Peticiones de Oración</span>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <div class="px-3 py-3 border-t border-slate-800 text-[11px] flex items-center justify-center">
                <span class="text-slate-400">Versión 1.0.0</span>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-md border border-slate-200">
                        <i class="pi pi-bars text-sm text-slate-600"></i>
                    </button>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ currentRouteName }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <div class="hidden sm:flex items-center gap-2 px-2 py-1 rounded-full bg-emerald-50 border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-emerald-700">Sesión recordada</span>
                    </div>
                    <div class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-1 rounded-lg transition-colors relative" @click="toggleProfileMenu">
                        <div class="text-right mr-1">
                            <p class="text-xs font-medium text-slate-900">{{ user?.name || 'Usuario' }}</p>
                            <p class="text-[11px] text-slate-500">{{ user?.email || '' }}</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-semibold shadow-sm">
                            {{ getInitials(user?.name) }}
                        </div>
                        <Menu ref="profileMenu" :model="menuItems" :popup="true" />
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-4 sm:p-6 space-y-4 text-sm overflow-auto">
                <router-view></router-view>
            </main>
        </div>

        <!-- Modal Perfil -->
        <Dialog v-model:visible="profileModalVisible" header="Mi Perfil" modal class="w-full max-w-sm">
            <div class="space-y-4 pt-2">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Nombre completo</label>
                    <InputText v-model="profileForm.name" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Email / Usuario</label>
                    <InputText v-model="profileForm.email" class="w-full" size="small" />
                </div>
                <hr class="border-slate-100" />
                <p class="text-[10px] text-slate-500 uppercase font-bold">Cambiar contraseña (opcional)</p>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Nueva contraseña</label>
                    <Password v-model="profileForm.password" class="w-full" inputClass="w-full" toggleMask :feedback="false" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Confirmar nueva contraseña</label>
                    <Password v-model="profileForm.password_confirmation" class="w-full" inputClass="w-full" toggleMask :feedback="false" size="small" />
                </div>
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button label="Cancelar" icon="pi pi-times" @click="profileModalVisible = false" text severity="secondary" class="!text-xs" />
                    <Button label="Actualizar Perfil" icon="pi pi-check" @click="handleSaveProfile" :loading="savingProfile" class="!text-xs" />
                </div>
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { computed, ref, onMounted, reactive } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuth } from '../services/auth';
import Menu from 'primevue/menu';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { useToast } from 'primevue/usetoast';

const router = useRouter();
const route = useRoute();
const toast = useToast();
const { logout, getStoredUser, updateProfile } = useAuth();
const user = ref(null);
const profileMenu = ref(null);
const profileModalVisible = ref(false);
const savingProfile = ref(false);

const profileForm = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const menuItems = ref([
    {
        label: 'Mi Perfil',
        icon: 'pi pi-user',
        command: () => {
            openProfileModal();
        }
    },
    {
        separator: true
    },
    {
        label: 'Cerrar sesión',
        icon: 'pi pi-sign-out',
        class: 'text-rose-600',
        command: () => {
            handleLogout();
        }
    }
]);

onMounted(() => {
    user.value = getStoredUser();
});

const toggleProfileMenu = (event) => {
    profileMenu.value.toggle(event);
};

const openProfileModal = () => {
    profileForm.name = user.value.name;
    profileForm.email = user.value.email;
    profileForm.password = '';
    profileForm.password_confirmation = '';
    profileModalVisible.value = true;
};

const handleSaveProfile = async () => {
    if (!profileForm.name || !profileForm.email) {
        toast.add({ severity: 'warn', summary: 'Campos requeridos', detail: 'Nombre y email son obligatorios', life: 3000 });
        return;
    }

    if (profileForm.password && profileForm.password !== profileForm.password_confirmation) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Las contraseñas no coinciden', life: 3000 });
        return;
    }

    savingProfile.value = true;
    const result = await updateProfile(profileForm);
    if (result.success) {
        user.value = result.user;
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Perfil actualizado correctamente', life: 3000 });
        profileModalVisible.value = false;
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'No se pudo actualizar el perfil', life: 4000 });
    }
    savingProfile.value = false;
};

const handleLogout = async () => {
    await logout();
    router.push('/');
};

const currentRouteName = computed(() => {
    switch(route.name) {
        case 'dashboard': return 'Dashboard General';
        case 'members': return 'Gestión de Miembros';
        case 'finances': return 'Control Financiero';
        case 'activities': return 'Calendario de Actividades';
        case 'service-areas': return 'Áreas de Servicio';
        case 'users': return 'Usuarios y Permisos';
        case 'settings': return 'Configuración del Sistema';
        case 'landing-settings': return 'Administrar Página Web';
        case 'prayer-requests': return 'Peticiones de Oración';
        default: return 'Sistema Iglesia';
    }
});

const getInitials = (name) => {
    if (!name) return 'U';
    return name.charAt(0).toUpperCase();
};
</script>
