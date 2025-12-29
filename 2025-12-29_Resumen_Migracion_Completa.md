# Resumen de Migración y Separación de Proyecto - SistemaIglesiaV2

**Fecha:** 29 de Diciembre de 2025
**Estado:** Migración Completada

## 1. Descripción General
Se ha completado la separación del proyecto `SistemaIglesia` en dos aplicaciones independientes dentro de la carpeta `SistemaIglesiaV2`:
- **Backend:** Aplicación Laravel (API).
- **Frontend:** Aplicación Vue.js 3 con Vite (Standalone).

El proyecto original `SistemaIglesia` **NO** ha sido modificado.

## 2. Estructura del Proyecto (`SistemaIglesiaV2`)

```
SistemaIglesiaV2/
├── backend/            # Proyecto Laravel completo
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── composer.json
│   ├── .env
│   └── ...
├── frontend/           # Proyecto Vue.js + Vite independiente
│   ├── public/
│   ├── src/
│   │   ├── assets/     # Incluye css y estilos copiados
│   │   ├── components/
│   │   ├── layouts/
│   │   ├── router/
│   │   ├── services/
│   │   ├── views/
│   │   ├── App.vue
│   │   └── main.js
│   ├── index.html      # Punto de entrada creado
│   ├── package.json    # Configuración de dependencias (limpio de Laravel)
│   └── vite.config.js  # Configuración de Vite (limpio de Laravel)
└── ...
```

## 3. Acciones Realizadas

### Backend
1.  **Copia Completa:** Se copió todo el contenido de `SistemaIglesia/backend` a `SistemaIglesiaV2/backend`.
2.  **Limpieza:** Se excluyeron carpetas pesadas (`node_modules`, `vendor`, `.git`) para una instalación limpia.

### Frontend
1.  **Extracción de Código:** Se copiaron los archivos Vue de `SistemaIglesia/backend/resources/js` a `SistemaIglesiaV2/frontend/src`.
2.  **Migración de Estilos:** Se copiaron los estilos de `resources/css` a `frontend/src/assets` y se configuró su importación en `main.js`.
3.  **Configuración Standalone:**
    -   Se creó `index.html` en la raíz de `frontend` para inicializar la aplicación.
    -   Se creó un nuevo `package.json` específico para el frontend, eliminando dependencias de Laravel (ej. `laravel-vite-plugin`).
    -   Se creó un nuevo `vite.config.js` configurado para Vue.js puro.

## 4. Pasos para la Puesta en Marcha

Para ejecutar el proyecto dividido, siga estos pasos en dos terminales separadas:

### Terminal 1: Backend (Laravel)
```bash
cd SistemaIglesiaV2/backend

# 1. Instalar dependencias PHP
composer install

# 2. Configurar entorno
# Asegúrese de tener su archivo .env configurado correctamente (base de datos, etc.)
# Si no existe: copy .env.example .env y php artisan key:generate

# 3. Correr migraciones (si es necesario)
php artisan migrate

# 4. Iniciar servidor
php artisan serve
```

### Terminal 2: Frontend (Vue + Vite)
```bash
cd SistemaIglesiaV2/frontend

# 1. Instalar dependencias JS
npm install

# 2. Iniciar servidor de desarrollo
npm run dev
```

La aplicación frontend estará disponible típicamente en `http://localhost:5173` y consumirá la API del backend en `http://127.0.0.1:8000`.
