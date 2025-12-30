<template>
    <div class="space-y-4">
        <!-- Unified Stats Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            <!-- 1. Miembros Totales -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-emerald-500"
                 @click="openDetailModal('total_members')">
                <div class="p-2.5 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                     <i class="pi pi-users text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Miembros Totales</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.members?.total || 0 }}</p>
                </div>
            </div>

            <!-- 2. Bautizados -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-amber-400"
                 @click="openDetailModal('baptized')">
                <div class="p-2.5 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                     <i class="pi pi-star-fill text-amber-500 group-hover:rotate-12 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Bautizados</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.baptized?.total || 0 }}</p>
                </div>
            </div>

            <!-- 3. Servidores -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-blue-500"
                 @click="openDetailModal('servers')">
                <div class="p-2.5 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                     <i class="pi pi-briefcase text-blue-600"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Servidores</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.servers?.total || 0 }}</p>
                </div>
            </div>

            <!-- 4. Adultos Casados -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-red-500"
                 @click="openDetailModal('married')">
                <div class="p-2.5 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                     <i class="pi pi-heart-fill text-red-500"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Casados</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.adults_married || 0 }}</p>
                </div>
            </div>

            <!-- 5. Adultos Solteros -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-slate-400"
                 @click="openDetailModal('single')">
                <div class="p-2.5 bg-slate-50 rounded-lg group-hover:bg-slate-100 transition-colors">
                     <i class="pi pi-user text-slate-600 group-hover:-translate-y-1 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Solteros</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.adults_single || 0 }}</p>
                </div>
            </div>

            <!-- Nuevo: Adultos Viudos -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-gray-600"
                 @click="openDetailModal('widowed')">
                <div class="p-2.5 bg-gray-50 rounded-lg group-hover:bg-gray-100 transition-colors">
                     <i class="pi pi-minus-circle text-gray-600 group-hover:rotate-180 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Viudos</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.adults_widowed || 0 }}</p>
                </div>
            </div>

            <!-- Nuevo: Adultos Divorciados -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-orange-500"
                 @click="openDetailModal('divorced')">
                <div class="p-2.5 bg-orange-50 rounded-lg group-hover:bg-orange-100 transition-colors">
                     <i class="pi pi-sort-alt-slash text-orange-500 group-hover:scale-110 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Divorciados</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.adults_divorced || 0 }}</p>
                </div>
            </div>

            <!-- 6. Adolescentes -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-violet-500"
                 @click="openDetailModal('adolescents')">
                <div class="p-2.5 bg-violet-50 rounded-lg group-hover:bg-violet-100 transition-colors">
                     <i class="pi pi-bolt text-violet-600"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Adolescentes</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.adolescents || 0 }}</p>
                </div>
            </div>

            <!-- 7. Niños (Varones) -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-sky-400"
                 @click="openDetailModal('children_male')">
                <div class="p-2.5 bg-sky-50 rounded-lg group-hover:bg-sky-100 transition-colors">
                     <i class="pi pi-face-smile text-sky-600 group-hover:scale-125 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Niños</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.children_male || 0 }}</p>
                </div>
            </div>

            <!-- 8. Niñas (Mujeres) -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 group cursor-pointer border-l-4 border-l-pink-400"
                 @click="openDetailModal('children_female')">
                <div class="p-2.5 bg-pink-50 rounded-lg group-hover:bg-pink-100 transition-colors">
                     <i class="pi pi-face-smile text-pink-500 group-hover:scale-125 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Niñas</p>
                    <p class="text-lg font-bold text-slate-900">{{ stats?.breakdown?.children_female || 0 }}</p>
                </div>
            </div>

            <!-- 9. Eventos del mes -->
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-center gap-3 transition-all duration-300 group cursor-pointer md:col-span-1 lg:col-span-2 border-l-4 border-l-indigo-500 hover:shadow-md"
                 @click="openDetailModal('events')">
                <div class="p-2.5 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                     <i class="pi pi-calendar text-indigo-600 group-hover:rotate-12 transition-transform"></i>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 leading-tight">Eventos del mes</p>
                    <div class="flex items-center gap-3">
                        <p class="text-lg font-bold text-slate-900">{{ stats?.events?.this_month || 0 }}</p>
                        <p class="text-[10px] text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded-full" v-if="upcomingEvents.length > 0">
                            {{ upcomingEvents.length }} proximos
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-4">
            <!-- Cumpleaños del mes (Ahora a la izquierda) -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 text-xs">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-slate-900">Cumpleaños del mes</p>
                    <span class="text-[11px] text-slate-500">{{ birthdays.length }} miembros</span>
                </div>
                <ul class="space-y-2" v-if="birthdays.length > 0">
                    <li v-for="member in birthdays" :key="member.id"
                        class="flex items-center justify-between px-2 py-1.5 rounded-lg hover:bg-slate-50">
                        <div class="flex items-center gap-2">
                            <div class="h-7 w-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px] font-medium">
                                {{ getInitials(member.first_name, member.last_name) }}
                            </div>
                            <div>
                                <p class="text-[11px] font-medium text-slate-900">{{ member.first_name }} {{ member.last_name }}</p>
                                <p class="text-[10px] text-slate-500">{{ formatDate(member.birth_date) }}</p>
                                <div v-if="member.phone" class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] text-slate-600 flex items-center gap-1">
                                        <i class="pi pi-phone text-emerald-600 text-[10px]"></i>
                                        <span>{{ member.phone }}</span>
                                    </p>
                                    <button @click.stop="copyPhone(member.phone)" class="text-[10px] text-emerald-700 hover:underline">Copiar</button>
                                    <a :href="waLink(member.phone, member.first_name, member.last_name)" target="_blank" rel="noopener" class="text-[10px] text-emerald-700 hover:underline">WhatsApp</a>
                                    <a :href="smsLink(member.phone, member.first_name, member.last_name)" class="text-[10px] text-emerald-700 hover:underline">SMS</a>
                                </div>
                                <div v-else class="flex items-center gap-2 mt-0.5 text-[10px] text-slate-500">
                                    <p class="flex items-center gap-1" :title="noPhoneTooltip">
                                        <i class="pi pi-phone-slash text-slate-400 text-[10px]"></i>
                                        <span>Sin teléfono</span>
                                    </p>
                                    <button class="px-2 py-0.5 rounded bg-slate-100 text-slate-400 cursor-not-allowed" :title="noPhoneTooltip">WhatsApp</button>
                                    <button class="px-2 py-0.5 rounded bg-slate-100 text-slate-400 cursor-not-allowed" :title="noPhoneTooltip">SMS</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-[11px] text-slate-500 text-center py-2">No hay cumpleaños este mes</p>
                <button class="mt-3 w-full text-[11px] text-emerald-700 border border-emerald-200 rounded-lg py-1.5 hover:bg-emerald-50" @click="birthdayModalVisible = true">
                    Ver todos los cumpleaños
                </button>
            </div>

            <!-- Finanzas (Ahora a la derecha, ocupando 2 columnas) -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 gap-2">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-semibold text-slate-900 mb-0">Flujo de caja</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-3 text-xs mb-4">
                    <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-3">
                        <p class="text-slate-600 mb-1">Ingresos</p>
                        <p class="text-lg font-semibold text-emerald-700">{{ formatCurrency(totalIncome) }}</p>
                        <p class="text-[11px] text-emerald-700">Diezmos, ofrendas, donaciones</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                        <p class="text-slate-600 mb-1">Egresos</p>
                        <p class="text-lg font-semibold text-slate-900">{{ formatCurrency(totalExpense) }}</p>
                        <p class="text-[11px] text-slate-600">Alquiler, servicios, ayudas, misiones</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                        <p class="text-slate-600 mb-1">Saldo</p>
                        <p class="text-lg font-semibold text-emerald-700">{{ formatCurrency(balance) }}</p>
                        <p class="text-[11px] text-slate-600">Disponible en caja/fondos</p>
                    </div>
                </div>
                
                <!-- Gráfico de Líneas PrimeVue (Ingresos vs Egresos) -->
                <div class="mt-2 h-44">
                    <Chart type="line" :data="chartData" :options="chartOptions" class="h-full w-full" />
                </div>
            </div>
        </div>

        <!-- Actividades rápidas -->
        <div class="grid lg:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 text-xs">
                <p class="text-sm font-semibold text-slate-900 mb-2">Próximas actividades</p>
                <ul class="space-y-2" v-if="upcomingEvents.length > 0">
                    <li v-for="event in upcomingEvents" :key="event.id" class="flex items-start gap-2">
                        <div class="w-10 text-center">
                            <p class="text-[11px] font-semibold text-emerald-700">{{ formatDay(event.start_at) }}</p>
                            <p class="text-[10px] text-slate-500">{{ formatMonth(event.start_at) }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-[11px] font-medium text-slate-900">{{ event.name }}</p>
                            <p class="text-[10px] text-slate-500">{{ formatTime(event.start_at) }} • {{ event.location || 'Sin ubicación' }}</p>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-[11px] text-slate-500 text-center py-2">No hay eventos próximos</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 text-xs">
                <p class="text-sm font-semibold text-slate-900 mb-2">Áreas de servicio</p>
                <div class="space-y-2" v-if="stats?.service_areas?.length > 0">
                    <div v-for="area in stats.service_areas" :key="area.id" 
                         class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded flex items-center justify-center bg-blue-100 text-blue-600">
                                <i class="pi pi-briefcase text-[10px]"></i>
                            </div>
                            <span class="text-[11px] font-medium text-slate-800">{{ area.name }}</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                            {{ area.members_count }} miembros
                        </span>
                    </div>
                </div>
                <div v-else class="text-[11px] text-slate-500 text-center py-4">
                   No hay áreas de servicio activas registradas
                </div>
                <button class="mt-3 w-full text-[11px] text-blue-700 border border-blue-200 rounded-lg py-1.5 hover:bg-blue-50"
                        @click="navigateTo('service-areas')">
                    Ver todas las áreas de servicio
                </button>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 text-xs">
                <p class="text-sm font-semibold text-slate-900 mb-2">Acciones rápidas</p>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50"
                            @click="navigateTo('members', { action: 'create' })">
                        <span class="flex items-center gap-2">
                            <i class="pi pi-user-plus text-xs text-emerald-700"></i>
                            <span>Registrar nuevo miembro</span>
                        </span>
                        <i class="pi pi-arrow-right text-xs text-slate-400"></i>
                    </button>
                    <button class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50"
                            @click="navigateTo('finances', { action: 'create_income' })">
                        <span class="flex items-center gap-2">
                            <i class="pi pi-dollar text-xs text-emerald-700"></i>
                            <span>Registrar diezmo u ofrenda</span>
                        </span>
                        <i class="pi pi-arrow-right text-xs text-slate-400"></i>
                    </button>
                    <button class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50"
                            @click="navigateTo('activities', { action: 'create' })">
                        <span class="flex items-center gap-2">
                            <i class="pi pi-calendar-plus text-xs text-emerald-700"></i>
                            <span>Programar actividad</span>
                        </span>
                        <i class="pi pi-arrow-right text-xs text-slate-400"></i>
                    </button>
                    <button class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50"
                             @click="handleExportMembers" :disabled="exportingMembers">
                        <span class="flex items-center gap-2">
                            <i class="pi pi-file-excel text-xs text-emerald-700" v-if="!exportingMembers"></i>
                            <i class="pi pi-spin pi-spinner text-xs text-emerald-700" v-else></i>
                            <span>Generar reporte de miembros</span>
                        </span>
                        <i class="pi pi-arrow-right text-xs text-slate-400" v-if="!exportingMembers"></i>
                    </button>
                </div>
            </div>
        </div>
    <Dialog v-model:visible="birthdayModalVisible" header="Cumpleaños del Mes" modal class="w-full max-w-md">
        <ul class="space-y-2">
            <li v-for="member in birthdays" :key="member.id"
                class="flex items-center justify-between px-3 py-2 rounded-lg border border-slate-100 hover:bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-medium">
                        {{ getInitials(member.first_name, member.last_name) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">{{ member.first_name }} {{ member.last_name }}</p>
                        <p class="text-xs text-slate-500">Cumpleaños: {{ formatDate(member.birth_date) }}</p>
                        <div v-if="member.phone" class="flex items-center gap-2 mt-0.5">
                            <p class="text-xs text-slate-600 flex items-center gap-1">
                                <i class="pi pi-phone text-emerald-600 text-xs"></i>
                                <span>{{ member.phone }}</span>
                            </p>
                            <button @click.stop="copyPhone(member.phone)" class="text-[11px] text-emerald-700 hover:underline">Copiar</button>
                            <a :href="waLink(member.phone, member.first_name, member.last_name)" target="_blank" rel="noopener" class="text-[11px] text-emerald-700 hover:underline">WhatsApp</a>
                            <a :href="smsLink(member.phone, member.first_name, member.last_name)" class="text-[11px] text-emerald-700 hover:underline">SMS</a>
                        </div>
                        <div v-else class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-500">
                            <p class="flex items-center gap-1" :title="noPhoneTooltip">
                                <i class="pi pi-phone-slash text-slate-400 text-xs"></i>
                                <span>Sin teléfono</span>
                            </p>
                            <button class="px-2 py-0.5 rounded bg-slate-100 text-slate-400 cursor-not-allowed" :title="noPhoneTooltip">WhatsApp</button>
                            <button class="px-2 py-0.5 rounded bg-slate-100 text-slate-400 cursor-not-allowed" :title="noPhoneTooltip">SMS</button>
                        </div>
                    </div>
                </div>
                 <div class="text-emerald-600">
                    <i class="pi pi-gift"></i>
                </div>
            </li>
        </ul>
        <div v-if="birthdays.length === 0" class="text-center py-4 text-slate-500">
            No hay cumpleaños este mes.
        </div>
        <template #footer>
            <Button label="Cerrar" icon="pi pi-times" @click="birthdayModalVisible = false" text severity="secondary" />
        </template>
    </Dialog>

    <!-- Modal de Detalles de Registros -->
    <Dialog v-model:visible="detailModalVisible" :header="detailTitle" modal class="w-full max-w-4xl">
        <div v-if="detailLoading" class="flex flex-col items-center py-10 gap-3">
            <i class="pi pi-spin pi-spinner text-3xl text-emerald-600"></i>
            <p class="text-xs text-slate-500">Cargando detalles...</p>
        </div>
        <div v-else>
            <!-- Tabla para Miembros -->
            <DataTable v-if="detailType !== 'events'" :value="detailItems" size="small" scrollable scrollHeight="400px" class="text-xs">
                <Column field="first_name" header="Nombre"></Column>
                <Column field="last_name" header="Apellido"></Column>
                <Column v-if="detailType === 'total_members' || detailType === 'baptized' || detailType === 'servers'" field="category" header="Categoría">
                    <template #body="slotProps">
                        <span class="capitalize">{{ slotProps.data.category }}</span>
                    </template>
                </Column>
                <Column field="phone" header="Teléfono"></Column>
                <Column v-if="detailType === 'baptized'" field="baptism_date" header="Fecha Bautismo">
                    <template #body="slotProps">
                        {{ formatDate(slotProps.data.baptism_date) }}
                    </template>
                </Column>
                <Column header="Acción" alignFrozen="right" frozen>
                    <template #body="slotProps">
                        <Button icon="pi pi-eye" text rounded size="small" @click="navigateTo('members', { search: slotProps.data.first_name })" />
                    </template>
                </Column>
            </DataTable>

            <!-- Tabla para Eventos -->
            <DataTable v-else :value="detailItems" size="small" scrollable scrollHeight="400px" class="text-xs">
                <Column field="name" header="Evento"></Column>
                <Column field="start_at" header="Fecha">
                    <template #body="slotProps">
                        {{ formatDate(slotProps.data.start_at) }}
                    </template>
                </Column>
                <Column field="location" header="Ubicación"></Column>
                <Column field="status" header="Estado">
                    <template #body="slotProps">
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px]">{{ slotProps.data.status }}</span>
                    </template>
                </Column>
            </DataTable>
        </div>
        <template #footer>
            <span class="text-[10px] text-slate-400 mr-auto">Total: {{ detailItems.length }} registros</span>
            <Button label="Cerrar" icon="pi pi-times" @click="detailModalVisible = false" text severity="secondary" />
        </template>
    </Dialog>
    </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Chart from 'primevue/chart';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { useToast } from 'primevue/usetoast';
import { useDashboard } from '../services/dashboard';
import { useTransactions } from '../services/transactions';
import { useMembers } from '../services/members';
import { getAppSettings, fetchSettingsApi } from '../services/settings';

const router = useRouter();
const toast = useToast();
const { getStats } = useDashboard();
const { getTransactions } = useTransactions();
const { exportMembers } = useMembers();

const stats = ref(null);
const birthdays = ref([]);
const upcomingEvents = ref([]);
const transactions = ref([]);
const loading = ref(true);
const exportingMembers = ref(false);
const birthdayModalVisible = ref(false);
const appSettings = ref(getAppSettings());
const noPhoneTooltip = 'Agrega un teléfono para habilitar WhatsApp y SMS';

// Estado para el modal de detalle
const detailModalVisible = ref(false);
const detailLoading = ref(false);
const detailItems = ref([]);
const detailTitle = ref('');
const detailType = ref('');

onMounted(async () => {
    appSettings.value = await fetchSettingsApi();
    await loadDashboard();
});

const loadDashboard = async () => {
    loading.value = true;
    
    // Ejecutar ambas peticiones en paralelo
    const [statsResult, transactionsResult] = await Promise.all([
        getStats(),
        getTransactions({ limit: 500 }) // Aumentar límite para reporte anual
    ]);
    
    if (statsResult.success) {
        stats.value = statsResult.data;
        birthdays.value = statsResult.data.birthdays_this_month || [];
        upcomingEvents.value = statsResult.data.upcoming_events || [];
    }

    if (transactionsResult.success) {
        transactions.value = transactionsResult.data.data ? transactionsResult.data.data : transactionsResult.data;
    }
    
    loading.value = false;
};

// Totales Generales
const totalIncome = computed(() => {
    return transactions.value
        .filter(t => t.type === 'ingreso')
        .reduce((sum, t) => sum + Number(t.amount || 0), 0);
});

const totalExpense = computed(() => {
    return transactions.value
        .filter(t => t.type === 'egreso')
        .reduce((sum, t) => sum + Number(t.amount || 0), 0);
});

const balance = computed(() => totalIncome.value - totalExpense.value);

// Configuración de Chart.js (Reactiva a stats)
const chartData = computed(() => {
    if (!stats.value?.finances?.chart) return { labels: [], datasets: [] };

    const chartSource = stats.value.finances.chart;
    const monthsKeys = Object.keys(chartSource.ingreso).sort(); // YYYY-MM
    
    // Formatear etiquetas de meses (Jan, Feb, etc.)
    const labels = monthsKeys.map(key => {
        const [year, month] = key.split('-');
        return new Date(year, month - 1, 1).toLocaleDateString('es-ES', { month: 'short' });
    });

    return {
        labels,
        datasets: [
            {
                label: 'Ingresos',
                data: monthsKeys.map(key => chartSource.ingreso[key] || 0),
                fill: true,
                borderColor: '#10b981', // Emerald 500
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                pointRadius: 3
            },
            {
                label: 'Egresos',
                data: monthsKeys.map(key => chartSource.egreso[key] || 0),
                fill: true,
                borderColor: '#ef4444', // Red 500
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                pointRadius: 3
            },
            {
                label: 'Saldo',
                data: monthsKeys.map(key => chartSource.saldo[key] || 0),
                fill: false,
                borderColor: '#3b82f6', // Blue 500
                borderWidth: 3,
                borderDash: [5, 5],
                tension: 0.4,
                pointRadius: 4
            }
        ]
    };
});

const chartOptions = computed(() => {
    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    boxWidth: 6,
                    font: { size: 10 }
                }
            },
            tooltip: {
                titleFont: { size: 10 },
                bodyFont: { size: 10 },
                callbacks: {
                    label: (context) => {
                        let label = context.dataset.label || '';
                        if (label) label += ': ';
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(context.parsed.y);
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#94a3b8', // Slate 400
                    font: { size: 9 }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                ticks: {
                    color: '#94a3b8',
                    font: { size: 9 },
                    callback: (value) => {
                        return value >= 1000 ? (value / 1000) + 'k' : value;
                    }
                },
                grid: {
                    color: '#f1f5f9', // Slate 100
                    drawBorder: false
                }
            }
        }
    };
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(amount);
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
};

const formatDay = (date) => {
    if (!date) return '';
    return new Date(date).getDate().toString().padStart(2, '0');
};

const formatMonth = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('es-ES', { month: 'short' }).toUpperCase();
};

