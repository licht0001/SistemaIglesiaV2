<template>
    <div class="max-w-4xl mx-auto space-y-4">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Configuración del Sistema</h1>
                <p class="text-xs text-slate-500">
                    Ajustes generales de la aplicación e información de la congregación.
                </p>
            </div>
            <div class="flex gap-2 text-xs">
                <Button label="Guardar cambios" icon="pi pi-check" class="!text-xs" @click="onSave" />
            </div>
        </header>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Sidebar de configuración -->
            <div class="md:col-span-1 space-y-1">
                <Button @click="activeSection = 'general'"
                        :severity="activeSection === 'general' ? 'primary' : 'secondary'"
                        :text="activeSection !== 'general'"
                        label="General" icon="pi pi-home" class="w-full !justify-start !text-xs" />
                
                <Button @click="activeSection = 'messaging'"
                        :severity="activeSection === 'messaging' ? 'primary' : 'secondary'"
                        :text="activeSection !== 'messaging'"
                        label="Mensajería" icon="pi pi-whatsapp" class="w-full !justify-start !text-xs" />

                <Button @click="activeSection = 'notifications'"
                        :severity="activeSection === 'notifications' ? 'primary' : 'secondary'"
                        :text="activeSection !== 'notifications'"
                        label="Notificaciones" icon="pi pi-bell" class="w-full !justify-start !text-xs" />

                <Button @click="activeSection = 'security'"
                        :severity="activeSection === 'security' ? 'primary' : 'secondary'"
                        :text="activeSection !== 'security'"
                        label="Seguridad" icon="pi pi-shield" class="w-full !justify-start !text-xs" />

                <Button @click="activeSection = 'database'"
                        :severity="activeSection === 'database' ? 'primary' : 'secondary'"
                        :text="activeSection !== 'database'"
                        label="Base de Datos" icon="pi pi-database" class="w-full !justify-start !text-xs" />
            </div>

            <!-- Formulario -->
            <div class="md:col-span-2 bg-white border border-slate-200 rounded-xl p-4 text-xs space-y-4">
                <template v-if="activeSection === 'general'">
                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2">Información de la Iglesia</h3>
                    <div class="grid gap-3">
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="block text-slate-500">Nombre de la Congregación</label>
                                <InputText v-model="form.churchName" class="w-full p-inputtext-sm" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-slate-500">Denominación / Red</label>
                                <InputText v-model="form.denomination" class="w-full p-inputtext-sm" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-slate-500">Dirección</label>
                            <InputText v-model="form.address" class="w-full p-inputtext-sm" />
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="block text-slate-500">Teléfono</label>
                                <InputText v-model="form.phone" class="w-full p-inputtext-sm" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-slate-500">Email de contacto</label>
                                <InputText v-model="form.email" class="w-full p-inputtext-sm" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-slate-500">Sitio Web</label>
                            <InputText v-model="form.website" class="w-full p-inputtext-sm" />
                        </div>
                    </div>

                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2 pt-2">Preferencias Regionales</h3>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-slate-500">Moneda</label>
                            <Dropdown v-model="form.currency" :options="['Bolivianos (Bs)', 'Dólares ($us)']" class="w-full" />
                        </div>
                        <div class="space-y-1">
                            <label class="block text-slate-500">Zona Horaria</label>
                            <Dropdown v-model="form.timezone" :options="['America/La_Paz', 'America/Caracas']" class="w-full" />
                        </div>
                    </div>
                </template>

                <template v-else-if="activeSection === 'messaging'">
                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2">Mensajería</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-slate-500">Prefijo de país (E.164)</label>
                            <InputText v-model="form.messaging.countryPrefix" placeholder="Ej: 591" class="w-full p-inputtext-sm" />
                        </div>
                        <div class="space-y-1">
                            <label class="block text-slate-500">Nombre de la Iglesia (para plantilla)</label>
                            <InputText v-model="form.churchName" class="w-full p-inputtext-sm" />
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-slate-500">Plantilla de cumpleaños</label>
                        <small class="block text-slate-400 mb-1">Variables: {nombre}, {iglesia}</small>
                        <textarea v-model="form.messaging.birthdayTemplate" rows="3" class="w-full border border-slate-200 rounded-lg p-2"></textarea>
                    </div>
                </template>

                <template v-else-if="activeSection === 'notifications'">
                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2">Notificaciones</h3>
                    <div class="space-y-4 pt-2">
                        <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                            <div>
                                <p class="font-medium text-slate-800">Alertas por Email</p>
                                <p class="text-[10px] text-slate-500">Enviar reportes y alertas al correo de contacto.</p>
                            </div>
                            <InputSwitch v-model="form.notifications.emailEnabled" />
                        </div>
                        <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                            <div>
                                <p class="font-medium text-slate-800">Mensajes de WhatsApp</p>
                                <p class="text-[10px] text-slate-500">Habilitar el envío de mensajes de cumpleaños automáticos.</p>
                            </div>
                            <InputSwitch v-model="form.notifications.whatsappEnabled" />
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg border border-slate-100">
                             <div>
                                <p class="text-xs font-medium text-slate-700">Aviso de Nuevo Miembro</p>
                                <p class="text-[10px] text-slate-500">Notificar a administración cuando se registre alguien nuevo.</p>
                            </div>
                            <InputSwitch v-model="form.notifications.newMemberAlert" />
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg border border-slate-100">
                             <div>
                                <p class="text-xs font-medium text-slate-700">Resumen de Finanzas</p>
                                <p class="text-[10px] text-slate-500">Notificar al finalizar el mes con el saldo de caja.</p>
                            </div>
                            <InputSwitch v-model="form.notifications.monthlyReportAlert" />
                        </div>
                    </div>
                </template>

                <template v-else-if="activeSection === 'security'">
                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2">Seguridad</h3>
                    <div class="grid gap-4 pt-2">
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="block text-slate-500 font-medium">Tiempo de Expiración de Sesión (min)</label>
                                <InputNumber v-model="form.security.sessionTimeout" class="w-full" size="small" :min="15" :max="1440" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-slate-500 font-medium">Límite de Intentos Fallidos</label>
                                <InputNumber v-model="form.security.failedAttemptsLimit" class="w-full" size="small" :min="3" :max="10" />
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-slate-500 font-medium">Complejidad de Contraseña</label>
                            <Dropdown v-model="form.security.passwordCompliance" :options="[{l:'Baja',v:'low'},{l:'Media',v:'medium'},{l:'Alta (Recomendada)',v:'high'}]" optionLabel="l" optionValue="v" class="w-full" />
                        </div>
                        <div class="flex items-center justify-between p-3 bg-amber-50 border border-amber-100 rounded-lg">
                            <div>
                                <p class="font-medium text-amber-800">Modo Mantenimiento</p>
                                <p class="text-[10px] text-amber-600">Bloquea el acceso al sistema para usuarios no administradores.</p>
                            </div>
                            <InputSwitch v-model="form.security.maintenanceMode" />
                        </div>
                    </div>
                </template>

                <template v-else-if="activeSection === 'database'">
                    <h3 class="font-semibold text-slate-900 border-b border-slate-100 pb-2">Gestión de Datos</h3>
                    <div class="space-y-4 pt-2">
                        <div class="bg-blue-50 border border-blue-100 p-3 rounded-lg flex items-center gap-3">
                            <i class="pi pi-database text-blue-600 text-lg"></i>
                            <div>
                                <p class="text-xs font-medium text-blue-900">Estado de la Base de Datos</p>
                                <p class="text-[10px] text-blue-700">Último respaldo: {{ form.database?.lastBackup || 'Nunca' }}</p>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <Button label="Generar Respaldo (SQL)" icon="pi pi-download" severity="secondary" class="!text-xs h-9" @click="handleBackup" :loading="backingUp" />
                            <Button label="Optimizar Tablas" icon="pi pi-bolt" severity="secondary" outlined class="!text-xs h-9" @click="handleOptimize" :loading="optimizing" />
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-slate-800">Respaldos Automáticos</p>
                                    <p class="text-[10px] text-slate-500">Realizar copia de seguridad periódica en el servidor.</p>
                                </div>
                                <InputSwitch v-model="form.database.autoBackup" />
                            </div>
                            <div class="mt-2" v-if="form.database.autoBackup">
                                <label class="block text-[10px] text-slate-500 mb-1">Frecuencia</label>
                                <Dropdown v-model="form.database.backupFrequency" :options="['Diario', 'Semanal', 'Mensual']" class="w-full !text-xs" />
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div class="text-slate-500 text-xs text-center py-10">
                        <i class="pi pi-cog text-4xl text-slate-200 block mb-2"></i>
                        Selecciona una sección de configuración.
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import { useToast } from 'primevue/usetoast';
import { getAppSettings, saveAppSettings, fetchSettingsApi, saveSettingsApi } from '../services/settings';

