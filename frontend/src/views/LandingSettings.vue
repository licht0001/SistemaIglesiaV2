<template>
    <div class="max-w-5xl mx-auto space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Administración de Landing Page</h1>
                <p class="text-sm text-slate-500">Configura el contenido visual que ven los visitantes públicos.</p>
            </div>
            <div class="flex gap-2">
                <Button label="Guardar Cambios" icon="pi pi-check" @click="handleSave" :loading="saving" />
                <Button label="Ver Sitio Público" icon="pi pi-external-link" text severity="secondary" @click="viewPublicSite" />
            </div>
        </header>

        <main class="grid lg:grid-cols-3 gap-6">
            <!-- Sidebar Navigation for Settings -->
            <div class="lg:col-span-1 space-y-2">
                <div @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-image"></i>
                    <span class="font-medium text-sm">Hero Principial</span>
                </div>
                <div @click="activeTab = 'carousel'" :class="activeTab === 'carousel' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-images"></i>
                    <span class="font-medium text-sm">Carrusel de Fotos</span>
                </div>
                <div @click="activeTab = 'video'" :class="activeTab === 'video' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-youtube"></i>
                    <span class="font-medium text-sm">Video de YouTube</span>
                </div>
                <div @click="activeTab = 'schedules'" :class="activeTab === 'schedules' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-calendar-plus"></i>
                    <span class="font-medium text-sm">Horarios de Culto</span>
                </div>
                <div @click="activeTab = 'community'" :class="activeTab === 'community' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-th-large"></i>
                    <span class="font-medium text-sm">Comunidad (Bento)</span>
                </div>
                <div @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-compass"></i>
                    <span class="font-medium text-sm">Misión y Visión</span>
                </div>
                <div @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white hover:bg-slate-50 text-slate-600'" class="p-3 rounded-xl border border-slate-200 cursor-pointer flex items-center gap-3 transition-all">
                    <i class="pi pi-map-marker"></i>
                    <span class="font-medium text-sm">Información de Contacto</span>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl shadow-sm p-6 overflow-hidden min-h-[500px]">
                
                <!-- 1. HERO -->
                <div v-if="activeTab === 'hero'" class="space-y-4 animate-fade-in">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Sección Hero (Bienvenida)</h3>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase">Título Principal</label>
                        <InputText v-model="config.hero.title" class="w-full" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase">Subtítulo o Descripción</label>
                        <Textarea v-model="config.hero.subtitle" class="w-full" rows="3" autoResize />
                    </div>
                    <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg flex gap-3 text-xs text-blue-700">
                        <i class="pi pi-info-circle mt-0.5"></i>
                        <p>Esta es la primera sección que ven los usuarios al entrar al sitio.</p>
                    </div>
                </div>

                <!-- 2. CAROUSEL -->
                <div v-if="activeTab === 'carousel'" class="space-y-6 animate-fade-in">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h3 class="font-semibold text-slate-800">Galería del Carrusel</h3>
                        <Button label="Añadir Foto" icon="pi pi-plus" size="small" text @click="addCarouselItem" />
                    </div>
                    
                    <div v-if="config.carousel.length === 0" class="text-center py-10 text-slate-400">
                        <i class="pi pi-images text-3xl mb-2"></i>
                        <p>No hay fotos en el carrusel aún.</p>
                    </div>

                    <div class="space-y-4">
                        <div v-for="(item, index) in config.carousel" :key="index" class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 space-y-3 relative group">
                            <Button icon="pi pi-trash" severity="danger" rounded text class="absolute top-2 right-2 !w-8 !h-8 opacity-0 group-hover:opacity-100 transition-opacity" @click="removeCarouselItem(index)" />
                            
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <div class="aspect-video bg-slate-200 rounded-lg overflow-hidden border border-slate-300 flex items-center justify-center">
                                        <img v-if="item.url" :src="getImageUrl(item.url)" class="w-full h-full object-cover" />
                                        <i v-else class="pi pi-image text-slate-400 text-2xl"></i>
                                    </div>
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">URL de Imagen</label>
                                        <InputText v-model="item.url" class="w-full !text-xs" placeholder="https://..." />
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-400 uppercase">Título</label>
                                            <InputText v-model="item.title" class="w-full !text-xs" />
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-400 uppercase">Resumen</label>
                                            <InputText v-model="item.subtitle" class="w-full !text-xs" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. VIDEO -->
                <div v-if="activeTab === 'video'" class="space-y-4 animate-fade-in">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Video Destacado</h3>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase">Título de la sección</label>
                        <InputText v-model="config.video.title" class="w-full" placeholder="Ej: Nuestros Mensajes" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase">URL de YouTube</label>
                        <InputText v-model="config.video.youtubeUrl" class="w-full" placeholder="https://www.youtube.com/watch?v=..." />
                    </div>

                    <div v-if="getYoutubeId(config.video.youtubeUrl)" class="aspect-video bg-black rounded-xl overflow-hidden shadow-lg mt-4 border border-slate-200">
                        <iframe :src="'https://www.youtube.com/embed/' + getYoutubeId(config.video.youtubeUrl)" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- 4. TESTIMONIALS (Consolidado) -->
                <!-- 5. SCHEDULES (Nuevo) -->
                <div v-if="activeTab === 'schedules'" class="space-y-6 animate-fade-in">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h3 class="font-semibold text-slate-800">Horarios de Servicios</h3>
                        <Button label="Añadir Horario" icon="pi pi-plus" size="small" text @click="addSchedule" />
                    </div>
                    <div class="space-y-3">
                        <div v-for="(s, index) in config.schedules" :key="index" class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                            <div class="grid grid-cols-12 gap-3 items-center">
                                <div class="col-span-3">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Día</label>
                                    <InputText v-model="s.day" placeholder="Ej: Domingo" class="w-full !text-xs" />
                                </div>
                                <div class="col-span-3">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Hora</label>
                                    <InputText v-model="s.time" placeholder="Ej: 10:00 AM" class="w-full !text-xs" />
                                </div>
                                <div class="col-span-5">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Servicio</label>
                                    <InputText v-model="s.title" placeholder="Título" class="w-full !text-xs" />
                                </div>
                                <div class="col-span-1 text-center pt-4">
                                    <Button icon="pi pi-trash" severity="danger" text @click="removeSchedule(index)" />
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2">
                                        <InputSwitch v-model="s.showImage" size="small" />
                                        <span class="text-[11px] font-medium text-slate-600">Usar Imagen</span>
                                    </div>
                                    <div v-if="s.showImage" class="flex-1 min-w-[250px]">
                                        <div class="p-inputgroup !p-0">
                                            <span class="p-inputgroup-addon bg-white border-slate-200 h-8">
                                                <i class="pi pi-image text-[10px]"></i>
                                            </span>
                                            <InputText v-model="s.imageUrl" placeholder="URL de la imagen..." class="!text-xs h-8" />
                                        </div>
                                    </div>
                                </div>
                                <div v-if="s.showImage && s.imageUrl" class="h-8 w-12 rounded border border-slate-300 overflow-hidden bg-white">
                                    <img :src="getImageUrl(s.imageUrl)" class="w-full h-full object-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. COMMUNITY / BENTO (Nuevo) -->
                <div v-if="activeTab === 'community'" class="space-y-6 animate-fade-in">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Módulos de Comunidad (Bento Grid)</h3>
                    <div class="grid gap-4">
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div>
                                <p class="font-medium text-sm text-slate-700">Peticiones de Oración</p>
                                <p class="text-[11px] text-slate-500">Muestra el acceso al formulario de oración.</p>
                            </div>
                            <InputSwitch v-model="config.bento.showPrayer" />
                        </div>
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div>
                                <p class="font-medium text-sm text-slate-700">Donaciones / Diezmos</p>
                                <p class="text-[11px] text-slate-500">Habilita la información de cuentas bancarias.</p>
                            </div>
                            <InputSwitch v-model="config.bento.showDonations" />
                        </div>
                        <div v-if="config.bento.showDonations" class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Información de Transferencia</label>
                            <Textarea v-model="config.bento.donationsInfo" class="w-full !text-xs" rows="3" placeholder="Ej: Cuenta Banco Unión: 1234567..." />
                        </div>
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div>
                                <p class="font-medium text-sm text-slate-700">Cursos y Discipulados</p>
                                <p class="text-[11px] text-slate-500">Muestra la sección de crecimiento bíblico.</p>
                            </div>
                            <InputSwitch v-model="config.bento.showCourses" />
                        </div>
                    </div>
                </div>

                <!-- 7. INFO / WHAT TO EXPECT (Nuevo) -->
                <div v-if="activeTab === 'info'" class="space-y-6 animate-fade-in">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Identidad e Información</h3>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Misión</label>
                            <Textarea v-model="config.info.whatToExpect" class="w-full" rows="4" placeholder="Describe la misión y propósito fundamental de la iglesia." />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Visión</label>
                            <Textarea v-model="config.info.socialWork" class="w-full" rows="4" placeholder="Describe la visión a futuro y el impacto deseado." />
                        </div>
                    </div>
                </div>

                <!-- 8. TESTIMONIALS (Movido para orden) -->
                <div v-if="activeTab === 'testimonials'" class="space-y-6 animate-fade-in">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h3 class="font-semibold text-slate-800">Testimonios y Reseñas</h3>
                        <Button label="Añadir Testimonio" icon="pi pi-plus" size="small" text @click="addTestimonial" />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div v-for="(t, index) in config.testimonials" :key="index" class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 space-y-3 relative group">
                            <Button icon="pi pi-trash" severity="danger" rounded text class="absolute top-2 right-2 !w-8 !h-8" @click="removeTestimonial(index)" />
                            
                            <div class="space-y-2 pt-2">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Nombre</label>
                                        <InputText v-model="t.name" class="w-full !text-xs" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Cargo/Rol</label>
                                        <InputText v-model="t.role" class="w-full !text-xs" />
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Contenido</label>
                                    <Textarea v-model="t.content" class="w-full !text-xs" rows="3" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. CONTACT -->
                <div v-if="activeTab === 'contact'" class="space-y-4 animate-fade-in">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Redes Sociales e Información</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <!-- WhatsApp -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">
                                            <i class="pi pi-whatsapp text-emerald-500"></i> WhatsApp
                                        </label>
                                        <InputText v-model="config.contact.whatsapp" class="w-full" placeholder="Ej: 59178945612" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2 text-blue-600">
                                            <i class="pi pi-comment"></i> Mensaje W.A.
                                        </label>
                                        <InputText v-model="config.contact.whatsappMessage" class="w-full" placeholder="Ej: Hola..." />
                                    </div>
                                </div>
                                
                                <div class="border-t border-slate-100 my-4"></div>

                                <!-- Facebook -->
                                <div class="flex items-end gap-3">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">
                                            <i class="pi pi-facebook text-blue-600"></i> Facebook
                                        </label>
                                        <InputText v-model="config.contact.facebook" class="w-full" placeholder="https://facebook.com/..." />
                                    </div>
                                    <div class="flex flex-col items-center gap-1 pb-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Mostrar</span>
                                        <InputSwitch v-model="config.contact.showFacebook" />
                                    </div>
                                </div>

                                <!-- Instagram -->
                                <div class="flex items-end gap-3">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">
                                            <i class="pi pi-instagram text-pink-500"></i> Instagram
                                        </label>
                                        <InputText v-model="config.contact.instagram" class="w-full" placeholder="https://instagram.com/..." />
                                    </div>
                                    <div class="flex flex-col items-center gap-1 pb-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Mostrar</span>
                                        <InputSwitch v-model="config.contact.showInstagram" />
                                    </div>
                                </div>

                                <!-- YouTube -->
                                <div class="flex items-end gap-3">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">
                                            <i class="pi pi-youtube text-red-600"></i> YouTube Channel
                                        </label>
                                        <InputText v-model="config.contact.youtube" class="w-full" placeholder="https://youtube.com/@..." />
                                    </div>
                                    <div class="flex flex-col items-center gap-1 pb-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Mostrar</span>
                                        <InputSwitch v-model="config.contact.showYoutube" />
                                    </div>
                                </div>

                                <!-- TikTok -->
                                <div class="flex items-end gap-3">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-tiktok text-black" viewBox="0 0 16 16">
                                                <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                                            </svg> TikTok
                                        </label>
                                        <InputText v-model="config.contact.tiktok" class="w-full" placeholder="https://tiktok.com/@..." />
                                    </div>
                                    <div class="flex flex-col items-center gap-1 pb-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Mostrar</span>
                                        <InputSwitch v-model="config.contact.showTiktok" />
                                    </div>
                                </div>
                            </div>
                        <div class="space-y-4">
                           <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                               <div>
                                   <p class="font-medium text-sm">Mostrar Mapa</p>
                                   <p class="text-xs text-slate-500">Habilita el widget de Google Maps</p>
                               </div>
                               <InputSwitch v-model="config.contact.showMap" />
                           </div>

                           <div v-if="config.contact.showMap" class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase">URL de Inserción (Google Maps Embed)</label>
                                <InputText v-model="config.contact.googleMapsEmbedUrl" class="w-full !text-xs" placeholder="Pega el src del iframe de Google Maps..." />
                                <div class="mt-2 aspect-video rounded-xl border border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center">
                                    <iframe v-if="config.contact.googleMapsEmbedUrl" :src="config.contact.googleMapsEmbedUrl" class="w-full h-full" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    <i v-else class="pi pi-map text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-[10px] text-slate-500 italic mt-1">Sugerencia: En Google Maps, ve a 'Compartir' -> 'Incorporar un mapa' y copia el <b>src</b> dentro de las comillas.</p>
                           </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import InputSwitch from 'primevue/inputswitch';
