<template>
    <div class="space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Peticiones de Oración</h1>
                <p class="text-sm text-slate-500">Gestiona las peticiones recibidas desde la web pública</p>
            </div>
            <div class="flex gap-2">
                <Button label="Configurar Mensaje" icon="pi pi-cog" severity="secondary" @click="openConfig" />
                <Button label="Actualizar" icon="pi pi-refresh" text @click="loadPrayers" :loading="loading" />
            </div>
        </header>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <!-- Filtros -->
            <div class="p-4 border-b border-slate-100 bg-slate-50">
                <div class="flex gap-3">
                    <div class="flex-1">
                        <InputText v-model="filters.search" placeholder="Buscar por nombre o petición..." class="w-full" @input="applyFilters" />
                    </div>
                    <Dropdown v-model="filters.status" :options="statusOptions" optionLabel="label" optionValue="value" placeholder="Estado" class="w-48" @change="applyFilters" />
                </div>
            </div>

            <!-- Tabla -->
            <DataTable :value="filteredPrayers" :loading="loading" stripedRows paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
                <template #empty>
                    <div class="text-center py-8 text-slate-400">
                        <i class="pi pi-inbox text-4xl mb-3"></i>
                        <p>No hay peticiones de oración registradas</p>
                    </div>
                </template>

                <Column field="id" header="ID" :sortable="true" style="width: 80px">
                    <template #body="slotProps">
                        <span class="font-mono text-xs text-slate-500">#{{ slotProps.data.id }}</span>
                    </template>
                </Column>

                <Column field="name" header="Nombre" :sortable="true">
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <i v-if="slotProps.data.is_anonymous" class="pi pi-eye-slash text-slate-400 text-xs" v-tooltip="'Anónimo'"></i>
                            <span class="font-medium text-slate-700">{{ slotProps.data.name || 'Anónimo' }}</span>
                        </div>
                    </template>
                </Column>

                <Column field="request" header="Petición" style="max-width: 400px">
                    <template #body="slotProps">
                        <p class="text-sm text-slate-600 line-clamp-2">{{ slotProps.data.request }}</p>
                    </template>
                </Column>

                <Column field="contact_info" header="Contacto">
                    <template #body="slotProps">
                        <span class="text-xs text-slate-500">{{ slotProps.data.contact_info || '-' }}</span>
                    </template>
                </Column>

                <Column field="status" header="Estado" :sortable="true" style="width: 150px">
                    <template #body="slotProps">
                        <Tag :value="getStatusLabel(slotProps.data.status)" :severity="getStatusSeverity(slotProps.data.status)" />
                    </template>
                </Column>

                <Column field="created_at" header="Fecha" :sortable="true" style="width: 150px">
                    <template #body="slotProps">
                        <span class="text-xs text-slate-500">{{ formatDate(slotProps.data.created_at) }}</span>
                    </template>
                </Column>

                <Column header="Acciones" style="width: 120px">
                    <template #body="slotProps">
                        <div class="flex gap-1">
                            <Button icon="pi pi-eye" text rounded size="small" @click="viewPrayer(slotProps.data)" v-tooltip="'Ver detalles'" />
                            <Button icon="pi pi-trash" text rounded size="small" severity="danger" @click="confirmDelete(slotProps.data)" v-tooltip="'Eliminar'" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- Dialog de Detalles -->
        <Dialog v-model:visible="detailsDialog" modal header="Detalles de la Petición" :style="{ width: '600px' }">
            <div v-if="selectedPrayer" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Nombre</label>
                        <p class="text-slate-700 font-medium">{{ selectedPrayer.name || 'Anónimo' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Contacto</label>
                        <p class="text-slate-700">{{ selectedPrayer.contact_info || 'No proporcionado' }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Petición</label>
                    <p class="text-slate-700 leading-relaxed mt-1 p-4 bg-slate-50 rounded-lg border border-slate-200">{{ selectedPrayer.request }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Estado Actual</label>
                        <Dropdown v-model="selectedPrayer.status" :options="statusOptions" optionLabel="label" optionValue="value" class="w-full mt-1" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase">Fecha de Recepción</label>
                        <p class="text-slate-700 mt-1">{{ formatDate(selectedPrayer.created_at) }}</p>
                    </div>
                </div>

                <div v-if="selectedPrayer.is_anonymous" class="p-3 bg-amber-50 border border-amber-200 rounded-lg flex items-center gap-2 text-amber-800 text-sm">
                    <i class="pi pi-info-circle"></i>
                    <span>Esta petición fue enviada de forma anónima</span>
                </div>
            </div>

            <template #footer>
                <Button label="Cerrar" text @click="detailsDialog = false" />
                <Button label="Guardar Cambios" @click="updateStatus" :loading="saving" />
            </template>
        </Dialog>

        <!-- Dialog de Confirmación de Eliminación -->
        <Dialog v-model:visible="deleteDialog" modal header="Confirmar Eliminación" :style="{ width: '450px' }">
            <div class="flex items-center gap-3">
                <i class="pi pi-exclamation-triangle text-amber-500 text-3xl"></i>
                <p class="text-slate-700">¿Estás seguro de que deseas eliminar esta petición de oración? Esta acción no se puede deshacer.</p>
            </div>
            <template #footer>
                <Button label="Cancelar" text @click="deleteDialog = false" />
                <Button label="Eliminar" severity="danger" @click="deletePrayer" :loading="deleting" />
            </template>
        </Dialog>
        <Dialog v-model:visible="configDialog" modal header="Configuración Mensaje de Éxito" :style="{ width: '500px' }">
            <div class="space-y-4">
                <p class="text-sm text-slate-600">Este mensaje se mostrará a los visitantes cuando envíen exitosamente una petición de oración.</p>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase">Mensaje de Confirmación</label>
                    <Textarea v-model="successMessageConfig" rows="3" class="w-full" />
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" text @click="configDialog = false" />
                <Button label="Guardar Configuración" @click="saveConfig" :loading="savingConfig" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Dialog from 'primevue/dialog';
import Tag from 'primevue/tag';
import { useToast } from 'primevue/usetoast';
import { fetchLandingSettings, updateLandingSettings } from '../services/settings';
import api from '../services/api';

const toast = useToast();
const loading = ref(false);
const saving = ref(false);
const deleting = ref(false);
const prayers = ref([]);
const detailsDialog = ref(false);
const deleteDialog = ref(false);
const configDialog = ref(false);
const savingConfig = ref(false);
const selectedPrayer = ref(null);
const successMessageConfig = ref('');
const fullLandingConfig = ref({});

const filters = ref({
    search: '',
    status: null
});

const statusOptions = [
    { label: 'Todos', value: null },
    { label: 'Pendiente', value: 'pendiente' },
    { label: 'Mencionado', value: 'mensionado' },
    { label: 'Completado', value: 'completado' }
];

const filteredPrayers = computed(() => {
    let result = prayers.value;

    if (filters.value.search) {
        const search = filters.value.search.toLowerCase();
        result = result.filter(p => 
            (p.name && p.name.toLowerCase().includes(search)) ||
            p.request.toLowerCase().includes(search)
        );
    }

    if (filters.value.status) {
        result = result.filter(p => p.status === filters.value.status);
    }

    return result;
});

const loadPrayers = async () => {
    loading.value = true;
    try {
        const { data } = await api.get('/prayer-requests');
        prayers.value = data;
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudieron cargar las peticiones', life: 3000 });
    } finally {
        loading.value = false;
    }
};

const openConfig = async () => {
    configDialog.value = true;
    try {
        const settings = await fetchLandingSettings();
        fullLandingConfig.value = settings;
        successMessageConfig.value = settings.prayerRequestSuccessMessage || 'Estaremos orando por ti. ¡Dios te bendiga!';
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo cargar la configuración', life: 3000 });
    }
};

const saveConfig = async () => {
    savingConfig.value = true;
    try {
        const newSettings = { 
            ...fullLandingConfig.value,
            prayerRequestSuccessMessage: successMessageConfig.value 
        };
        await updateLandingSettings(newSettings);
        toast.add({ severity: 'success', summary: 'Guardado', detail: 'Configuración actualizada', life: 3000 });
        configDialog.value = false;
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo guardar la configuración', life: 3000 });
    } finally {
        savingConfig.value = false;
    }
};

const viewPrayer = (prayer) => {
    selectedPrayer.value = { ...prayer };
    detailsDialog.value = true;
};

const updateStatus = async () => {
    saving.value = true;
    try {
        await api.put(`/prayer-requests/${selectedPrayer.value.id}`, {
            status: selectedPrayer.value.status
        });
        
        const index = prayers.value.findIndex(p => p.id === selectedPrayer.value.id);
        if (index !== -1) {
            prayers.value[index].status = selectedPrayer.value.status;
        }

        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Estado actualizado correctamente', life: 3000 });
        detailsDialog.value = false;
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo actualizar el estado', life: 3000 });
    } finally {
        saving.value = false;
    }
};

const confirmDelete = (prayer) => {
    selectedPrayer.value = prayer;
    deleteDialog.value = true;
};

const deletePrayer = async () => {
    deleting.value = true;
    try {
        await api.delete(`/prayer-requests/${selectedPrayer.value.id}`);
        prayers.value = prayers.value.filter(p => p.id !== selectedPrayer.value.id);
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Petición eliminada correctamente', life: 3000 });
        deleteDialog.value = false;
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo eliminar la petición', life: 3000 });
    } finally {
        deleting.value = false;
    }
};

const applyFilters = () => {
    // Los filtros se aplican automáticamente mediante computed
};

const getStatusLabel = (status) => {
    const labels = {
        'pendiente': 'Pendiente',
        'mensionado': 'Mencionado',
        'completado': 'Completado'
    };
    return labels[status] || status;
};

const getStatusSeverity = (status) => {
    const severities = {
        'pendiente': 'warning',
        'mensionado': 'info',
        'completado': 'success'
    };
    return severities[status] || 'secondary';
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

onMounted(() => {
    loadPrayers();
});
</script>
