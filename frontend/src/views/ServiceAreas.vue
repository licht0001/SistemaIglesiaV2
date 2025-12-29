<template>
  <div class="max-w-6xl mx-auto space-y-4">
    <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
      <div>
        <h1 class="text-xl font-semibold text-slate-900">Áreas de Servicio</h1>
        <p class="text-xs text-slate-500">Gestión de áreas de servicio y asignación de miembros.</p>
      </div>
      <div class="flex flex-wrap gap-2 text-xs">
        <Button label="Nueva área de servicio" icon="pi pi-plus" class="!text-xs" @click="openAreaModal" />
        <Button label="Gestionar áreas" icon="pi pi-cog" class="!text-xs" severity="secondary" outlined @click="manageAreasModalVisible = true" />
      </div>
    </header>

    <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-center">
        <div class="flex justify-center w-full">
          <InputGroup class="w-full">
            <Button icon="pi pi-search" outlined severity="secondary" class="!text-xs" />
            <InputText v-model="filters.search" placeholder="Buscar área por nombre o descripción" class="w-full !text-xs" />
          </InputGroup>
        </div>
        <div class="flex items-center gap-2 justify-center w-full">
          <label class="text-xs text-slate-600">Mostrar solo activos</label>
          <InputSwitch v-model="filters.activeOnly" @change="refresh" />
        </div>
      </div>
    </section>

    <section class="bg-white border border-slate-200 rounded-xl p-3 text-xs">
      <DataTable :value="areas" size="small" dataKey="id" responsiveLayout="scroll" :loading="loading"
                 sortMode="multiple" removableSort filterDisplay="menu" v-model:filters="columnFilters">
        <Column field="name" header="Área" sortable :showFilterMatchModes="false">
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" placeholder="Buscar..." class="w-full !text-xs" />
          </template>
        </Column>
        <Column field="description" header="Descripción" sortable :showFilterMatchModes="false">
          <template #filter="{ filterModel }">
            <InputText v-model="filterModel.value" placeholder="Buscar..." class="w-full !text-xs" />
          </template>
        </Column>
        <Column field="is_active" header="Activo" sortable :showFilterMatchModes="false" style="width: 100px">
          <template #body="slotProps">
            <InputSwitch v-model="slotProps.data.is_active" @change="toggleActive(slotProps.data)" />
          </template>
        </Column>
        <Column header="Miembros" :exportable="false" style="width: 120px">
          <template #body="slotProps">
            <Button label="Asignar" icon="pi pi-users" text rounded size="small" @click="openAssignModal(slotProps.data)" />
          </template>
        </Column>
        <Column header="Acciones" :exportable="false">
          <template #body="slotProps">
            <Button icon="pi pi-pencil" text rounded severity="secondary" size="small" @click="editArea(slotProps.data)" />
            <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDelete(slotProps.data)" />
          </template>
        </Column>
      </DataTable>
    </section>

    <!-- Modal crear/editar área -->
    <Dialog v-model:visible="areaModalVisible" modal class="w-full max-w-lg">
      <template #header>
        <div class="flex items-center justify-between w-full pr-2">
          <h3 class="text-lg font-semibold">{{ isEditing ? 'Editar área de servicio' : 'Nueva área de servicio' }}</h3>
          <div class="flex items-center gap-2">
            <label class="text-xs font-medium text-slate-600">Activo</label>
            <InputSwitch v-model="form.is_active" />
          </div>
        </div>
      </template>
      <div class="space-y-4">
        <div class="space-y-1">
          <label class="text-xs font-medium text-slate-600">Nombre del área de servicio *</label>
          <InputText v-model="form.name" class="w-full" size="small" />
        </div>
        <div class="space-y-1">
          <label class="text-xs font-medium text-slate-600">Orden</label>
          <InputNumber v-model="form.order" :min="0" :max="999" class="w-full" />
        </div>
        <div class="space-y-1">
          <label class="text-xs font-medium text-slate-600">Descripción</label>
          <InputText v-model="form.description" class="w-full" size="small" />
        </div>
        <div class="space-y-1">
          <label class="text-xs font-medium text-slate-600">Miembros asignados</label>
          <MultiSelect v-model="form.selectedMembers" :options="membersOptions" optionLabel="full_name" optionValue="id" display="chip" class="w-full" placeholder="Selecciona miembros" />
        </div>
        <div v-if="isEditing && form.membersList !== undefined" class="pt-2 border-t border-slate-200 space-y-2">
          <p class="text-xs text-slate-600 font-medium">
            <i class="pi pi-users mr-1"></i>
            <span>{{ form.membersList.length }} {{ form.membersList.length === 1 ? 'miembro asignado' : 'miembros asignados' }}</span>
          </p>
          <div v-if="form.membersList.length > 0" class="space-y-1 max-h-40 overflow-y-auto">
            <div v-for="member in form.membersList" :key="member.id" class="flex items-center justify-between bg-slate-50 px-2 py-1 rounded text-xs">
              <span class="text-slate-700">{{ member.full_name }}</span>
              <Button icon="pi pi-times" text rounded size="small" severity="danger" class="!w-6 !h-6" @click="removeMemberFromArea(member.id)" />
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button label="Cancelar" icon="pi pi-times" @click="closeAreaModal" text severity="secondary" />
        <Button label="Guardar" icon="pi pi-check" @click="saveArea" :loading="saving" />
      </template>
    </Dialog>

    <!-- Modal asignar miembros -->
    <Dialog v-model:visible="assignModalVisible" :header="'Asignar miembros a ' + (currentArea?.name || '')" modal class="w-full max-w-xl">
      <div class="space-y-3">
        <MultiSelect v-model="selectedMembers" :options="membersOptions" optionLabel="full_name" optionValue="id" display="chip"
                     class="w-full" placeholder="Selecciona miembros" />
      </div>
      <template #footer>
        <Button label="Cerrar" icon="pi pi-times" @click="closeAssignModal" text severity="secondary" />
        <Button label="Guardar" icon="pi pi-check" @click="saveAssignments" :loading="assignSaving" />
      </template>
    </Dialog>

    <!-- Modal Gestionar Áreas -->
    <Dialog v-model:visible="manageAreasModalVisible" header="Gestionar áreas de servicio" modal class="w-full max-w-2xl">
      <div class="space-y-4">
        <div class="flex gap-2">
          <InputText v-model="newAreaName" placeholder="Nombre del área" class="flex-1 !text-xs" size="small" />
          <Button label="Añadir" icon="pi pi-plus" @click="addNewArea" class="!text-xs" size="small" />
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto">
          <div v-for="area in allAreas" :key="area.id" class="grid grid-cols-4 gap-2 items-center p-2 bg-slate-50 rounded">
            <InputText v-model="area.name" @blur="updateAreaName(area)" class="!text-xs w-full" size="small" />
            <div class="flex flex-col items-center gap-1">
              <label class="text-xs text-slate-600">Activo</label>
              <InputSwitch v-model="area.is_active" @change="toggleAreaActive(area)" />
            </div>
            <div class="flex items-center gap-1">
              <label class="text-xs text-slate-600">Orden</label>
              <InputNumber v-model="area.order" :min="0" :max="99" @blur="updateAreaOrder(area)" class="w-10" size="small" />
            </div>
            <div class="flex justify-end">
              <Button icon="pi pi-trash" text rounded severity="danger" size="small" @click="confirmDeleteArea(area)" />
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button label="Cerrar" icon="pi pi-times" @click="manageAreasModalVisible = false" text severity="secondary" />
      </template>
    </Dialog>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputGroup from 'primevue/inputgroup';