import { useToast } from 'primevue/usetoast';
import { fetchLandingSettings, updateLandingSettings } from '../services/settings';

const toast = useToast();
const activeTab = ref('hero');
const saving = ref(false);
const loading = ref(true);

const config = reactive({
    hero: { title: '', subtitle: '', backgroundImage: null },
    carousel: [],
    video: { youtubeUrl: '', title: '' },
    testimonials: [],
    schedules: [],
    info: { whatToExpect: '', socialWork: '' },
    bento: { showPrayer: true, showDonations: true, showCourses: true, donationsInfo: '' },
    contact: { showMap: true, whatsapp: '', whatsappMessage: '', facebook: '', showFacebook: true, instagram: '', showInstagram: true, youtube: '', showYoutube: false, tiktok: '', showTiktok: false, googleMapsEmbedUrl: '' }
});

const loadSettings = async () => {
    try {
        const data = await fetchLandingSettings();
        Object.assign(config, data);
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo cargar la configuración' });
    } finally {
        loading.value = false;
    }
};

onMounted(loadSettings);

const handleSave = async () => {
    saving.value = true;
    try {
        await updateLandingSettings(config);
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Cambios guardados correctamente', life: 3000 });
    } catch (e) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Error al guardar los cambios' });
    } finally {
        saving.value = false;
    }
};

