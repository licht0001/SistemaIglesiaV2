<template>
    <div class="max-w-6xl mx-auto space-y-4">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Actividades</h1>
                <p class="text-xs text-slate-500">
                    Calendario de cultos, reuniones y eventos.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <Button label="Nueva actividad" icon="pi pi-calendar-plus" class="!text-xs" @click="openModal" />
                <Button label="Gestionar tipos" icon="pi pi-cog" class="!text-xs" severity="secondary" @click="openTypesManager" />
            </div>
        </header>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-center">
                <div class="flex justify-center w-full">
                    <Calendar v-model="filters.date" dateFormat="dd/mm/yy" class="w-full" placeholder="Seleccionar fecha" showIcon showButtonBar />
                </div>
                <div class="flex justify-center w-full">
                    <InputGroup class="w-full">
                        <Button icon="pi pi-search" outlined severity="secondary" class="!text-xs" />
                        <InputText v-model="filters.search" placeholder="Buscar en cualquier columna" class="w-full !text-xs" />
                    </InputGroup>
                </div>
            </div>
        </section>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs">
            <DataTable :value="events" size="small" dataKey="id" responsiveLayout="scroll" :loading="loading"
                       sortMode="multiple" removableSort filterDisplay="menu" v-model:filters="columnFilters">
                <Column field="start_at" header="Fecha/Hora" sortable :showFilterMatchModes="false" dataType="date">
                     <template #body="slotProps">
                        {{ formatDateTime(slotProps.data.start_at) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <Calendar v-model="filterModel.value" dateFormat="dd/mm/yy" class="w-full !text-xs" showIcon showButtonBar />
                    </template>
                </Column>
                <Column field="name" header="Actividad" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Buscar..." class="w-full !text-xs" />
                    </template>
                </Column>
                <Column field="type" header="Tipo" sortable :showFilterMatchModes="false">
                    <template #body="slotProps">
                        {{ renderType(slotProps.data.type) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="typeOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="description" header="Descripción" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Buscar..." class="w-full !text-xs" />
                    </template>
                </Column>
                <Column field="location" header="Lugar" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Buscar..." class="w-full !text-xs" />
                    </template>
                </Column>
                <Column header="Acciones">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" text rounded severity="secondary" size="small" @click="editEvent(slotProps.data)" />
                         <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDelete(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </section>

         <!-- Modal de Creación/Edición -->
        <Dialog v-model:visible="modalVisible" :header="isEditing ? 'Editar Actividad' : 'Nueva Actividad'" modal class="w-full max-w-lg">
            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Nombre de la actividad *</label>
                    <InputText v-model="form.name" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Tipo de actividad *</label>
                    <Dropdown v-model="form.type" :options="typeOptions" optionLabel="label" optionValue="value" placeholder="Seleccionar tipo" class="w-full" size="small" showClear />
                </div>
                 <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-600">Inicio *</label>
                        <Calendar v-model="form.start_at" showTime hourFormat="24" dateFormat="yy-mm-dd" class="w-full" showIcon showButtonBar />
                    </div>
                     <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-600">Fin</label>
                        <Calendar v-model="form.end_at" showTime hourFormat="24" dateFormat="yy-mm-dd" class="w-full" showIcon showButtonBar />
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Lugar / Ubicación</label>
                    <InputText v-model="form.location" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Descripción</label>
                    <InputText v-model="form.description" class="w-full" size="small" />
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" @click="closeModal" text severity="secondary" />
                <Button label="Guardar" icon="pi pi-check" @click="saveEvent" :loading="saving" />
            </template>
        </Dialog>

        <!-- Modal de Gestión de Tipos -->
        <Dialog v-model:visible="typesModalVisible" header="Gestionar tipos de actividad" modal class="w-full max-w-2xl">
            <div class="space-y-4">
                <div class="space-y-2">
                    <div v-if="!typeOptions.length" class="text-xs text-slate-500">No hay tipos definidos.</div>
                    <div v-else class="space-y-2 max-h-96 overflow-y-auto">
                        <div v-for="t in typeOptions" :key="t.id" class="grid grid-cols-4 gap-3 items-start p-2 bg-slate-50 rounded">
                            <InputText v-model="t.label" @blur="updateTypeLabel(t)" class="!text-xs w-full" size="small" />
                            <div class="space-y-1 text-xs flex flex-col items-center">
                                <p class="text-[11px] font-medium text-slate-600">Activo</p>
                                <InputSwitch v-model="t.is_active" @change="toggleTypeActive(t)" />
                            </div>
                            <div class="space-y-1 text-xs">
                                <p class="text-[11px] font-medium text-slate-600">Orden</p>
                                <InputNumber v-model="t.sort_order" :min="0" :max="99" @blur="updateTypeOrder(t)" inputClass="!text-xs" class="w-16" size="small" />
                            </div>
                            <div class="flex justify-end items-start">
                                <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="removeType(t)" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <InputText v-model="newTypeLabel" class="flex-1 !text-xs" size="small" placeholder="Etiqueta (ej: Culto)" />
                    <Button label="Agregar" icon="pi pi-plus" @click="addType" class="!text-xs" size="small" />
                </div>
            </div>
            <template #footer>
                <Button label="Cerrar" icon="pi pi-times" @click="closeTypesManager" text severity="secondary" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import InputGroup from 'primevue/inputgroup';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import InputSwitch from 'primevue/inputswitch';
import InputNumber from 'primevue/inputnumber';
import { useToast } from 'primevue/usetoast';     
import Swal from 'sweetalert2';
import { useEvents } from '../services/events';
import { useActivityTypes } from '../services/activityTypes';

const slugify = (text) => {
    return (text || '')
        .toString()
        .normalize('NFD')
        .replace(/\p{Diacritic}/gu, '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
};

const toast = useToast();
const route = useRoute();
const router = useRouter();
const { getEvents, createEvent, updateEvent, deleteEvent } = useEvents();
const { getAll: getActivityTypes, create: createActivityType, remove: removeActivityType, update: updateActivityType } = useActivityTypes();

const filters = reactive({
    date: null,
    type: null,
    search: '',
});

const typeOptions = ref([]);

const events = ref([]);
const loading = ref(true);
const modalVisible = ref(false);
const isEditing = ref(false);
const saving = ref(false);
const typesModalVisible = ref(false);
const newTypeLabel = ref('');
const newTypeValue = ref('');

watch(newTypeLabel, (val) => {
    if (!newTypeValue.value) newTypeValue.value = slugify(val);
});
const columnFilters = ref({
    start_at: { value: null, matchMode: 'dateIs' },
    name: { value: null, matchMode: 'contains' },
    type: { value: null, matchMode: 'equals' },
    description: { value: null, matchMode: 'contains' },
    location: { value: null, matchMode: 'contains' }
});

const form = reactive({
    id: null,
    name: '',
    description: '',
    start_at: null,
    end_at: null,
    location: '',
    type: null,
});


onMounted(async () => {
    await fetchEvents();
    const typesRes = await getActivityTypes(true);
    if (typesRes.success) {
        typeOptions.value = typesRes.data;
    }

    if (route.query.action === 'create') {
        openModal();
        // Clean query to avoid reopening on refresh
        router.replace({ query: {} });
    }
});

let fetchTimeout = null;
watch(filters, () => {
    clearTimeout(fetchTimeout);
    fetchTimeout = setTimeout(fetchEvents, 250);
}, { deep: true });

const formatDateParam = (value) => {
    if (!value) return null;
    const d = value instanceof Date ? value : new Date(value);
    return d.toISOString().split('T')[0];
};

const fetchEvents = async () => {
    loading.value = true;
    const params = {};
    if (filters.date) params.date = formatDateParam(filters.date);
    if (filters.search) params.search = filters.search;
    // Nota: se removió filtro de tipo en la fila superior, pero las columnas siguen teniendo embudo específico.

    const result = await getEvents(params);
    if (result.success) {
        events.value = result.data.data ? result.data.data : result.data;
    }
    loading.value = false;
};

const formatDateTime = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleString('es-BO', { 
        year: 'numeric', month: '2-digit', day: '2-digit', 
        hour: '2-digit', minute: '2-digit'
    });
};

const renderType = (t) => {
    if (!t) return '';
    const map = {
        culto: 'Culto',
        reunion_lideres: 'Reunión de líderes',
        vigilia: 'Vigilia',
        retiro: 'Retiro'
    };
    return map[t] || t;
};

const openModal = () => {
    isEditing.value = false;
    resetForm();
    modalVisible.value = true;
};

const openTypesManager = () => {
    typesModalVisible.value = true;
};

const closeTypesManager = () => {
    typesModalVisible.value = false;
    newTypeLabel.value = '';
    newTypeValue.value = '';
};

const addType = async () => {
    const label = (newTypeLabel.value || '').trim();
    const value = (newTypeValue.value || slugify(label)).trim();
    if (!label || !value) {
        toast.add({ severity: 'warn', summary: 'Campos requeridos', detail: 'Etiqueta es obligatoria', life: 3000 });
        return;
    }
    const exists = typeOptions.value.some(t => t.value.toLowerCase() === value.toLowerCase());
    if (exists) {
        toast.add({ severity: 'warn', summary: 'Duplicado', detail: 'Ya existe un tipo con ese valor', life: 3000 });
        return;
    }
    const res = await createActivityType({ label, value });
    if (!res.success) {
        toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 });
        return;
    }
    const typesRes = await getActivityTypes(true);
    if (typesRes.success) {
        typeOptions.value = typesRes.data;
    }
    newTypeLabel.value = '';
    newTypeValue.value = '';
    toast.add({ severity: 'success', summary: 'Tipo agregado', detail: 'Se agregó el nuevo tipo', life: 2500 });
};

const removeType = async (t) => {
    const res = await removeActivityType(t.id);
    if (!res.success) {
        toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 });
        return;
    }
    const typesRes = await getActivityTypes(true);
    if (typesRes.success) {
        typeOptions.value = typesRes.data;
    }
    toast.add({ severity: 'success', summary: 'Tipo eliminado', detail: `Se eliminó "${t.label}"`, life: 2500 });
};

const toggleTypeActive = async (t) => {
    const res = await updateActivityType(t.id, { is_active: !!t.is_active });
    if (!res.success) {
        toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'No se pudo actualizar el estado', life: 3000 });
        return;
    }
    const typesRes = await getActivityTypes(true);
    if (typesRes.success) {
        typeOptions.value = typesRes.data;
    }
};

