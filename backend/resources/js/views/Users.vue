<template>
    <div class="max-w-6xl mx-auto space-y-4">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Usuarios y Permisos</h1>
                <p class="text-xs text-slate-500">
                    Administración de acceso al sistema y roles de usuario.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <Button label="Nuevo usuario" icon="pi pi-user-plus" class="!text-xs" @click="openModal" />
            </div>
        </header>

        <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs space-y-3">
            <DataTable :value="users" size="small" dataKey="id" responsiveLayout="scroll" :loading="loading">
                <Column field="name" header="Usuario">
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                {{ getInitials(slotProps.data.name) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ slotProps.data.name }}</p>
                                <p class="text-[10px] text-slate-500">{{ slotProps.data.email }}</p>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column field="role" header="Rol">
                    <template #body="slotProps">
                        <span class="px-2 py-0.5 rounded-full text-[10px]"
                            :class="getRoleBadgeClass(slotProps.data.role)">
                            {{ slotProps.data.role }}
                        </span>
                    </template>
                </Column>
                <Column field="is_active" header="Estado">
                    <template #body="slotProps">
                         <span class="px-2 py-0.5 rounded-full text-[10px]"
                            :class="slotProps.data.is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'">
                            {{ slotProps.data.is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </template>
                </Column>
                <Column field="last_login_at" header="Último acceso">
                    <template #body="slotProps">
                        <span class="text-slate-500">{{ formatDateTime(slotProps.data.last_login_at) }}</span>
                    </template>
                </Column>
                <Column header="Acciones">
                     <template #body="slotProps">
                        <div class="flex gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" size="small" @click="editUser(slotProps.data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDelete(slotProps.data)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </section>

        <!-- Modal de Creación/Edición -->
        <Dialog v-model:visible="modalVisible" :header="isEditing ? 'Editar Usuario' : 'Nuevo Usuario'" modal class="w-full max-w-sm">
            <div class="space-y-4 pt-2">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Nombre completo *</label>
                    <InputText v-model="form.name" class="w-full" size="small" placeholder="Ej: Juan Pérez" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Email (nombre de usuario) *</label>
                    <InputText v-model="form.email" class="w-full" size="small" placeholder="ejemplo@iglesia.com" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Rol del sistema *</label>
                    <Dropdown v-model="form.role" :options="roleOptions" optionLabel="label" optionValue="value" class="w-full p-input-sm" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-600">Contraseña {{ isEditing ? '(dejar en blanco para no cambiar)' : '*' }}</label>
                    <Password v-model="form.password" class="w-full" inputClass="w-full" toggleMask :feedback="false" size="small" />
                </div>
                <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                    <label class="text-xs font-medium text-slate-600">Estado de la cuenta</label>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] uppercase font-bold" :class="form.is_active ? 'text-emerald-600' : 'text-slate-400'">
                            {{ form.is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <InputSwitch v-model="form.is_active" />
                    </div>
                </div>
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button label="Cancelar" icon="pi pi-times" @click="closeModal" text severity="secondary" class="!text-xs" />
                    <Button label="Guardar Usuario" icon="pi pi-check" @click="saveUser" :loading="saving" class="!text-xs" />
                </div>
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import InputSwitch from 'primevue/inputswitch';
import Password from 'primevue/password';
import { useToast } from 'primevue/usetoast';
import Swal from 'sweetalert2';
import { useUsers } from '../services/users';

const toast = useToast();
const { getUsers, createUser, updateUser, deleteUser } = useUsers();

const users = ref([]);
const loading = ref(true);
const modalVisible = ref(false);
const isEditing = ref(false);
const saving = ref(false);

const roleOptions = [
    { label: 'Administrador', value: 'Administrador' },
    { label: 'Secretaría', value: 'Secretaría' },
    { label: 'Tesorería', value: 'Tesorería' },
    { label: 'Usuario', value: 'Usuario' },
];

const form = reactive({
    id: null,
    name: '',
    email: '',
    role: 'Usuario',
    password: '',
    is_active: true,
});

const fetchUsers = async () => {
    loading.value = true;
    const result = await getUsers();
    if (result.success) {
        users.value = result.data;
    }
    loading.value = false;
};

onMounted(fetchUsers);

const openModal = () => {
    isEditing.value = false;
    resetForm();
    modalVisible.value = true;
};

const editUser = (user) => {
    isEditing.value = true;
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.role = user.role;
    form.password = '';
    form.is_active = !!user.is_active;
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
    resetForm();
};

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.email = '';
    form.role = 'Usuario';
    form.password = '';
    form.is_active = true;
};

const saveUser = async () => {
    if (!form.name || !form.email || (!form.password && !isEditing.value)) {
        toast.add({ severity: 'warn', summary: 'Campos requeridos', detail: 'Por favor completa los campos obligatorios.', life: 3000 });
        return;
    }

    saving.value = true;
    const payload = { ...form };
    if (isEditing.value && !payload.password) {
        delete payload.password;
    }

    let result;
    if (isEditing.value) {
        result = await updateUser(form.id, payload);
    } else {
        result = await createUser(payload);
    }

    if (result.success) {
        toast.add({ severity: 'success', summary: 'Éxito', detail: `Usuario ${isEditing.value ? 'actualizado' : 'creado'} correctamente.`, life: 3000 });
        await fetchUsers();
        closeModal();
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: result.message || 'No se pudo guardar el usuario.', life: 4000 });
    }
    saving.value = false;
};

const confirmDelete = (user) => {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: `Esta acción removerá el acceso al sistema para ${user.name}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            loading.value = true;
            const res = await deleteUser(user.id);
            if (res.success) {
                toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Usuario eliminado correctamente.', life: 3000 });
                await fetchUsers();
            } else {
                toast.add({ severity: 'error', summary: 'Error', detail: res.message || 'No se pudo eliminar al usuario.', life: 4000 });
            }
            loading.value = false;
        }
    });
};

const getInitials = (name) => {
    if (!name) return 'U';
    const parts = name.split(' ');
    if (parts.length >= 2) return (parts[0].charAt(0) + parts[1].charAt(0)).toUpperCase();
    return name.charAt(0).toUpperCase();
};

const getRoleBadgeClass = (role) => {
    switch (role) {
        case 'Administrador': return 'bg-purple-50 text-purple-700 border border-purple-100';
        case 'Secretaría': return 'bg-blue-50 text-blue-700 border border-blue-100';
        case 'Tesorería': return 'bg-yellow-50 text-yellow-700 border border-yellow-100';
        default: return 'bg-slate-50 text-slate-700 border border-slate-100';
    }
};

const formatDateTime = (dateString) => {
    if (!dateString) return 'Nunca';
    const date = new Date(dateString);
    return date.toLocaleString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>

<style scoped>
:deep(.p-dialog-header) {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
}
:deep(.p-dialog-content) {
    padding: 1rem;
}
:deep(.p-dialog-footer) {
    padding: 1rem;
    border-top: 1px solid #f1f5f9;
}
</style>
