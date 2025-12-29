# SistemaIglesiaV2 - Descripción Global del Proyecto

**Fecha de Generación:** 29 de Diciembre de 2025
**Versión:** 2.0 (Arquitectura Híbrida/Headless)

## 1. Introducción
**SistemaIglesiaV2** es una plataforma integral de gestión eclesiástica diseñada para modernizar y simplificar la administración de una congregación. El sistema utiliza una arquitectura moderna que separa el **Backend** (API y Lógica) del **Frontend** (Interfaz de Usuario), permitiendo escalabilidad, seguridad y una experiencia de usuario fluida.

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
- **Estilos:** TailwindCSS + PrimeVue (Biblioteca de componentes).
- **Rol:** Es la interfaz que utilizan los pastores, administradores y visitantes.
- **Características:**
    - **Single Page Application (SPA):** Navegación sin recargas constantes.
    - **Reactividad:** Actualizaciones en tiempo real.
    - **Diseño Responsivo:** Funciona en móviles y escritorio.

## 3. Módulos Principales

### 3.1 Portal Público (Landing Page)
La cara visible hacia Internet. Es 100% administrable sin necesidad de conocimientos técnicos.
- **Hero Section:** Mensaje de bienvenida personalizable.
- **Carrusel de Fotos:** Galería de la vida en la iglesia.
- **Horarios de Culto:** Agenda semanal visible.
- **Bento Grid:** Accesos rápidos a lo importante (Peticiones, Donaciones, Cursos).
- **Peticiones de Oración:** Formulario para que visitantes envíen sus necesidades.
- **Contacto y Mapa:** Integración con Google Maps y botón flotante de WhatsApp.

### 3.2 Panel Administrativo (Dashboard)
Área privada protegida por contraseña para la gestión interna.
- **Gestión de Peticiones:** Bandeja de entrada para oraciones. Estados: Pendiente, Mencionado, Completado.
- **Administrador Web (CMS):** Interfaz visual para editar cada texto e imagen del Landing Page.
    - Soporte para imágenes locales y URLs externas.
    - Persistencia inteligente de configuraciones.
- **Módulos de Gestión Interna:**
    - **Membresía:** Control de fichas de miembros.
    - **Finanzas:** Registro de ingresos/egresos (Diezmos, Ofrendas).
    - **Actividades:** Calendario y eventos.

## 4. Stack Tecnológico Detallado

| Capa | Tecnologías | Descripción |
| :--- | :--- | :--- |
| **Frontend** | Vue 3, Vite, PrimeVue, TailwindCSS | Interfaz moderna y rápida. |
| **Backend** | Laravel, Eloquent ORM, MySQL | Lógica robusta y segura. |
| **Comunicación** | Axios, REST JSON | Intercambio de datos estándar. |
| **Infraestructura** | PHP 8.2+, Node.js 18+ | Requisitos del servidor. |

## 5. Valor Agregado
Este sistema no solo digitaliza registros en papel, sino que crea un canal de comunicación directo con la congregación y los visitantes a través de herramientas como las Peticiones de Oración online y la integración con WhatsApp, facilitando la labor pastoral y administrativa.