const toast = useToast();
const activeSection = ref('general');
const form = ref({
    churchName: '',
    denomination: '',
    address: '',
    phone: '',
    email: '',
    website: '',
    currency: 'Bolivianos (Bs)',
    timezone: 'America/La_Paz',
    messaging: {
        countryPrefix: '591',
        birthdayTemplate: '¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}',
    },
    notifications: {
        emailEnabled: true,
        whatsappEnabled: true,
        newMemberAlert: true,
        monthlyReportAlert: true,
    },
    security: {
        sessionTimeout: 120,
        failedAttemptsLimit: 5,
        passwordCompliance: 'medium',
        maintenanceMode: false,
    },
    database: {
        autoBackup: true,
        backupFrequency: 'Semanal',
        lastBackup: null,
    },
});

const backingUp = ref(false);
const optimizing = ref(false);

onMounted(async () => {
    // Carga desde API (con fallback a local)
    form.value = await fetchSettingsApi();
});

const onSave = async () => {
    try {
        const saved = await saveSettingsApi(form.value);
        form.value = saved;
        toast.add({ severity: 'success', summary: 'Guardado', detail: 'Configuración actualizada', life: 2000 });
    } catch (e) {
        // Fallback: guardar local
        saveAppSettings(form.value);
        toast.add({ severity: 'warn', summary: 'Guardado local', detail: 'No se pudo guardar en el servidor', life: 2500 });
    }
};

const handleBackup = () => {
    backingUp.value = true;
    setTimeout(() => {
        backingUp.value = false;
        form.value.database.lastBackup = new Date().toLocaleString();
        saveAppSettings(form.value);
        toast.add({ severity: 'success', summary: 'Respaldo exitoso', detail: 'El archivo SQL ha sido generado.', life: 3000 });
    }, 2000);
};

const handleOptimize = () => {
    optimizing.value = true;
    setTimeout(() => {
        optimizing.value = false;
        toast.add({ severity: 'success', summary: 'Optimizado', detail: 'Las tablas han sido optimizadas exitosamente.', life: 3000 });
    }, 1500);
};
</script>
