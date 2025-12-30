<template>
    <div class="min-h-screen flex flex-col bg-slate-50 text-slate-800">
        <!-- Navbar -->
        <header class="fixed top-0 inset-x-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold">
                        <span>SI</span>
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold text-emerald-700">Sistema Iglesia</p>
                        <p class="text-xs text-slate-500">Gestión integral de tu congregación</p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a @click.prevent="scrollToSection('about')" href="#about" class="hover:text-emerald-700 transition-colors cursor-pointer font-medium">Sobre el sistema</a>
                    <a @click.prevent="scrollToSection('modules')" href="#modules" class="hover:text-emerald-700 transition-colors cursor-pointer font-medium">Módulos</a>
                    <a @click.prevent="scrollToSection('features')" href="#features" class="hover:text-emerald-700 transition-colors cursor-pointer font-medium">Beneficios</a>
                    <a @click.prevent="scrollToSection('contact')" href="#contact" class="hover:text-emerald-700 transition-colors cursor-pointer font-medium">Contacto</a>
                </nav>

                <div class="hidden md:flex items-center gap-3">
                    <Button label="Prueba gratis" severity="secondary" outlined class="!text-sm" />
                    <RouterLink to="/login">
                        <Button label="Iniciar sesión" class="!text-sm" />
                    </RouterLink>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <main class="flex-1 pt-20">
            <section class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-emerald-800 text-white relative overflow-hidden">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid md:grid-cols-2 gap-10 items-center relative z-10">
                    <div class="animate-fade-in-left">
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-100 mb-3">
                            Sistema de gestión para iglesias
                        </p>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-4">
                            {{ config.hero.title }}
                        </h1>
                        <p class="text-emerald-50 text-sm sm:text-base mb-6">
                            {{ config.hero.subtitle }}
                        </p>
                        <div class="flex flex-wrap gap-3 mb-6">
                            <Button label="Comenzar demo" icon="pi pi-play" class="!bg-white !text-emerald-700 !border-0 !text-sm shadow-sm" />
                            <Button @click="scrollToSection('about')" label="Ver funcionalidades" icon="pi pi-arrow-down" severity="secondary" outlined class="!border-emerald-200 !text-emerald-50 !text-sm" />
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-xs sm:text-sm">
                            <div>
                                <p class="font-semibold">Gestión de miembros</p>
                                <p class="text-emerald-100 italic opacity-80">Fichas e historial.</p>
                            </div>
                            <div>
                                <p class="font-semibold">Finanzas claras</p>
                                <p class="text-emerald-100 italic opacity-80">Ingresos y egresos.</p>
                            </div>
                            <div>
                                <p class="font-semibold">Agenda pastoral</p>
                                <p class="text-emerald-100 italic opacity-80">Eventos y cultos.</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative animate-fade-in-right">
                        <div class="absolute -top-6 -right-4 w-24 h-24 rounded-full bg-emerald-500/40 blur-2xl"></div>
                        <div class="absolute -bottom-4 -left-6 w-24 h-24 rounded-full bg-emerald-900/50 blur-2xl"></div>
                        <div class="relative bg-slate-950/80 border border-emerald-500/40 rounded-2xl p-4 shadow-2xl">
                            <div class="flex items-center justify-between mb-3 text-xs">
                                <p class="text-emerald-100 font-medium">Resumen de la congregación</p>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                                    En línea
                                </span>
                            </div>

                            <div class="grid grid-cols-3 gap-3 mb-4 text-xs">
                                <div class="bg-slate-900/60 rounded-lg p-3 border border-emerald-500/20">
                                    <p class="text-slate-300 mb-1">Miembros</p>
                                    <p class="text-lg font-semibold text-emerald-300">325</p>
                                </div>
                                <div class="bg-slate-900/60 rounded-lg p-3 border border-emerald-500/20">
                                    <p class="text-slate-300 mb-1">Servidores</p>
                                    <p class="text-lg font-semibold text-emerald-300">58</p>
                                </div>
                                <div class="bg-slate-900/60 rounded-lg p-3 border border-emerald-500/20">
                                    <p class="text-slate-300 mb-1">Bautizos</p>
                                    <p class="text-lg font-semibold text-emerald-300">142</p>
                                </div>
                            </div>

                            <div class="bg-slate-900/70 rounded-lg p-3 mb-3 border border-emerald-500/20 h-24 flex flex-col justify-end">
                                <div class="flex items-center justify-between text-[10px] mb-2">
                                    <p class="text-slate-200">Actividad Mensual</p>
                                    <span class="text-emerald-300 font-bold">+18%</span>
                                </div>
                                <div class="flex items-end gap-1 h-12">
                                    <div class="flex-1 bg-emerald-500/30 rounded-t h-[40%]"></div>
                                    <div class="flex-1 bg-emerald-500/50 rounded-t h-[70%]"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-t h-[90%]"></div>
                                    <div class="flex-1 bg-emerald-500/60 rounded-t h-[50%]"></div>
                                    <div class="flex-1 bg-emerald-500/40 rounded-t h-[30%]"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-[11px] text-slate-300">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-6 w-6 rounded-full bg-emerald-500/40 items-center justify-center">
                                        <i class="pi pi-users text-xs"></i>
                                    </span>
                                    <p class="font-medium">Gestión en tiempo real</p>
                                </div>
                                <RouterLink to="/login" class="text-emerald-100 hover:underline">Acceder →</RouterLink>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Subtle Background Decorative Pattern -->
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
            </section>

            <!-- Carrusel de Fotos (Nuevo) -->
            <section id="about" v-if="config.carousel.length > 0" class="py-16 bg-white overflow-hidden scroll-mt-20">
                <div class="max-w-5xl mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-slate-900">La Vida en Nuestra Iglesia</h2>
                        <div class="h-1 w-20 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
                    </div>
                    
                    <Carousel :value="config.carousel" :numVisible="1" :numScroll="1" circular :autoplayInterval="4000">
                        <template #item="slotProps">
                            <div class="p-2">
                                <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[16/7] md:aspect-[16/6] group">
                                    <img :src="getImageUrl(slotProps.data.url)" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6 md:p-12">
                                        <h3 class="text-2xl md:text-4xl font-bold text-white mb-2 transform transition-all duration-500 group-hover:-translate-y-2">{{ slotProps.data.title }}</h3>
                                        <p class="text-slate-200 text-sm md:text-lg transform transition-all duration-500 group-hover:-translate-y-2 delay-75">{{ slotProps.data.subtitle }}</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Carousel>
                </div>
            </section>

            <!-- Horarios de Culto (Nuevo - Opción 1) -->
            <section id="modules" v-if="config.schedules && config.schedules.length > 0" class="py-16 bg-slate-50 scroll-mt-20">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="text-center mb-10">
                        <span class="text-emerald-600 font-bold tracking-widest text-xs uppercase italic">Acompáñanos</span>
                        <h2 class="text-3xl font-bold text-slate-900 mt-2">Nuestros Servicios</h2>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div v-for="(s, index) in config.schedules" :key="index" class="bg-white rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group overflow-hidden">
                            <!-- Image Header (Conditional) -->
                            <div v-if="s.showImage && s.imageUrl" class="h-48 w-full overflow-hidden relative">
                                <img :src="getImageUrl(s.imageUrl)" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-0.5 rounded-full text-[9px] font-bold text-emerald-700 uppercase shadow-sm">
                                    {{ s.day }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <i v-if="!s.showImage" class="pi pi-clock text-emerald-500 mb-2 block group-hover:scale-110 transition-transform"></i>
                                <p v-if="!s.showImage" class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mb-1">{{ s.day }}</p>
                                <h4 class="font-bold text-slate-800 text-lg leading-tight">{{ s.title }}</h4>
                                <p class="text-emerald-600 font-bold text-sm mt-2 flex items-center gap-2">
                                    <i class="pi pi-calendar-plus text-xs"></i> {{ s.time }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sobre el sistema / Qué esperar (Nuevo Mix) -->
            <section id="features" class="py-20 bg-white overflow-hidden relative scroll-mt-20">
                <div class="max-w-6xl mx-auto px-4 relative z-10">
                    <div class="grid md:grid-cols-2 gap-16 items-center">
                        <div class="space-y-6">
                            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                                {{ config.info.socialWork ? 'Comprometidos con el Reino y la Sociedad' : 'Pensado para el pastor y el equipo administrativo.' }}
                            </h2>
                            <div class="space-y-4">
                                <div class="p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl">
                                    <h4 class="font-bold text-emerald-900 mb-1 flex items-center gap-2">
                                        <i class="pi pi-heart-fill text-sm"></i> ¿Qué esperar?
                                    </h4>
                                    <p class="text-emerald-800 text-sm leading-relaxed">{{ config.info.whatToExpect }}</p>
                                </div>
                                <div v-if="config.info.socialWork" class="p-5 bg-blue-50 border-l-4 border-blue-500 rounded-r-2xl">
                                    <h4 class="font-bold text-blue-900 mb-1 flex items-center gap-2">
                                        <i class="pi pi-globe text-sm"></i> Labor Social
                                    </h4>
                                    <p class="text-blue-800 text-sm leading-relaxed">{{ config.info.socialWork }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-200 shadow-inner space-y-2">
                                <i class="pi pi-users text-emerald-600 text-xl"></i>
                                <h5 class="font-bold text-slate-800 text-sm">Comunidad</h5>
                                <p class="text-[11px] text-slate-500 italic">Un lugar para toda la familia.</p>
                            </div>
                            <div class="bg-slate-900 p-6 rounded-[2rem] text-white shadow-xl space-y-2 mt-8">
                                <i class="pi pi-shield text-emerald-400 text-xl"></i>
                                <h5 class="font-bold text-sm">Seguridad</h5>
                                <p class="text-[11px] text-emerald-200/60 italic">Gestión segura de datos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Bento Grid Comunidad (Nuevo - Opción 2) -->
            <section class="py-20 bg-slate-50" v-if="config.bento.showPrayer || config.bento.showCourses">
                <div class="max-w-6xl mx-auto px-4">
                     <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-slate-900">Nuestra Comunidad Online</h2>
                        <p class="text-slate-500 mt-2">Accede rápidamente a lo que necesitas.</p>
                    </div>
                    
                    <div class="grid md:grid-cols-4 md:grid-rows-2 gap-4 h-auto md:h-[500px]">
                        <!-- Peticiones (Caja Grande) -->
                        <div v-if="config.bento.showPrayer" class="md:col-span-2 md:row-span-2 bg-emerald-600 rounded-[2.5rem] p-8 text-white flex flex-col justify-between shadow-2xl relative overflow-hidden group">
                            <i class="pi pi-heart absolute -right-10 -bottom-10 text-[15rem] opacity-10 transform group-hover:rotate-12 transition-transform duration-700"></i>
                            <div>
                                <h3 class="text-3xl font-bold mb-4">Peticiones de Oración</h3>
                                <p class="text-emerald-100 text-sm md:text-base leading-relaxed">No estás solo. Queremos orar por ti y tu familia. Envíanos tu necesidad de forma confidencial.</p>
                            </div>
                            <Button label="Enviar Petición" class="!bg-white !text-emerald-700 !border-0 !w-max !rounded-full !px-8 hover:!scale-105 transition-transform" @click="showPrayerModal = true" />
                        </div>

                        <!-- Calendario de Eventos (Caja Ancha) -->
                        <div class="md:col-span-2 bg-slate-900 rounded-[2.5rem] p-6 text-white shadow-xl border border-slate-700 overflow-hidden">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-12 w-12 bg-blue-500/20 rounded-2xl flex items-center justify-center text-blue-400 text-xl">
                                    <i class="pi pi-calendar"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Próximos Eventos</h4>
                                    <p class="text-xs text-slate-400">¡No te los pierdas!</p>
                                </div>
                            </div>
                            <div class="space-y-2 max-h-[120px] overflow-y-auto custom-scrollbar">
                                <div v-if="upcomingEvents.length === 0" class="text-slate-400 text-sm italic text-center py-4">
                                    No hay eventos próximos programados.
                                </div>
                                <div v-for="event in upcomingEvents.slice(0, 3)" :key="event.id" class="bg-slate-800/50 rounded-xl p-3 hover:bg-slate-800 transition-colors">
                                    <p class="font-semibold text-sm text-white line-clamp-1">{{ event.name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <i class="pi pi-calendar-plus text-[10px] text-blue-400"></i>
                                        <span class="text-[10px] text-slate-300">{{ formatEventDate(event.start_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cursos (Dos Cajas Pequeñas) -->
                         <div v-if="config.bento.showCourses" class="md:col-span-1 bg-white rounded-[2.5rem] border border-slate-200 p-6 flex flex-col justify-center items-center text-center shadow-sm hover:-translate-y-2 transition-transform">
                            <i class="pi pi-book text-emerald-600 text-3xl mb-3"></i>
                            <h5 class="font-bold text-slate-800">Cursos</h5>
                            <p class="text-[10px] text-slate-500">Crece en fe.</p>
                        </div>
                        <div v-if="config.bento.showCourses" class="md:col-span-1 bg-white rounded-[2.5rem] border border-slate-200 p-6 flex flex-col justify-center items-center text-center shadow-sm hover:-translate-y-2 transition-transform">
                             <div class="relative">
                                <i class="pi pi-users text-blue-600 text-3xl mb-3"></i>
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                </span>
                             </div>
                            <h5 class="font-bold text-slate-800">Grupos</h5>
                            <p class="text-[10px] text-slate-500">Hechos 2:42.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Módulos principales -->
            <section id="modules" class="py-16 bg-slate-50">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10 text-center sm:text-left">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                                Módulos Principales
                            </h2>
                            <p class="text-sm sm:text-base text-slate-600">
                                Diseñados específicamente para la administración de la congregación moderna.
                            </p>
                        </div>
                        <RouterLink to="/login"><Button label="Ver demo del panel" icon="pi pi-chart-bar" severity="secondary" class="!text-sm" /></RouterLink>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 text-sm">
                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center shadow-inner">
                                    <i class="pi pi-id-card text-emerald-700"></i>
                                </span>
                                <p class="font-bold text-slate-900">Membresía</p>
                            </div>
                            <p class="text-slate-600 leading-relaxed">
                                Registro completo de miembros, bautizos, matrimonios y búsqueda avanzada por grupos y edades.
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center shadow-inner">
                                    <i class="pi pi-wallet text-emerald-700"></i>
                                </span>
                                <p class="font-bold text-slate-900">Finanzas</p>
                            </div>
                            <p class="text-slate-600 leading-relaxed">
                                Control transparente de ingresos, ofrendas y gastos con reportes automáticos para asambleas.
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center shadow-inner">
                                    <i class="pi pi-calendar text-emerald-700"></i>
                                </span>
                                <p class="font-bold text-slate-900">Actividades</p>
                            </div>
                            <p class="text-slate-600 leading-relaxed">
                                Centraliza el calendario de cultos, reuniones y eventos especiales en una sola vista ministerial.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Video de YouTube (Nuevo) -->
            <section v-if="config.video.youtubeUrl || config.video.title" class="py-20 bg-slate-900 text-white relative overflow-hidden">
                <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                    <h2 v-if="config.video.title" class="text-3xl font-bold mb-8">{{ config.video.title }}</h2>
                    <div v-if="config.video.youtubeUrl && getYoutubeId(config.video.youtubeUrl)" class="aspect-video rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(16,185,129,0.3)] border-4 border-slate-800">
                        <iframe :src="'https://www.youtube.com/embed/' + getYoutubeId(config.video.youtubeUrl)" 
                                class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div v-else-if="config.video.youtubeUrl" class="aspect-video rounded-3xl bg-slate-800 border-4 border-slate-700 flex items-center justify-center">
                        <div class="text-center p-8">
                            <i class="pi pi-exclamation-triangle text-4xl text-amber-400 mb-4"></i>
                            <p class="text-slate-300">URL de YouTube no válida</p>
                            <p class="text-xs text-slate-500 mt-2">Por favor, verifica la URL en el panel de administración</p>
                        </div>
                    </div>
                </div>
                <!-- Background decor -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 blur-[100px]"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 blur-[100px]"></div>
            </section>

            <!-- Testimonios (Nuevo) -->
            <section v-if="config.testimonials.length > 0" class="py-20 bg-slate-50">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <span class="text-emerald-600 font-bold tracking-widest text-xs uppercase">Nuestra Familia</span>
                        <h2 class="text-3xl font-bold text-slate-900 mt-2">Testimonios</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div v-for="(t, index) in config.testimonials" :key="index" class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col items-center text-center">
                            <div class="h-12 w-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6">
                                <i class="pi pi-quote-right text-xl"></i>
                            </div>
                            <p class="text-slate-600 italic mb-6 leading-relaxed">"{{ t.content }}"</p>
                            <div>
                                <h4 class="font-bold text-slate-900 underline decoration-emerald-500 decoration-2 underline-offset-4">{{ t.name }}</h4>
                                <p class="text-[11px] text-slate-500 mt-1 uppercase font-medium">{{ t.role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--
            Beneficios / Enfoque técnico resumido
            <section id="features" class="py-16 bg-white">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-10 items-start">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">
                            Seguro, escalable y listo para crecer con tu iglesia.
                        </h2>
                        <p class="text-sm sm:text-base text-slate-600 mb-4">
                            Construido con Laravel y Vue, con buenas prácticas de seguridad, manejo de roles y
                            posibilidad de escalar a múltiples iglesias (multi-tenant).
                        </p>
                        <ul class="space-y-3 text-sm text-slate-700">
                            <li class="flex gap-3">
                                <i class="pi pi-shield text-emerald-600 mt-0.5"></i>
                                <span>Protección CSRF y autenticación robusta basada en el sistema de Auth de Laravel.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="pi pi-lock text-emerald-600 mt-0.5"></i>
                                <span>Conexiones seguras (SSL) y buenas prácticas para proteger datos sensibles.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="pi pi-database text-emerald-600 mt-0.5"></i>
                                <span>Modelo de datos preparado para <code>users</code>, <code>members</code>,
                                    <code>transactions</code> y <code>events</code>.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="pi pi-cloud text-emerald-600 mt-0.5"></i>
                                <span>Arquitectura pensada para multi-iglesia (multi-tenant) y exportaciones con Laravel Excel.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 text-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-slate-900">Stack tecnológico</p>
                            <span class="text-[11px] px-2 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                Laravel + Vue + Tailwind + PrimeVue
                            </span>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 mb-1">Backend</p>
                                <ul class="space-y-1 text-slate-700">
                                    <li>• Laravel 12</li>
                                    <li>• Autenticación y roles</li>
                                    <li>• API REST para módulos</li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 mb-1">Frontend</p>
                                <ul class="space-y-1 text-slate-700">
                                    <li>• Vue 3 + Vue Router</li>
                                    <li>• TailwindCSS</li>
                                    <li>• Componentes PrimeVue</li>
                                </ul>
                            </div>
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <p class="text-xs text-slate-500 mb-2">
                                Próximos pasos de desarrollo:
                            </p>
                            <ul class="text-xs text-slate-700 space-y-1">
                                <li>1. Implementar autenticación (login / recordar sesión).</li>
                                <li>2. Crear layout del panel (sidebar, header, dashboard).</li>
                                <li>3. Definir y crear tablas <code>users</code>, <code>members</code>,
                                    <code>transactions</code>, <code>events</code>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            -->

            <!-- Contacto -->
            <section id="contact" class="py-20 bg-white scroll-mt-20">
                <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-6">Comunícate con Nosotros</h2>
                        <p class="text-slate-600 mb-10 leading-relaxed">
                            Estamos aquí para acompañarte y responder tus dudas. Encuéntranos en nuestras redes
                            o envíanos un mensaje directo.
                        </p>
                        
                        <div class="space-y-6">
                            <a v-if="config.contact.whatsapp" :href="'https://wa.me/' + config.contact.whatsapp" target="_blank" class="flex items-center gap-4 group p-4 bg-emerald-50 rounded-2xl border border-emerald-100/50 hover:bg-emerald-100 transition-colors">
                                <div class="h-10 w-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                    <i class="pi pi-whatsapp"></i>
                                </div>
                                <span class="font-bold text-emerald-800">WhatsApp Directo</span>
                            </a>
                            <div class="flex gap-4">
                                <a v-if="config.contact.facebook" :href="config.contact.facebook" target="_blank" class="flex-1 flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-slate-100 transition-all">
                                    <i class="pi pi-facebook text-blue-600"></i>
                                    <span class="text-xs font-bold text-slate-700">Facebook</span>
                                </a>
                                <a v-if="config.contact.instagram" :href="config.contact.instagram" target="_blank" class="flex-1 flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-slate-100 transition-all">
                                    <i class="pi pi-instagram text-pink-600"></i>
                                    <span class="text-xs font-bold text-slate-700">Instagram</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-slate-100 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Envíanos un Mensaje</h3>
                        <form class="space-y-4" @submit.prevent>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Nombre</label>
                                    <InputText v-model="form.nombre" class="w-full !rounded-xl" placeholder="Tu nombre" />
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Correo</label>
                                    <InputText v-model="form.correo" class="w-full !rounded-xl" placeholder="Email" />
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">Mensaje</label>
                                <Textarea v-model="form.mensaje" rows="4" class="w-full !rounded-xl" placeholder="¿En qué podemos ayudarte?" />
                            </div>
                            <Button label="Enviar Mensaje" class="w-full !rounded-xl !py-3 !mt-2" icon="pi pi-send" />
                        </form>
                    </div>
                </div>
            </section>

            <!-- Ubicación / Mapa (Nuevo) -->
            <section v-if="config.contact.showMap && config.contact.googleMapsEmbedUrl" class="py-10 bg-slate-50 border-t border-slate-100">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="grid md:grid-cols-3 gap-8 items-center">
                        <div class="md:col-span-1 space-y-4">
                            <h3 class="text-2xl font-bold text-slate-900">Visítanos</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Estamos ubicados en una zona accesible para toda la congregación. 
                                ¡Te esperamos con los brazos abiertos en nuestros servicios semanales!
                            </p>
                            <div class="flex items-center gap-3 text-emerald-700 font-semibold bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                                <i class="pi pi-map-marker text-xl"></i>
                                <span class="text-sm">Encuentra nuestra ubicación exacta aquí →</span>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="w-full h-[400px] rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white relative group">
                                <div class="absolute inset-0 bg-slate-200 animate-pulse" v-if="!mapLoaded"></div>
                                <iframe 
                                    :src="config.contact.googleMapsEmbedUrl" 
                                    @load="mapLoaded = true"
                                    class="w-full h-full relative z-10" 
                                    frameborder="0" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy">
                                </iframe>
                                <!-- Zoom Indicator Overlay -->
                                <div class="absolute bottom-4 left-4 z-20 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-slate-500 shadow-sm border border-slate-100 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="pi pi-search-plus mr-1"></i> Interactive Map
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200 bg-white py-4 text-xs text-slate-500">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>© {{ new Date().getFullYear() }} Sistema Iglesia. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a v-if="config.contact.showFacebook && config.contact.facebook" :href="config.contact.facebook" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors transform hover:scale-110">
                        <i class="pi pi-facebook text-[40px]"></i>
                    </a>
                    <a v-if="config.contact.showInstagram && config.contact.instagram" :href="config.contact.instagram" target="_blank" class="text-slate-400 hover:text-pink-600 transition-colors transform hover:scale-110">
                        <i class="pi pi-instagram text-[40px]"></i>
                    </a>
                    <a v-if="config.contact.showYoutube && config.contact.youtube" :href="config.contact.youtube" target="_blank" class="text-slate-400 hover:text-red-600 transition-colors transform hover:scale-110">
                        <i class="pi pi-youtube text-[40px]"></i>
                    </a>
                    <a v-if="config.contact.showTiktok && config.contact.tiktok" :href="config.contact.tiktok" target="_blank" class="text-slate-400 hover:text-black transition-colors transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </footer>

        <!-- WhatsApp Flotante (Nuevo) -->
        <a v-if="config.contact.whatsapp" 
           :href="'https://wa.me/' + config.contact.whatsapp + '?text=' + encodeURIComponent(config.contact.whatsappMessage || 'Hola, quisiera más información sobre la iglesia')" 
           target="_blank"
           class="fixed bottom-6 right-6 h-14 w-14 bg-emerald-500 text-white rounded-full shadow-[0_10px_30px_rgba(16,185,129,0.5)] flex items-center justify-center text-2xl z-50 hover:scale-110 active:scale-95 transition-all animate-bounce-slow group">
            <i class="pi pi-whatsapp"></i>
            <!-- Tooltip -->
            <span class="absolute right-16 bg-slate-900 text-white text-[10px] px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                ¿Es tu primera vez? Escríbenos
            </span>
        </a>

        <!-- Modal de Peticiones de Oración -->
        <PrayerRequestModal v-model:show="showPrayerModal" :success-message="config.prayerRequestSuccessMessage" />
    </div>
</template>

<script setup>
import { reactive, onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Carousel from 'primevue/carousel';
import { fetchLandingSettingsPublic } from '../services/settings';
import PrayerRequestModal from '../components/PrayerRequestModal.vue';
import api from '../services/api';

const config = reactive({
    hero: { title: 'Administra tu iglesia en un solo lugar', subtitle: 'Gestión integral de tu congregación desde cualquier dispositivo.' },
    carousel: [],
    video: { youtubeUrl: '', title: '' },
    testimonials: [],
    schedules: [],
    info: { whatToExpect: '', socialWork: '' },
    bento: { showPrayer: true, showDonations: true, showCourses: true, donationsInfo: '' },
    contact: { whatsapp: '', whatsappMessage: '', facebook: '', showFacebook: true, instagram: '', showInstagram: true, youtube: '', showYoutube: false, tiktok: '', showTiktok: false, showMap: true, googleMapsEmbedUrl: '' },
    prayerRequestSuccessMessage: 'Estaremos orando por ti. ¡Dios te bendiga!'
});

const mapLoaded = ref(false);
const showPrayerModal = ref(false);
const upcomingEvents = ref([]);

onMounted(async () => {
    try {
        const data = await fetchLandingSettingsPublic();
        if (data) {
            // Asegurar que contact existe
            if (!data.contact) data.contact = {};
            
            // Asignar defaults si no existen
            if (data.contact.showFacebook === undefined) data.contact.showFacebook = true;
            if (data.contact.showInstagram === undefined) data.contact.showInstagram = true;
            // Para YouTube y TikTok, default false si no existen
            if (data.contact.showYoutube === undefined) data.contact.showYoutube = false;
            if (data.contact.showTiktok === undefined) data.contact.showTiktok = false;

            // Merge cuidadoso para no perder reactividad
            config.hero = { ...config.hero, ...data.hero };
            config.video = { ...config.video, ...data.video };
            config.info = { ...config.info, ...data.info };
            config.bento = { ...config.bento, ...data.bento };
            config.contact = { ...config.contact, ...data.contact };
            
            // Arrays directos
            if (data.carousel) config.carousel = data.carousel;
            if (data.testimonials) config.testimonials = data.testimonials;
            if (data.schedules) config.schedules = data.schedules;
            
            if (data.prayerRequestSuccessMessage) config.prayerRequestSuccessMessage = data.prayerRequestSuccessMessage;
        }
        
        // Cargar eventos públicos
        const eventsResponse = await api.get('/events/public');
        upcomingEvents.value = eventsResponse.data;
    } catch (e) {
        console.error("Error loading landing settings");
    }
});

const form = reactive({
    nombre: '',
    correo: '',
    telefono: '',
    iglesia: '',
    mensaje: '',
});

const formatEventDate = (dateString) => {
    const date = new Date(dateString);
    const options = { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleDateString('es-ES', options);
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

const getYoutubeId = (url) => {
    if (!url) return null;
    
    // Limpiar la URL de parámetros innecesarios
    let videoId = null;
    
    // Patrón 1: URLs con parámetro v=
    const vPattern = /[?&]v=([^&#]*)/;
    const vMatch = url.match(vPattern);
    if (vMatch && vMatch[1]) {
        videoId = vMatch[1];
    }
    
    // Patrón 2: URLs cortas youtu.be
    const shortPattern = /youtu\.be\/([^?&#]*)/;
    const shortMatch = url.match(shortPattern);
    if (shortMatch && shortMatch[1]) {
        videoId = shortMatch[1];
    }
    
    // Patrón 3: URLs embed
    const embedPattern = /youtube\.com\/embed\/([^?&#]*)/;
    const embedMatch = url.match(embedPattern);
    if (embedMatch && embedMatch[1]) {
        videoId = embedMatch[1];
    }
    
    // Validar que el ID tenga 11 caracteres (formato estándar de YouTube)
    if (videoId && videoId.length === 11) {
        return videoId;
    }
    
    return null;
};

const scrollToSection = (sectionId) => {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};
</script>

<style scoped>
.animate-fade-in-left {
    animation: fadeInLeft 0.8s ease-out forwards;
}
.animate-fade-in-right {
    animation: fadeInRight 0.8s ease-out forwards;
}

@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

.animate-bounce-slow {
    animation: bounceSlow 3s infinite;
}

@keyframes bounceSlow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

:deep(.p-carousel-indicators) {
    bottom: 2rem;
}
:deep(.p-carousel-indicator.p-highlight button) {
    background-color: #10b981;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(59, 130, 246, 0.5);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(59, 130, 246, 0.7);
}
</style>