const formatTime = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
};

const getInitials = (firstName, lastName) => {
    const first = firstName ? firstName.charAt(0).toUpperCase() : '';
    const last = lastName ? lastName.charAt(0).toUpperCase() : '';
    return first + last;
};

const navigateTo = (routeName, query = {}) => {
    router.push({ name: routeName, query });
};

const showNotImplemented = () => {
    toast.add({ severity: 'info', summary: 'En desarrollo', detail: 'Esta funcionalidad estará disponible pronto.', life: 3000 });
};

const handleExportMembers = async () => {
    exportingMembers.value = true;
    try {
        const result = await exportMembers();
        
        if (result.success) {
            const blob = new Blob([result.data], { 
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
            });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `miembros_${new Date().toISOString().split('T')[0]}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            toast.add({ severity: 'success', summary: 'Éxito', detail: 'Reporte de miembros exportado correctamente', life: 3000 });
        } else {
            toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'Error al exportar', life: 3000 });
        }
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Error al exportar el archivo', life: 3000 });
    } finally {
        exportingMembers.value = false;
    }
};

const copyPhone = async (phone) => {
    if (!phone) return;
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(phone);
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = phone;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }
        toast.add({ severity: 'success', summary: 'Copiado', detail: 'Número copiado al portapapeles', life: 2000 });
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo copiar el número', life: 3000 });
    }
};

const birthdayTemplate = (firstName, lastName) => {
    const name = [firstName || '', lastName || ''].join(' ').trim();
    const tpl = appSettings.value?.messaging?.birthdayTemplate || '¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}';
    const church = appSettings.value?.churchName || 'Iglesia';
    return tpl.replace('{nombre}', name).replace('{iglesia}', church);
};
const normalizePhone = (phone) => {
    const digits = (phone || '').replace(/\D/g, '');
    const prefix = appSettings.value?.messaging?.countryPrefix || '591';
    if (digits.startsWith(prefix)) return digits;
    if (digits.length <= 8) return `${prefix}${digits}`;
    return digits;
};
const waLink = (phone, firstName, lastName) => {
    const num = normalizePhone(phone);
    const msg = encodeURIComponent(birthdayTemplate(firstName, lastName));
    return `https://wa.me/${num}?text=${msg}`;
};
const smsLink = (phone, firstName, lastName) => {
    const num = normalizePhone(phone);
    const msg = encodeURIComponent(birthdayTemplate(firstName, lastName));
    return `sms:+${num}?&body=${msg}`;
};

// Función para abrir el modal de detalle según la tarjeta
const openDetailModal = async (type) => {
    detailType.value = type;
    detailModalVisible.value = true;
    detailLoading.value = true;
    detailItems.value = [];

    let filters = {};
    
    switch (type) {
        case 'total_members':
            detailTitle.value = 'Detalle: Miembros Totales';
            break;
        case 'baptized':
            detailTitle.value = 'Detalle: Miembros Bautizados';
            filters = { baptized: 1 };
            break;
        case 'servers':
            detailTitle.value = 'Detalle: Servidores';
            filters = { is_server: 1 };
            break;
        case 'married':
            detailTitle.value = 'Detalle: Adultos Casados';
            filters = { category: 'adulto', marital: 'married' };
            break;
        case 'single':
            detailTitle.value = 'Detalle: Adultos Solteros';
            filters = { category: 'adulto', marital: 'single' };
            break;
        case 'widowed':
            detailTitle.value = 'Detalle: Adultos Viudos';
            filters = { category: 'adulto', marital: 'widowed' };
            break;
        case 'divorced':
            detailTitle.value = 'Detalle: Adultos Divorciados';
            filters = { category: 'adulto', marital: 'divorced' };
            break;
        case 'adolescents':
            detailTitle.value = 'Detalle: Adolescentes';
            filters = { category: 'adolescente' };
            break;
        case 'children_male':
            detailTitle.value = 'Detalle: Niños (Varones)';
            filters = { category: 'niño', gender: 'M' };
            break;
        case 'children_female':
            detailTitle.value = 'Detalle: Niñas (Mujeres)';
            filters = { category: 'niño', gender: 'F' };
            break;
        case 'events':
            detailTitle.value = 'Detalle: Eventos del Mes';
            // Para eventos usamos los datos ya cargados en stats si están disponibles
            detailItems.value = stats.value?.upcoming_events || []; 
            // Podríamos hacer un fetch específico si se requiere más data
            detailLoading.value = false;
            return;
    }

    try {
        const result = await useMembers().getMembers({ ...filters, per_page: 500 });
        if (result.success) {
            detailItems.value = result.data.data || result.data || [];
        }
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo cargar el detalle' });
    } finally {
        detailLoading.value = false;
    }
};
</script>

<style scoped>
@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

@keyframes wiggle {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
}

@keyframes pulse-slow {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.15); }
    50% { transform: scale(1.05); }
    75% { transform: scale(1.15); }
}

.group:hover .pi-users {
    animation: bounce-subtle 0.6s ease-in-out infinite;
}

.group:hover .pi-briefcase {
    animation: pulse-slow 2s ease-in-out infinite;
}

.group:hover .pi-heart-fill {
    animation: heartbeat 0.8s ease-in-out infinite;
}

.group:hover .pi-bolt {
    animation: wiggle 0.4s ease-in-out infinite;
}
</style>