const updateTypeOrder = async (t) => {
    const order = Number(t.sort_order) || 0;
    const res = await updateActivityType(t.id, { sort_order: order });
    if (!res.success) {
        toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'No se pudo actualizar el orden', life: 3000 });
        return;
    }
    const typesRes = await getActivityTypes(true);
    if (typesRes.success) {
        typeOptions.value = typesRes.data;
    }
};

const updateTypeLabel = async (t) => {
    if (!t.label || !t.label.trim()) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'La etiqueta es obligatoria', life: 2500 });
        const typesRes = await getActivityTypes(true);
        if (typesRes.success) typeOptions.value = typesRes.data;
        return;
    }
    const payload = { label: t.label.trim() };
    if (!t.value) {
        payload.value = slugify(t.label);
        t.value = payload.value;
    }
    const res = await updateActivityType(t.id, payload);
    if (!res.success) {
        toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'No se pudo actualizar el nombre', life: 3000 });
        const typesRes = await getActivityTypes(true);
        if (typesRes.success) typeOptions.value = typesRes.data;
    } else {
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Tipo actualizado', life: 2000 });
        const typesRes = await getActivityTypes(true);
        if (typesRes.success) typeOptions.value = typesRes.data;
    }
};
const editEvent = (event) => {
    isEditing.value = true;
    form.id = event.id;
    form.name = event.name;
    form.description = event.description;
    form.start_at = event.start_at ? new Date(event.start_at) : null;
    form.end_at = event.end_at ? new Date(event.end_at) : null;
    form.location = event.location;
    form.type = event.type || null;
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
    resetForm();
};

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.description = '';
    form.start_at = null;
    form.end_at = null;
    form.location = '';
    form.type = null;
};

