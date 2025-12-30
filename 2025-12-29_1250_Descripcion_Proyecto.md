# SistemaIglesiaV2 - Descripción Global del Proyecto

**Fecha de Generación:** 30 de Diciembre de 2025
**Versión:** 2.1 (Optimización de Identidad y Gestión)

## 1. Introducción
**SistemaIglesiaV2** es una plataforma integral de gestión eclesiástica diseñada para modernizar y simplificar la administración de una congregación. El sistema utiliza una arquitectura moderna que separa el **Backend** (API y Lógica) del **Frontend** (Interfaz de Usuario), permitiendo escalabilidad, seguridad y una experiencia de usuario fluida con una estética premium.

## 2. Arquitectura del Sistema
El proyecto se divide en dos grandes componentes independientes que se comunican a través de una API RESTful:

### A. Backend (API Core)
- **Tecnología:** Laravel 11/12 (PHP)
- **Rol:** Es el núcleo del sistema. Se encarga de la seguridad, acceso a datos, validaciones y lógica de negocio.
- **Base de Datos:** MySQL.
- **Características:**
    - Autenticación segura (Sanctum).
    - Endpoints REST para todos los recursos.
    - Manejo de almacenamiento y migraciones.

### B. Frontend (Cliente Web)
- **Tecnología:** Vue.js 3 + Vite
- **Estilos:** TailwindCSS + PrimeVue (Biblioteca de componentes con personalización profunda).
- **Rol:** Es la interfaz que utilizan los pastores, administradores y visitantes.
- **Características:**
    - **Single Page Application (SPA):** Navegación sin recargas constantes.
    - **Reactividad:** Actualizaciones en tiempo real mediante estados reactivos.
    - **Diseño Responsivo:** Optimizado para móviles, tablets y escritorio.

## 3. Módulos Principales

### 3.1 Portal Público (Landing Page)
La cara visible hacia Internet, diseñada para generar un impacto visual premium y facilitar la conexión con el visitante.
- **Header Dinámico:** Menús renombrados como "Nuestra Iglesia", "Servicios", "Identidad" y "Destacado".
- **Identidad Institucional:** Sección de **Misión** y **Visión** con iconos modernos (Diana y Brújula).
- **Galería Dinámica:** Carrusel de fotos administrable.
- **Horarios de Culto:** Servicios semanales con soporte para imágenes de fondo.
- **Comunidad Digital:** Accesos a Peticiones de Oración, Donaciones e información de cursos.
- **Contacto Avanzado:** Redes sociales con colores institucionales (FB, IG, YT, TikTok) y botón flotante de WhatsApp.

### 3.2 Panel Administrativo (Dashboard)
Área privada protegida por contraseña para el control total de la institución.
- **Métricas Impactantes:** Tarjetas estadísticas que incluyen desgloses por estado civil (**Casados, Solteros, Viudos, Divorciados**) y categorías de edad.
- **Gestión de Peticiones:** Bandeja visual con código de colores (Rojo: Pendiente, Amarillo: Mencionado, Verde: Completado).
- **Administrador Web (CMS):** Interfaz visual para editar toda la landing page.
    - Configuración detallada de visibilidad de redes sociales.
    - Edición de contenidos de identidad (Misión y Visión).
- **Módulos de Gestión Interna:**
    - **Membresía:** Modal de edición compacto y organizado por secciones (Personal, Roles y Sacramentos).
    - **Finanzas:** Registro de flujo de caja e informes anuales.
    - **Actividades:** Calendario de eventos ministeriales.

## 4. Stack Tecnológico Detallado

| Capa | Tecnologías | Descripción |
| :--- | :--- | :--- |
| **Frontend** | Vue 3, Vite, PrimeVue, TailwindCSS | Interfaz moderna, rápida y premium. |
| **Backend** | Laravel 11+, Eloquent ORM, MySQL | Lógica robusta y escalable. |
| **Comunicación** | Axios, REST JSON | Intercambio de datos eficiente. |
| **Infraestructura** | PHP 8.2+, Node.js 20+ | Requisitos del servidor moderno. |

## 5. Valor Agregado
Este sistema va más allá de un simple registro de datos; es una herramienta de **Identidad Digital**. Permite a la iglesia proyectar su visión al mundo exterior de manera profesional mientras optimiza el seguimiento pastoral mediante un desglose detallado de su membresía y necesidades de oración.