import InputSwitch from 'primevue/inputswitch';
import InputNumber from 'primevue/inputnumber';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import MultiSelect from 'primevue/multiselect';
import { useToast } from 'primevue/usetoast';
import Swal from 'sweetalert2';
import { useMinistries } from '../services/ministries';
import { useMembers } from '../services/members';

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
const { getMinistries, createMinistry, updateMinistry, deleteMinistry, syncMembers, detachMember } = useMinistries();
const { getMembers } = useMembers();

const filters = reactive({
  search: '',
  activeOnly: true,
});

const columnFilters = ref({
  name: { value: null, matchMode: 'contains' },
  description: { value: null, matchMode: 'contains' },
});

const areas = ref([]);
const loading = ref(true);
const areaModalVisible = ref(false);
const isEditing = ref(false);
const saving = ref(false);

const form = reactive({ id: null, name: '', description: '', is_active: true, order: 0, selectedMembers: [] });

const assignModalVisible = ref(false);
const currentArea = ref(null);
const membersOptions = ref([]);
const selectedMembers = ref([]);
const assignSaving = ref(false);

const manageAreasModalVisible = ref(false);
const allAreas = ref([]);
const newAreaName = ref('');
const newAreaSlug = ref('');

watch(newAreaName, (val) => {
  newAreaSlug.value = slugify(val);
});