const saveEvent = async () => {
    saving.value = true;
    const dataToSend = { ...form };
    
    // Format dates for API (YYYY-MM-DD HH:mm:ss) could be handled by Laravel cast, but safe to send ISO or string
    // PrimeVue Calendar returns Date object.
    
    // Simple verification
    if (!dataToSend.name || !dataToSend.start_at || !dataToSend.type) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'Nombre, tipo y fecha de inicio son obligatorios', life: 3000 });
        saving.value = false;
        return;
    }

    let result;
    if (isEditing.value) {
        result = await updateEvent(form.id, dataToSend);
    } else {
        result = await createEvent(dataToSend);
    }

    if (result.success) {
        toast.add({ severity: 'success', summary: 'Éxito', detail: isEditing.value ? 'Actividad actualizada' : 'Actividad creada', life: 3000 });
        await fetchEvents();
        closeModal();
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'Error al guardar', life: 3000 });
    }
    saving.value = false;
};

const confirmDelete = async (event) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Eliminarás la actividad "${event.name}".`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            loading.value = true;
            const res = await deleteEvent(event.id);
            loading.value = false;

            if (res.success) {
                toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Actividad eliminada', life: 3000 });
                await fetchEvents();
            } else {
                toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'Error al eliminar', life: 3000 });
            }
        }
    });
};
</script>
