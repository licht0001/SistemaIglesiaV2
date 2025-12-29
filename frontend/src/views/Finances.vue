<template>
    <div class="max-w-6xl mx-auto space-y-4">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Finanzas</h1>
                <p class="text-xs text-slate-500">
                    Módulo de tesorería.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <Button 
                    label="Exportar Excel" 
                    icon="pi pi-file-excel" 
                    class="!text-xs export-excel-btn"
                    @click="exportToExcel"
                    :loading="exporting" />
                <Button label="Nuevo ingreso" icon="pi pi-plus" class="!text-xs" severity="success" @click="openModal('ingreso')" />
                <Button label="Nuevo egreso" icon="pi pi-minus" severity="danger" class="!text-xs" @click="openModal('egreso')" />
            </div>
        </header>

        <section class="grid md:grid-cols-3 gap-3 text-xs">
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-start justify-between">
                <div>
                    <p class="text-slate-500 mb-1">Ingresos</p>
                    <p class="text-lg font-semibold text-emerald-700">{{ formatCurrency(totalIncome) }}</p>
                    <p class="text-[11px] text-emerald-600">Diezmos, ofrendas, donaciones</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg">
                    <i class="pi pi-arrow-down-left text-emerald-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-start justify-between">
                <div>
                    <p class="text-slate-500 mb-1">Egresos</p>
                    <p class="text-lg font-semibold text-slate-900">{{ formatCurrency(totalExpense) }}</p>
                    <p class="text-[11px] text-slate-600">Gastos operativos, ayudas, misiones</p>
                </div>
                <div class="p-3 bg-rose-50 rounded-lg">
                    <i class="pi pi-arrow-up-right text-rose-500 text-xl"></i>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-3 flex items-start justify-between">
                <div>
                    <p class="text-slate-500 mb-1">Saldo</p>
                    <p class="text-lg font-semibold text-emerald-700">{{ formatCurrency(balance) }}</p>
                    <p class="text-[11px] text-slate-600">Disponible en caja/fondos</p>
                </div>
                <div class="p-3 bg-slate-50 rounded-lg">
                    <i class="pi pi-wallet text-slate-600 text-xl"></i>
                </div>
            </div>
        </section>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs space-y-3">
            <div class="grid gap-2 items-center" style="grid-template-columns: 1fr auto 1fr 2fr;">
                <div style="max-width: 210px; width: 100%;">
                    <Calendar v-model="filters.dateFrom" dateFormat="dd/mm/yy" class="w-full" placeholder="Fecha inicio"
                              showIcon icon="pi pi-calendar" iconDisplay="input" />
                </div>
                <div class="flex justify-center">
                    <Button icon="pi pi-refresh" text rounded severity="secondary" class="!text-xs" @click="resetDateFilters" 
                            v-tooltip.top="'Restablecer fechas'" />
                </div>
                <div style="max-width: 210px; width: 100%;">
                    <Calendar v-model="filters.dateTo" dateFormat="dd/mm/yy" class="w-full" placeholder="Fecha fin"
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
            <DataTable :value="transactions" size="small" dataKey="id" responsiveLayout="scroll" :loading="loading"
                       sortMode="multiple" removableSort filterDisplay="menu" v-model:filters="columnFilters">
                <Column field="transaction_date" header="Fecha" sortable :showFilterMatchModes="false" dataType="date">
                     <template #body="slotProps">
                        {{ formatDate(slotProps.data.transaction_date) }}
                    </template>
                </Column>
                <Column field="type" header="Tipo" sortable :showFilterMatchModes="false">
                     <template #body="slotProps">
                                                <span class="px-2 py-1 rounded text-[10px] font-medium"
                                                            :class="slotProps.data.type === 'ingreso' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'">
                                                        {{ slotProps.data.type === 'ingreso' ? 'Ingreso' : 'Egreso' }}
                        </span>
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="typeOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="category" header="Categoría" sortable :showFilterMatchModes="false">
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="categoryOptions" optionLabel="label" optionValue="value"
                                  placeholder="Seleccionar" class="w-full !text-xs" size="small" showClear />
                    </template>
                </Column>
                <Column field="amount" header="Monto" sortable dataType="numeric" :showFilterMatchModes="false">
                     <template #body="slotProps">
                        <span :class="slotProps.data.type === 'ingreso' ? 'text-emerald-700' : 'text-slate-900'">
                            {{ formatCurrency(slotProps.data.amount) }}
                        </span>
                    </template>
                </Column>
                <Column field="description" header="Descripción" sortable :showFilterMatchModes="false" />
                <Column header="Acciones">
                    <template #body="slotProps">
                         <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDelete(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </section>

        <!-- Modal de Creación -->
        <Dialog v-model:visible="modalVisible" :header="modalType === 'ingreso' ? 'Registrar Ingreso' : 'Registrar Egreso'" modal class="w-full max-w-lg">
            <div class="space-y-4">
                 <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-600">Monto *</label>
                         <InputNumber v-model="form.amount" mode="currency" currency="BOB" locale="es-BO" class="w-full" :min="0" />
                    </div>
                     <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-600">Fecha *</label>
                        <Calendar v-model="form.transaction_date" dateFormat="yy-mm-dd" class="w-full" showIcon />
                    </div>
                </div>
                
                 <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Categoría *</label>
                    <Dropdown v-model="form.category" :options="categoryOptions" optionLabel="label" optionValue="value" class="w-full !text-xs" size="small"
                              :placeholder="modalType === 'ingreso' ? 'Seleccione origen' : 'Seleccione destino'"/>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Descripción / Motivo</label>
                    <InputText v-model="form.description" class="w-full" size="small" />
                </div>
                
                <div class="space-y-1" v-if="modalType === 'income'">
                     <label class="text-xs font-medium text-slate-600">Miembro (Opcional)</label>
                     <Dropdown v-model="form.member_id" :options="membersList" optionLabel="full_name" optionValue="id" 
                               placeholder="Seleccionar miembro" class="w-full !text-xs" size="small" filter showClear />
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" @click="closeModal" text severity="secondary" />
                <Button label="Guardar" icon="pi pi-check" @click="saveTransaction" :loading="saving" 
                        :severity="modalType === 'income' ? 'success' : 'danger'" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import InputGroup from 'primevue/inputgroup';
import InputNumber from 'primevue/inputnumber';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';     
import Swal from 'sweetalert2';
import { useTransactions } from '../services/transactions';
import { useMembers } from '../services/members';

const toast = useToast();
const route = useRoute();
const router = useRouter();
const { getTransactions, createTransaction, deleteTransaction, exportTransactions } = useTransactions();
const { getMembers } = useMembers();

const filters = reactive({
    dateFrom: null,
    dateTo: null,
    type: null,
    category: null,
    search: '',
});

const typeOptions = [
    { label: 'Ingresos', value: 'ingreso' },
    { label: 'Egresos', value: 'egreso' },
];

const categoryOptions = [
    { label: 'Diezmo', value: 'tithe' },
    { label: 'Ofrenda', value: 'offering' },
    { label: 'Donación', value: 'donation' },
    { label: 'Gasto operativo', value: 'operational' },
    { label: 'Mantenimiento', value: 'maintenance' },
];

const transactions = ref([]);
const membersList = ref([]);
const loading = ref(true);
const modalVisible = ref(false);
const modalType = ref('ingreso'); // 'ingreso' or 'egreso'
const saving = ref(false);
const exporting = ref(false);

const columnFilters = ref({
    transaction_date: { value: null, matchMode: 'dateIs' },
    type: { value: null, matchMode: 'equals' },
    category: { value: null, matchMode: 'in' },
    amount: { value: null, matchMode: 'equals' },
    description: { value: null, matchMode: 'contains' }
});

const resetDateFilters = () => {
    filters.dateFrom = null;
    filters.dateTo = null;
};

const exportToExcel = async () => {
    exporting.value = true;
    try {
        const params = {};
        if (filters.dateFrom) params.date_from = formatDateParam(filters.dateFrom);
        if (filters.dateTo) params.date_to = formatDateParam(filters.dateTo);
        if (filters.search) params.search = filters.search;
        
        const result = await exportTransactions(params);
        
        if (result.success) {
            const blob = new Blob([result.data], { 
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
            });
            
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `transacciones_${new Date().toISOString().split('T')[0]}.xlsx`;
            document.body.appendChild(link);
            link.click();
            
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            
            toast.add({ 
                severity: 'success', 
                summary: 'Éxito', 
                detail: 'Archivo Excel exportado correctamente', 
                life: 3000 
            });
        } else {
            toast.add({ 
                severity: 'error', 
                summary: 'Error', 
                detail: result.message || 'Error al exportar', 
                life: 3000 
            });
        }
    } catch (error) {
        toast.add({ 
            severity: 'error', 
            summary: 'Error', 
            detail: 'Error al exportar el archivo', 
            life: 3000 
        });
    } finally {
        exporting.value = false;
    }
};

const form = reactive({
    amount: null,
    transaction_date: new Date(),
    type: 'ingreso',
    category: null,
    description: '',
    member_id: null,
});

onMounted(async () => {
    await fetchTransactions();
    await fetchMembersForSelect();
    
    if (route.query.action === 'create_income') {
        openModal('ingreso');
        // Clean query to avoid reopening on refresh
        router.replace({ query: {} });
    }
});

let fetchTimeout = null;
watch(filters, () => {
    clearTimeout(fetchTimeout);
    fetchTimeout = setTimeout(fetchTransactions, 250);
}, { deep: true });

const fetchMembersForSelect = async () => {
    const result = await getMembers({ limit: 1000 }); // Get all for now
    if (result.success) {
        const rawMembers = result.data.data ? result.data.data : result.data;
        membersList.value = rawMembers.map(m => ({
            id: m.id,
            full_name: `${m.first_name} ${m.last_name}`
        }));
    }
};

const formatDateParam = (value) => {
    if (!value) return null;
    const d = value instanceof Date ? value : new Date(value);
    return d.toISOString().split('T')[0];
};

const fetchTransactions = async () => {
    loading.value = true;
    const params = {};
    if (filters.type) params.type = filters.type;
    if (filters.category) params.category = filters.category;
    if (filters.dateFrom) params.date_from = formatDateParam(filters.dateFrom);
    if (filters.dateTo) params.date_to = formatDateParam(filters.dateTo);
    if (filters.search) params.search = filters.search;

    const result = await getTransactions(params);
    if (result.success) {
        transactions.value = result.data.data ? result.data.data : result.data;
    }
    loading.value = false;
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(amount);
};

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

const formatDate = (dateString) => {
    if (!dateString) return '';
    const d = new Date(dateString);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
};

const openModal = (type) => {
    const normalizedType = type === 'income' ? 'ingreso' : type === 'expense' ? 'egreso' : type;
    modalType.value = normalizedType;
    form.type = normalizedType;
    form.amount = null;
    form.transaction_date = new Date();
    form.category = null;
    form.description = '';
    form.member_id = null;
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
};

const saveTransaction = async () => {
    saving.value = true;
    const dataToSend = { ...form };
    
     if (dataToSend.transaction_date instanceof Date) {
        dataToSend.transaction_date = dataToSend.transaction_date.toISOString().split('T')[0];
    }
    
    if (!dataToSend.amount || !dataToSend.category) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'Monto y categoría son obligatorios', life: 3000 });
        saving.value = false;
        return;
    }

    const result = await createTransaction(dataToSend);

    if (result.success) {
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Transacción registrada correctamente', life: 3000 });
        await fetchTransactions();
        closeModal();
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'Error al guardar', life: 3000 });
    }
    saving.value = false;
};

const confirmDelete = async (transaction) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            loading.value = true;
            const res = await deleteTransaction(transaction.id);
            loading.value = false;

            if (res.success) {
                toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Transacción eliminada', life: 3000 });
                await fetchTransactions();
            } else {
                toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'Error al eliminar', life: 3000 });
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
</style>
