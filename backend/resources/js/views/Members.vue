<template>
    <div class="max-w-6xl mx-auto space-y-4">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Miembros</h1>
                <p class="text-xs text-slate-500">
                    Listado de miembros de la iglesia.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <Button label="Nuevo miembro" icon="pi pi-user-plus" class="!text-xs" @click="openModal" />
                <Button 
                    label="Exportar Excel" 
                    icon="pi pi-file-excel" 
                    class="!text-xs export-excel-btn"
                    @click="exportToExcel"
                    :loading="exporting" />
            </div>
        </header>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs space-y-3">
            <div class="grid gap-2 items-center" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <div style="max-width: 210px; width: 100%;">
                    <Calendar v-model="filters.date" selectionMode="range" dateFormat="dd/mm/yy" class="w-full" placeholder="Fecha"
                               showIcon icon="pi pi-calendar" iconDisplay="input" />
                </div>
                <div>
                    <InputGroup class="w-full">
                        <Button icon="pi pi-search" outlined severity="secondary" class="!text-xs" />
                        <InputText v-model="filters.search" placeholder="Buscar en cualquier columna" class="w-full !text-xs" />
                    </InputGroup>
                </div>
            </div>
        </section>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs">
            <DataTable :value="members" size="small" dataKey="id" responsiveLayout="scroll" :loading="loading"
                       sortMode="multiple" removableSort filterDisplay="menu" v-model:filters="columnFilters">
                <Column field="first_name" header="Nombre" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" class="w-full !text-xs" placeholder="Contiene" />
                    </template>
                </Column>
                <Column field="last_name" header="Apellido" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" class="w-full !text-xs" placeholder="Contiene" />
                    </template>
                </Column>
                <Column field="category" header="Categoría" sortable :showFilterMatchModes="false">
                    <template #body="slotProps">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium" 
                              :class="getCategoryBadgeClass(slotProps.data.category)">
                            {{ formatCategory(slotProps.data.category) }}
                        </span>
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="categoryOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="birth_date" header="Nacimiento" sortable dataType="date" :showFilterMatchModes="false">
                    <template #body="slotProps">
                        {{ formatDate(slotProps.data.birth_date) }}
                    </template>
                </Column>
                <Column field="gender" header="Género" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="genderOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="marital_status" header="Estado civil" sortable :showFilterMatchModes="false">
                    <template #body="slotProps">
                        {{ formatMaritalStatus(slotProps.data.marital_status) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="maritalOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="status" header="Estado" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="statusOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="phone" header="Teléfono" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" class="w-full !text-xs" placeholder="Contiene" />
                    </template>
                </Column>
                <Column field="baptized" header="Bautizado" sortable :showFilterMatchModes="false">
                    <template #body="slotProps">
                        <span :class="slotProps.data.baptism_date ? 'text-emerald-600 font-semibold' : 'text-slate-400'">
                            {{ slotProps.data.baptism_date ? 'Sí' : 'No' }}
                        </span>
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="baptizedOptions" optionLabel="label" optionValue="value" placeholder="Todos" class="w-full !text-xs" showClear />
                    </template>
                </Column>
                <Column header="Acciones">
                    <template #body="slotProps">
                    <div class="flex gap-1">
                        <Button icon="pi pi-pencil" text rounded severity="secondary" size="small" @click="editMember(slotProps.data)" />
                        <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDelete(slotProps.data)" />
                    </div>
                    </template>
                </Column>
            </DataTable>
        </section>

        <!-- Modal de Creación/Edición -->
        <Dialog v-model:visible="modalVisible" :header="isEditing ? 'Editar Miembro' : 'Nuevo Miembro'" modal class="w-full max-w-2xl">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Nombre *</label>
                    <InputText v-model="form.first_name" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Apellidos *</label>
                    <InputText v-model="form.last_name" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Categoría *</label>
                    <Dropdown v-model="form.category" :options="categoryOptions" optionLabel="label" optionValue="value" class="w-full" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Fecha de Nacimiento</label>
                    <Calendar v-model="form.birth_date" dateFormat="yy-mm-dd" class="w-full" showIcon />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Género</label>
                    <Dropdown v-model="form.gender" :options="genderOptions" optionLabel="label" optionValue="value" class="w-full" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Teléfono</label>
                    <InputText v-model="form.phone" class="w-full" size="small" />
                </div>
                 <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Email</label>
                    <InputText v-model="form.email" class="w-full" size="small" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Dirección</label>
                    <InputText v-model="form.address" class="w-full" size="small" />
                </div>
                <div class="space-y-1" v-if="form.category === 'adulto'">
                    <label class="text-xs font-medium text-slate-600">Estado Civil</label>
                    <Dropdown v-model="form.marital_status" :options="maritalOptions" optionLabel="label" optionValue="value" class="w-full" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Bautizado</label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" v-model="form.baptized" id="baptized-toggle" class="form-checkbox h-4 w-4 text-emerald-600" />
                        <label for="baptized-toggle" class="text-xs">{{ form.baptized ? 'Sí' : 'No' }}</label>
                    </div>
                </div>
                <div v-if="form.baptized" class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Fecha de Bautismo</label>
                    <Calendar v-model="form.baptism_date" dateFormat="yy-mm-dd" class="w-full" showIcon />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Estado Espiritual</label>
                    <Dropdown v-model="form.status" :options="statusOptions" optionLabel="label" optionValue="value" class="w-full" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">¿Es Servidor?</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="checkbox" v-model="form.is_server" id="server-toggle" class="form-checkbox h-4 w-4 text-emerald-600 rounded" />
                        <label for="server-toggle" class="text-xs text-slate-500">{{ form.is_server ? 'Sí, es servidor' : 'No en este momento' }}</label>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" @click="closeModal" text severity="secondary" />
                <Button label="Guardar" icon="pi pi-check" @click="saveMember" :loading="saving" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputGroup from 'primevue/inputgroup';
import Dropdown from 'primevue/dropdown';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Calendar from 'primevue/calendar';
import { useToast } from 'primevue/usetoast';     
import Swal from 'sweetalert2';
import { useMembers } from '../services/members';

const toast = useToast();
const route = useRoute();
const router = useRouter();
const { getMembers, createMember, updateMember, deleteMember, exportMembers } = useMembers();

const filters = reactive({
    date: null,
    search: '',
});

const genderOptions = [
    { label: 'Masculino', value: 'M' },
    { label: 'Femenino', value: 'F' },
];

const statusOptions = [
    { label: 'Activo', value: 'active' },
    { label: 'Inactivo', value: 'inactive' },
];

const maritalOptions = [
    { label: 'Soltero(a)', value: 'single' },
    { label: 'Casado(a)', value: 'married' },
    { label: 'Viudo(a)', value: 'widowed' },
    { label: 'Divorciado(a)', value: 'divorced' },
];

const categoryOptions = [
    { label: 'Niño/a', value: 'niño' },
    { label: 'Adolescente', value: 'adolescente' },
    { label: 'Adulto', value: 'adulto' }
];

const members = ref([]);
const loading = ref(true);
const modalVisible = ref(false);
const isEditing = ref(false);
const saving = ref(false);
const exporting = ref(false);

const columnFilters = ref({
    first_name: { value: null, matchMode: 'contains' },
    last_name: { value: null, matchMode: 'contains' },
    category: { value: null, matchMode: 'equals' },
    birth_date: { value: null, matchMode: 'dateIs' },
    gender: { value: null, matchMode: 'equals' },
    marital_status: { value: null, matchMode: 'equals' },
    status: { value: null, matchMode: 'equals' },
    phone: { value: null, matchMode: 'contains' },
    baptized: { value: null, matchMode: 'equals' },
});

const baptizedOptions = [
    { label: 'Sí', value: true },
    { label: 'No', value: false },
];

const form = reactive({
    id: null,
    first_name: '',
    last_name: '',
    birth_date: null,
    gender: null,
    category: 'adulto',
    phone: '',
    email: '',
    address: '',
    marital_status: null,
    status: 'active',
    baptized: false,
    baptism_date: null,
    is_server: false,
});

// Watch filters for real-time filtering
watch(filters, () => {
    fetchMembers();
}, { deep: true });

onMounted(async () => {
    await fetchMembers();
    
    if (route.query.action === 'create') {
        openModal();
        // Clean query to avoid reopening on refresh
        router.replace({ query: {} });
    }
});

const formatDateParam = (value) => {
    if (!value) return null;
    const d = value instanceof Date ? value : new Date(value);
    return d.toISOString().split('T')[0];
};

const fetchMembers = async () => {
    loading.value = true;
    const params = {};
    if (filters.search) params.search = filters.search;
    if (filters.date && Array.isArray(filters.date) && filters.date.length === 2) {
        params.birth_date_from = formatDateParam(filters.date[0]);
        params.birth_date_to = formatDateParam(filters.date[1]);
    }
    // Filtro de bautizado
    if (columnFilters.value.baptized.value !== null && columnFilters.value.baptized.value !== undefined) {
        params.baptized = columnFilters.value.baptized.value ? 1 : 0;
    }
    const result = await getMembers(params);
    if (result.success) {
        members.value = result.data.data ? result.data.data : result.data;
    }
    loading.value = false;
};

const formatCategory = (val) => {
    if (!val) return 'Adulto';
    return val.charAt(0).toUpperCase() + val.slice(1);
};

const formatMaritalStatus = (val) => {
    if (!val) return '';
    const option = maritalOptions.find(o => o.value === val);
    return option ? option.label : val;
};

const getCategoryBadgeClass = (val) => {
    switch(val) {
        case 'niño': return 'bg-sky-100 text-sky-700';
        case 'adolescente': return 'bg-amber-100 text-amber-700';
        default: return 'bg-slate-100 text-slate-700';
    }
};

const exportToExcel = async () => {
    exporting.value = true;
    try {
        const params = {};
        if (filters.search) params.search = filters.search;
        if (filters.date && Array.isArray(filters.date) && filters.date.length === 2) {
            params.birth_date_from = formatDateParam(filters.date[0]);
            params.birth_date_to = formatDateParam(filters.date[1]);
        }
        const result = await exportMembers(params);
        
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
            toast.add({ severity: 'success', summary: 'Éxito', detail: 'Archivo Excel exportado correctamente', life: 3000 });
        } else {
            toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'Error al exportar', life: 3000 });
        }
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Error al exportar el archivo', life: 3000 });
    } finally {
        exporting.value = false;
    }
};