const refresh = async () => {
  loading.value = true;
  const res = await getMinistries({ is_active: filters.activeOnly ? 1 : 0 });
  if (res.success) {
    let list = res.data;
    if (filters.search) {
      const s = filters.search.toLowerCase();
      list = list.filter(x => (x.name || '').toLowerCase().includes(s) || (x.description || '').toLowerCase().includes(s));
    }
    areas.value = list;
  }
  loading.value = false;
};

onMounted(async () => {
  await refresh();
  const mres = await getMembers();
  if (mres.success) {
    membersOptions.value = (Array.isArray(mres.data?.data) ? mres.data.data : mres.data).map(m => ({ id: m.id, full_name: `${m.first_name || ''} ${m.last_name || ''}`.trim() }));
  }
});

let t = null;
watch(filters, () => { clearTimeout(t); t = setTimeout(refresh, 250); }, { deep: true });

const openAreaModal = () => { isEditing.value = false; resetForm(); areaModalVisible.value = true; };
const editArea = (area) => { 
  isEditing.value = true; 
  const membersList = (area.members || []).map(m => ({ id: m.id, full_name: `${m.first_name || ''} ${m.last_name || ''}`.trim() || 'Sin nombre' }));
  Object.assign(form, { id: area.id, name: area.name, description: area.description, is_active: !!area.is_active, order: area.order || 0, membersList }); 
  areaModalVisible.value = true; 
};
const closeAreaModal = () => { areaModalVisible.value = false; resetForm(); };
const resetForm = () => { Object.assign(form, { id: null, name: '', description: '', is_active: true, order: 0, membersList: undefined }); };

const saveArea = async () => {
  saving.value = true;
  if (!form.name) { toast.add({ severity: 'warn', summary: 'Atención', detail: 'Nombre es obligatorio', life: 2500 }); saving.value = false; return; }
  let res;
  if (isEditing.value) {
    res = await updateMinistry(form.id, form);
    if (res.success && Array.isArray(form.selectedMembers)) {
      await syncMembers(form.id, form.selectedMembers.map(id => ({ id })));
    }
  } else {
    res = await createMinistry(form);
    if (res.success && Array.isArray(form.selectedMembers) && res.data?.id) {
      await syncMembers(res.data.id, form.selectedMembers.map(id => ({ id })));
    }
  }
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); saving.value = false; return; }
  toast.add({ severity: 'success', summary: 'Éxito', detail: isEditing.value ? 'Área actualizada' : 'Área creada', life: 2500 });
  await refresh(); closeAreaModal(); saving.value = false;
};

const toggleActive = async (area) => {
  const res = await updateMinistry(area.id, { is_active: !!area.is_active });
  if (!res.success) toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 });
  else await refresh();
};

