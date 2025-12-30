# Mejoras Visuales en Peticiones de Oración

**Fecha:** 30 de Diciembre de 2025 - 09:23 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se han actualizado los colores indicativos (severidades) de los estados en la gestión de **Peticiones de Oración** para mejorar la identificación visual rápida del proceso de atención.

## 2. Cambios en Estados

| Estado | Color Anterior | Nuevo Color | Significado |
| :--- | :--- | :--- | :--- |
| **Pendiente** | Naranja (Warning) | **Rojo (Danger)** | Requiere atención inmediata. |
| **Mencionado** | Azul (Info) | **Amarillo (Warning)** | La petición ha sido leída o mencionada, en proceso. |
| **Completado** | Verde (Success) | **Verde (Success)** | La petición ha sido atendida completamente. |

## 3. Archivos Modificados

### Frontend (Panel Administrativo)
*   **Archivo:** `frontend/src/views/PrayerRequests.vue`
    *   **Función:** `getStatusSeverity`
    *   **Cambio:** Se actualizó el mapeo de severidades para los tags de PrimeVue.
        *   `pendiente` -> `danger`
        *   `mensionado` -> `warning`
        *   `completado` -> `success`

## 4. Notas Técnicas
Este cambio afecta visualmente a la columna "Estado" en la tabla principal y al selector de estado dentro del modal de detalles. No se ha modificado la lógica de negocio ni las bases de datos.
