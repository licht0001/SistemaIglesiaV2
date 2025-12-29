# Manual Técnico - SistemaIglesiaV2

**Versión:** 2.0
**Fecha:** 29 de Diciembre de 2025

---

## 1. Requisitos del Sistema (Prerrequisitos)
Para ejecutar este proyecto en un entorno local o servidor, necesita:

*   **Backend:**
    *   PHP >= 8.2
    *   Composer 2.x
    *   Extensión PHP PDO MySQL
*   **Frontend:**
    *   Node.js >= 18.0
    *   NPM (incluido con Node)
*   **Base de Datos:**
    *   MySQL 8.0 o MariaDB 10.x
*   **Servidor Web:**
    *   Apache/Nginx (para producción) o servidor integrado de PHP/Vite (para desarrollo).

---

## 2. Estructura del Proyecto
El proyecto utiliza una estructura de **Monorepo Híbrido** donde backend y frontend conviven en la carpeta raíz `SistemaIglesiaV2` pero funcionan como aplicaciones separadas.

```
SistemaIglesiaV2/
├── backend/            # Aplicación Laravel (API)
│   ├── app/            # Controladores, Modelos
│   ├── config/         # Configuración del framework
│   ├── database/       # Migraciones y Seeders
│   ├── public/         # Entry point, almacenamiento público (imágenes)
│   ├── routes/         # Definición de rutas (api.php es la clave)
│   └── .env            # Variables de entorno (DB, App Key)
│
├── frontend/           # Aplicación Vue.js (Cliente)
│   ├── src/
│   │   ├── components/ # Componentes reutilizables (Modales, botones)
│   │   ├── services/   # Lógica de comunicación con API (Axios)
│   │   ├── views/      # Páginas (Landing, Dashboard)
│   │   └── main.js     # Punto de entrada Vue
│   ├── public/         # Assets estáticos
│   ├── index.html      # HTML Base
│   └── vite.config.js  # Configuración de Vite (Proxy al backend)
│
└── Documentacion/      # Manuales y registros (.md)
```

---

## 3. Instalación y Despliegue (Dev)

### Paso 1: Configurar Backend
1.  Navegar a la carpeta: `cd backend`
2.  Instalar dependencias: `composer install`
3.  Configurar entorno: `cp .env.example .env`
    *   Ajustar `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
4.  Generar llave: `php artisan key:generate`
5.  Migrar base de datos: `php artisan migrate`
6.  (Opcional) Enlace simbólico para storage: `php artisan storage:link`
7.  Iniciar servidor: `php artisan serve` (Corre en puerto 8000).

### Paso 2: Configurar Frontend
1.  Navegar a la carpeta: `cd frontend`
2.  Instalar dependencias: `npm install`
3.  Iniciar servidor de desarrollo: `npm run dev` (Corre en puerto 5173).

**Nota Importante sobre Proxy:**
El archivo `frontend/vite.config.js` tiene configurado un proxy para redirigir las peticiones que empiezan con `/api` hacia `http://127.0.0.1:8000`. Esto evita problemas de CORS en desarrollo.

---

## 4. Endpoints Clave (API)

| Método | Ruta | Descripción |
| :--- | :--- | :--- |
| **GET** | `/api/settings/landing` | Obtiene la configuración pública del Landing. |
| **PUT** | `/api/settings/landing` | Actualiza la configuración (Requiere Auth/Admin). |
| **POST** | `/api/prayer-requests` | Crea una nueva petición (Público). |
| **GET** | `/api/prayer-requests` | Lista peticiones (Admin). |
| **PUT** | `/api/prayer-requests/{id}` | Actualiza estado de petición (Admin). |

## 5. Detalles de Implementación Recientes

### 5.1 Persistencia de Configuración (Settings)
Se usa un modelo `Setting` con una columna `value` tipo JSON.
*   **Controlador:** `SettingsController.php`
*   **Lógica:** Al actualizar, se hace un `merge` recursivo entre la configuración existente y la nueva para evitar pérdida de datos si el frontend envía un objeto parcial.

### 5.2 Manejo de Imágenes
*   El frontend incluye un helper `getImageUrl(url)`.
*   Detecta rutas locales (ej. `backend/public/img/...`) y las reescribe para apuntar al servidor API (`http://localhost:8000/img/...`).
*   Esto permite al usuario subir imágenes a la carpeta `public` del backend y referenciarlas fácilmente.

---

## 6. Comandos Útiles

*   **Crear migración:** `php artisan make:migration create_nombre_tabla`
*   **Limpiar caché Laravel:** `php artisan optimize:clear`
*   **Construir Frontend para Producción:** `npm run build` (Genera carpeta `dist` en frontend).