const confirmDelete = (area) => {
  Swal.fire({ title: '¿Eliminar área?', text: `Se eliminará "${area.name}"`, icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b', confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar' })
    .then(async (r) => { if (r.isConfirmed) { const d = await deleteMinistry(area.id); if (d.success) { toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Área eliminada', life: 2500 }); await refresh(); } else { toast.add({ severity: 'error', summary: 'Error', detail: d.message, life: 3000 }); } } });
};

const removeMemberFromArea = async (memberId) => {
  if (!form.id) return;
  const res = await detachMember(form.id, memberId);
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); return; }
  toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Miembro eliminado del área', life: 2500 });
  form.membersList = form.membersList.filter(m => m.id !== memberId);
  await refresh();
};

const openAssignModal = (area) => {
  currentArea.value = area;
  selectedMembers.value = (area.members || []).map(m => m.id);
  assignModalVisible.value = true;
};
const closeAssignModal = () => { assignModalVisible.value = false; currentArea.value = null; selectedMembers.value = []; };
const saveAssignments = async () => {
  assignSaving.value = true;
  const payload = selectedMembers.value.map(id => ({ id }));
  const res = await syncMembers(currentArea.value.id, payload);
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); assignSaving.value = false; return; }
  toast.add({ severity: 'success', summary: 'Asignado', detail: 'Miembros asignados', life: 2500 });
  await refresh(); closeAssignModal(); assignSaving.value = false;
};

const loadAllAreas = async () => {
  const res = await getMinistries(false);
  if (res.success) allAreas.value = (Array.isArray(res.data?.data) ? res.data.data : res.data) || [];
};

const addNewArea = async () => {
  if (!newAreaName.value.trim()) { toast.add({ severity: 'warn', summary: 'Atención', detail: 'Nombre es obligatorio', life: 2500 }); return; }
  const generatedSlug = newAreaSlug.value || slugify(newAreaName.value);
  const payload = { name: newAreaName.value.trim(), slug: generatedSlug || null, is_active: true, order: 0 };
  const res = await createMinistry(payload);
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); return; }
  toast.add({ severity: 'success', summary: 'Éxito', detail: 'Área creada', life: 2500 });
  newAreaName.value = ''; newAreaSlug.value = ''; await loadAllAreas(); await refresh();
};

const toggleAreaActive = async (area) => {
  const res = await updateMinistry(area.id, { is_active: !!area.is_active });
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); await loadAllAreas(); }
};

const updateAreaOrder = async (area) => {
  const res = await updateMinistry(area.id, { order: Number(area.order) || 0 });
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); await loadAllAreas(); }
};

const updateAreaName = async (area) => {
  if (!area.name || !area.name.trim()) { toast.add({ severity: 'warn', summary: 'Atención', detail: 'Nombre es obligatorio', life: 2500 }); await loadAllAreas(); return; }
  const payload = { name: area.name.trim() };
  if (!area.slug) {
    payload.slug = slugify(area.name);
    area.slug = payload.slug;
  }
  const res = await updateMinistry(area.id, payload);
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); await loadAllAreas(); }
  else { toast.add({ severity: 'success', summary: 'Éxito', detail: 'Nombre actualizado', life: 2000 }); await refresh(); }
};

const updateAreaSlug = async (area) => {
  const cleanSlug = slugify(area.slug);
  area.slug = cleanSlug;
  const res = await updateMinistry(area.id, { slug: cleanSlug || null });
  if (!res.success) { toast.add({ severity: 'error', summary: 'Error', detail: res.message, life: 3000 }); await loadAllAreas(); }
  else { toast.add({ severity: 'success', summary: 'Éxito', detail: 'Slug actualizado', life: 2000 }); }
};

const confirmDeleteArea = (area) => {
  Swal.fire({ title: '¿Eliminar área?', text: `Se eliminará "${area.name}"`, icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b', confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar' })
    .then(async (r) => { if (r.isConfirmed) { const d = await deleteMinistry(area.id); if (d.success) { toast.add({ severity: 'success', summary: 'Eliminado', detail: 'Área eliminada', life: 2500 }); await loadAllAreas(); await refresh(); } else { toast.add({ severity: 'error', summary: 'Error', detail: d.message, life: 3000 }); } } });
};

watch(manageAreasModalVisible, (visible) => { if (visible) loadAllAreas(); });
</script>
