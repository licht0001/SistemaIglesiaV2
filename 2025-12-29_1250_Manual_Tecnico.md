# Manual Técnico - SistemaIglesiaV2

**Versión:** 2.1
**Fecha:** 30 de Diciembre de 2025

---

## 1. Requisitos del Sistema (Prerrequisitos)
Para ejecutar este proyecto en un entorno local o servidor, necesita:

*   **Backend:**
    *   PHP >= 8.2
    *   Composer 2.x
    *   Extensión PHP PDO MySQL
*   **Frontend:**
    *   Node.js >= 20.0 (Recomendado)
    *   NPM (incluido con Node)
*   **Base de Datos:**
    *   MySQL 8.0 o MariaDB 10.x
*   **Servidor Web:**
    *   Apache/Nginx (para producción) o servidor integrado de PHP/Vite (para desarrollo).

---

## 2. Estructura del Proyecto
El proyecto utiliza una estructura de **Monorepo Híbrido** donde backend y frontend conviven en la carpeta raíz `SistemaIglesiaV2`.

```
SistemaIglesiaV2/
├── backend/            # Aplicación Laravel (API)
│   ├── app/            # Controladores, Modelos (SettingsController.php clave)
│   ├── database/       # Migraciones y Seeders (PrayerRequests, Members, etc.)
│   ├── public/         # Almacenamiento público de imágenes
│   └── routes/         # api.php define la comunicación
│
├── frontend/           # Aplicación Vue.js 3
│   ├── src/
│   │   ├── components/ # Modales compactos y reutilizables
│   │   ├── services/   # Clientes Axios (members.js, settings.js)
│   │   ├── views/      # Vistas (Dashboard.vue, Landing.vue, Members.vue)
│   │   └── main.js     # Configuración PrimeVue
│   └── vite.config.js  # Proxy al backend
│
└── 2025-XX-XX_...md  # Registro histórico de cambios y manuales
```

---

## 3. Instalación y Despliegue (Dev)

### Paso 1: Configurar Backend
1.  Navegar a la carpeta: `cd backend`
2.  Instalar dependencias: `composer install`
3.  Configurar entorno: `cp .env.example .env` (Ajustar credenciales DB).
4.  Generar llave: `php artisan key:generate`
5.  Migrar base de datos: `php artisan migrate`
6.  Enlace de storage: `php artisan storage:link`
7.  Iniciar servidor: `php artisan serve` (Puerto 8000).

### Paso 2: Configurar Frontend
1.  Navegar a la carpeta: `cd frontend`
2.  Instalar dependencias: `npm install`
3.  Iniciar servidor de desarrollo: `npm run dev` (Puerto 5173).

---

## 4. Lógica de Negocio y UI Personalizada

### 4.1 Código de Colores en Peticiones
En `PrayerRequests.vue`, el estado de las etiquetas se gestiona mediante la función `getStatusClass(status)`. Se utilizan clases de Tailwind con `!important` para asegurar el cumplimiento visual:
*   **Pendiente:** `!bg-red-100 !text-red-700`
*   **Mencionado:** `!bg-yellow-100 !text-yellow-700`
*   **Completado:** `!bg-green-100 !text-green-700`

### 4.2 Desglose de Dashboard
El archivo `Dashboard.vue` incluye tarjetas para **Viudos** (`widowed`) y **Divorciados** (`divorced`). 
*   **Función `openDetailModal(type)`:** Realiza peticiones dinámicas al servicio de miembros aplicando filtros por `marital`.
*   **Filtros:** Se envían como objetos `{ category: 'adulto', marital: '...' }` al backend.

### 4.3 Redes Sociales y Reactividad
En `Landing.vue`, la carga de configuración utiliza el operador spread (`...`) para fusionar objetos anidados.
*   **TikTok:** Se utiliza un SVG personalizado con dimensiones `40x40` para mantener consistencia con los iconos de FontAwesome (`text-[40px]`).
*   **Visibilidad:** Se inicializan booleanos (`showFacebook`, etc.) en el cliente si el backend devuelve `undefined`.

### 4.4 Compactación de Formularios (Members.vue)
El modal de Miembros utiliza un sistema de **Grid de 12 columnas** (`grid-cols-12`) con espacios reducidos (`gap-3`) y clases `h-9` en los inputs para maximizar el uso del espacio en pantallas medianas.

---

## 5. Endpoints Clave (API)

| Método | Ruta | Descripción |
| :--- | :--- | :--- |
| **GET** | `/api/settings/landing` | Obtiene la configuración (con Misión/Visión). |
| **GET** | `/api/members` | Obtiene lista con filtros (bautizado, marital, etc). |
| **POST** | `/api/prayer-requests` | Captura peticiones desde el landing. |

## 6. Comandos de Mantenimiento
*   **Limpiar caché:** `php artisan optimize:clear`
*   **Exportar Miembros:** `php artisan members:export` (Si está implementado vía comando).
*   **Construir Prod:** `npm run build` en el frontend.
