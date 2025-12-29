<template>
    <Dialog v-model:visible="visible" modal header="Enviar Petición de Oración" :style="{ width: '500px' }" @hide="resetForm">
        <div class="space-y-4 py-4">
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Tu Nombre (Opcional)</label>
                <InputText v-model="form.name" class="w-full" placeholder="Déjalo vacío para enviar anónimamente" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700 flex items-center gap-2">
                    Petición <span class="text-red-500">*</span>
                </label>
                <Textarea v-model="form.request" rows="5" class="w-full" placeholder="Comparte tu necesidad de oración..." />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Contacto (Opcional)</label>
                <InputText v-model="form.contact_info" class="w-full" placeholder="Email o teléfono para seguimiento" />
            </div>

            <div class="flex items-center gap-2">
                <Checkbox v-model="form.is_anonymous" :binary="true" inputId="anonymous" />
                <label for="anonymous" class="text-sm text-slate-600">Enviar de forma anónima</label>
            </div>
        </div>

        <template #footer>
            <Button label="Cancelar" text @click="visible = false" />
            <Button label="Enviar Petición" icon="pi pi-send" @click="submitPrayer" :loading="loading" />
        </template>
    </Dialog>
</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Checkbox from 'primevue/checkbox';
import { useToast } from 'primevue/usetoast';
import api from '../services/api';

const props = defineProps({
    show: Boolean
});

const emit = defineEmits(['update:show']);

const toast = useToast();
const visible = ref(false);
const loading = ref(false);

const form = reactive({
    name: '',
    request: '',
    contact_info: '',
    is_anonymous: false
});

watch(() => props.show, (newVal) => {
    visible.value = newVal;
});

watch(visible, (newVal) => {
    emit('update:show', newVal);
});

const resetForm = () => {
    form.name = '';
    form.request = '';
    form.contact_info = '';
    form.is_anonymous = false;
};

const submitPrayer = async () => {
    if (!form.request.trim()) {
        toast.add({ severity: 'warn', summary: 'Atención', detail: 'Por favor escribe tu petición', life: 3000 });
        return;
    }

    loading.value = true;
    try {
        await api.post('/prayer-requests', {
            name: form.is_anonymous ? null : form.name,
            request: form.request,
            contact_info: form.contact_info,
            is_anonymous: form.is_anonymous
        });

        toast.add({ 
            severity: 'success', 
            summary: 'Petición Enviada', 
            detail: 'Estaremos orando por ti. ¡Dios te bendiga!', 
            life: 5000 
        });

        visible.value = false;
        resetForm();
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo enviar la petición', life: 3000 });
    } finally {
        loading.value = false;
    }
};
</script>