const viewPublicSite = () => {
    window.open('/', '_blank');
};

const addCarouselItem = () => {
    config.carousel.push({ url: '', title: '', subtitle: '' });
};

const removeCarouselItem = (index) => {
    config.carousel.splice(index, 1);
};

const addTestimonial = () => {
    config.testimonials.push({ name: '', role: '', content: '' });
};

const removeTestimonial = (index) => {
    config.testimonials.splice(index, 1);
};

const addSchedule = () => {
    config.schedules.push({ day: '', time: '', title: '', showImage: false, imageUrl: '' });
};

const removeSchedule = (index) => {
    config.schedules.splice(index, 1);
};

const getYoutubeId = (url) => {
    if (!url) return null;
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
};

const getImageUrl = (url) => {
    if (!url) return '';
    if (url.startsWith('http') || url.startsWith('data:')) return url;
    
    // Limpieza de rutas comunes incorrectas
    let cleanUrl = url.replace(/\\/g, '/'); // Convert backslashes to slashes
    cleanUrl = cleanUrl.replace('backend/public/', '');
    cleanUrl = cleanUrl.replace('backend//public/', '');
    
    // Asegurar que empiece con /
    if (!cleanUrl.startsWith('/')) {
        cleanUrl = '/' + cleanUrl;
    }

    // Retorna URL absoluta del backend
    return `http://127.0.0.1:8000${cleanUrl}`;
};
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.4s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
