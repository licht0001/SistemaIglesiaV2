# SistemaIglesiaV2

**Sistema de Gestión Eclesiástica Moderna (Híbrido/Headless)**

Este proyecto es una plataforma integral para la administración de iglesias, dividida en dos componentes principales:

1.  **Backend (API):** Laravel (PHP)
2.  **Frontend (Cliente):** Vue.js 3 + PrimeVue (SPA)

## 📋 Descripción

**SistemaIglesiaV2** moderniza la gestión de congregaciones permitiendo:
*   Administración de miembros, finanzas y actividades.
*   Portal público (Landing Page) totalmente administrable.
*   Sistema de Peticiones de Oración y contacto.
*   Arquitectura escalable y segura.

## 🚀 Inicio Rápido

### Requisitos
*   PHP 8.2+
*   Composer
*   Node.js 18+
*   MySQL

### Instalación

#### 1. Backend
```bash
cd backend
composer install
cp .env.example .env
# Configurar base de datos en .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=DatabaseSeeder # O usar el script SQL provisto
php artisan serve
```

#### 2. Frontend
```bash
cd frontend
npm install
npm run dev
```

Visita `http://localhost:5173` para el frontend y `http://localhost:8000` para la API.

## 📂 Estructura del Repositorio

*   `/backend`: Código fuente de Laravel (API REST).
*   `/frontend`: Código fuente de Vue.js (Interfaz de Usuario).
*   `/*.md`: Documentación del proyecto.
*   `/*.sql`: Scripts de base de datos y datos de ejemplo.

## 📖 Documentación
Consulta los archivos Markdown adjuntos para más detalles:
*   `2025-12-29_1250_Manual_Usuario.md`: Guía para administradores.
*   `2025-12-29_1250_Manual_Tecnico.md`: Guía para desarrolladores.
*   `2025-12-29_1250_Descripcion_Proyecto.md`: Visión general.

## 👤 Autor
Desarrollado para facilitar la gestión ministerial.