const openModal = () => {
    isEditing.value = false;
    resetForm();
    modalVisible.value = true;
};

const editMember = (member) => {
    isEditing.value = true;
    form.id = member.id;
    form.first_name = member.first_name;
    form.last_name = member.last_name;
    form.category = member.category || 'adulto';
    form.birth_date = member.birth_date ? new Date(member.birth_date) : null; 
    form.gender = member.gender;
    form.phone = member.phone;
    form.email = member.email;
    form.address = member.address;
    form.marital_status = member.marital_status;
    form.status = member.status;
    form.baptized = !!member.baptism_date;
    form.baptism_date = member.baptism_date ? new Date(member.baptism_date) : null;
    form.is_server = !!member.is_server;
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
    resetForm();
};

const resetForm = () => {
    form.id = null;
    form.first_name = '';
    form.last_name = '';
    form.category = 'adulto';
    form.birth_date = null;
    form.gender = null;
    form.phone = '';
    form.email = '';
    form.address = '';
    form.marital_status = null;
    form.status = 'active';
    form.baptized = false;
    form.baptism_date = null;
    form.is_server = false;
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const d = new Date(dateString);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
};

const saveMember = async () => {
    saving.value = true;
    const dataToSend = { ...form };
    if (dataToSend.birth_date instanceof Date) {
        dataToSend.birth_date = dataToSend.birth_date.toISOString().split('T')[0];
    }
    if (dataToSend.baptism_date instanceof Date) {
        dataToSend.baptism_date = dataToSend.baptism_date.toISOString().split('T')[0];
    }
    if (!dataToSend.baptized) {
        dataToSend.baptism_date = null;
    }
    if (!dataToSend.first_name) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'El nombre es obligatorio', life: 3000 });
        saving.value = false;
        return;
    }
    if (!dataToSend.last_name) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'El apellido es obligatorio', life: 3000 });
        saving.value = false;
        return;
    }
    let result;
    if (isEditing.value) {
        result = await updateMember(form.id, dataToSend);
    } else {
        result = await createMember(dataToSend);
    }
    if (result.success) {
        toast.add({ severity: 'success', summary: 'Éxito', detail: isEditing.value ? 'Miembro actualizado' : 'Miembro creado', life: 3000 });
        await fetchMembers();
        closeModal();
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'Error al guardar', life: 3000 });
    }
    saving.value = false;
};

const confirmDelete = (member) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Eliminarás a ${member.first_name} ${member.last_name}. Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            loading.value = true;
            const res = await deleteMember(member.id);
            loading.value = false;
            if (res.success) {
                toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Miembro eliminado correctamente', life: 3000 });
                await fetchMembers();
            } else {
                toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'No se pudo eliminar', life: 3000 });
            }
        }
    });
};
</script>

<style scoped>
.export-excel-btn {
    background: #16a34a !important;
    border-color: #16a34a !important;
    color: white !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}
.export-excel-btn:hover {
    background: #15803d !important;
    border-color: #15803d !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
}
.export-excel-btn:active {
    transform: translateY(0);
}
:deep(.p-dropdown .p-dropdown-label) {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
:deep(.p-dropdown .p-dropdown-trigger) {
    width: 2rem;
}
</style>
