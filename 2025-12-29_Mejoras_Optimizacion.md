# Propuestas de Mejora y Optimización - SistemaIglesiaV2

**Fecha:** 29 de Diciembre de 2025
**Objetivo:** Elevar el rendimiento, la seguridad y la escalabilidad del sistema actual.

---

## 1. 🚀 Rendimiento (Velocidad y Respuesta)

### Frontend (Vue.js + Vite)
1.  **Lazy Loading de Rutas:**
    *   **Estado Actual:** Carga todos los componentes al inicio.
    *   **Mejora:** Implementar `import()` dinámico en el `router.js` para cargar vistas (como 'Dashboard', 'Finanzas') solo cuando el usuario las visita, reduciendo el peso inicial del JavaScript.
2.  **Optimización de Imágenes:**
    *   **Mejora:** Convertir imágenes subidas automáticamente a formato **WebP**. Implementar "Lazy Loading" nativo (`loading="lazy"`) en las etiquetas `<img>` del landing page.
3.  **Gestión de Estado (Pinia):**
    *   **Mejora:** Migrar de props/emit complejos o estados locales a **Pinia** (store de Vue) para gestionar datos globales como "Usuario Autenticado" o "Configuración General", evitando peticiones repetitivas a la API.
4.  **PWA (Progressive Web App):**
    *   **Mejora:** Configurar `vite-plugin-pwa` para que la aplicación sea instalable en móviles y cargue instantáneamente (cacheando assets estáticos) incluso con conexión inestable.

### Backend (Laravel API)
1.  **Caché de Base de Datos:**
    *   **Problema:** La configuración del landing (`/api/settings/landing`) se consulta en cada visita.
    *   **Mejora:** Utilizar **Redis** o el caché de archivo de Laravel para guardar esta respuesta por 60 minutos o hasta que se actualice.
    *   *Comando:* `Cache::remember('landing_settings', 3600, fn() => Setting::where(...))`
2.  **Colas (Queues) para Tareas Pesadas:**
    *   **Mejora:** Si se envían correos electrónicos o se generan reportes PDF pesados, usar **Laravel Queues** para procesarlos en segundo plano sin hacer esperar al usuario.
3.  **Laravel Octane:**
    *   **Nivel Avanzado:** Implementar Laravel Octane con Swoole o RoadRunner para mantener la aplicación en memoria, acelerando las respuestas de la API de ~100ms a ~10ms.

---

## 2. 🛡️ Seguridad

1.  **Rate Limiting (Límite de Peticiones):**
    *   **Mejora:** Configurar estrictamente el `Throttle` en el `RouteServiceProvider` para prevenir ataques de fuerza bruta, especialmente en las rutas de `/login` y `/api/prayer-requests` (public).
2.  **Seguridad de Cookies y Tokens:**
    *   **Mejora:** Asegurar que las cookies de sesión tengan los flags `Secure` (solo HTTPS), `HttpOnly` (no accesible por JS) y `SameSite=Strict`.
3.  **Validación Robusta (Form Requests):**
    *   **Mejora:** Mover todas las validaciones de los controladores a clases **FormRequest** dedicadas. Esto centraliza la seguridad y evita inyecciones de datos maliciosos.
4.  **Honeypot para Formularios Públicos:**
    *   **Mejora:** Agregar un campo oculto (honeypot) en el formulario de Peticiones de Oración para detectar y bloquear bots automáticamente sin molestar a los usuarios con Captchas complejos.

---

## 3. 🏗️ Arquitectura y DevOps

1.  **Dockerización:**
    *   **Mejora:** Crear un archivo `docker-compose.yml` que levante Nginx, PHP, MySQL y Redis en contenedores. Esto garantiza que el entorno de desarrollo sea idéntico al de producción y facilita el despliegue.
2.  **Backup Automatizado:**
    *   **Mejora:** Utilizar el paquete `spatie/laravel-backup` para generar copias diarias de la base de datos y enviarlas a un almacenamiento externo (como AWS S3 o Google Drive) automáticamente.
3.  **Testing Automatizado:**
    *   **Mejora:** Crear pruebas unitarias (PestPHP o PHPUnit) para los cálculos financieros y pruebas End-to-End (Cypress) para el flujo de enviar una petición de oración.

## 4. 🧩 Experiencia de Usuario (UX)

1.  **Skeleton Loaders:**
    *   **Mejora:** En lugar de mostrar una pantalla en blanco o un spinner simple, mostrar "esqueletos" grises (estructura vacía) mientras cargan los datos del Dashboard para dar sensación de velocidad inmedia.
2.  **Modo Offline:**
    *   **Mejora:** Permitir que los administradores consulten datos previamente cargados (como la lista de miembros) incluso si se corta internet momentáneamente.

---

### Resumen de Prioridades
1.  **Alta:** Implementar Caché en Settings y Lazy Loading en rutas Frontend (Impacto inmediato en velocidad).
2.  **Media:** Backup Automatizado y Rate Limiting (Seguridad crítica).
3.  **Baja:** Dockerización y Laravel Octane (Optimizaciones de infraestructura).
