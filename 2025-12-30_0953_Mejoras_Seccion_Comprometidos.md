# Mejoras en Sección del Reino y Sociedad

**Fecha:** 30 de Diciembre de 2025 - 09:53 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se ha simplificado y reorganizado la sección "Comprometidos con el Reino y la Sociedad" en la landing page pública. 

## 2. Cambios Realizados

### Frontend (Landing Page)
*   **Archivo:** `frontend/src/views/Landing.vue`
*   **Sección:** "Features" (ID: `#features`)
*   **Modificaciones:**
    1.  **Eliminación de Elementos:** Se eliminaron las tarjetas decorativas de "Comunidad" (Stats) y "Seguridad" para reducir el ruido visual.
    2.  **Reorganización de Layout:** 
        *   Se cambió de un diseño asimétrico (Texto + Grid) a un diseño simétrico de **dos columnas**.
        *   Ahora las tarjetas de **"¿Qué esperar?"** y **"Labor Social"** se muestran una al lado de la otra (side-by-side) en pantallas medianas y grandes (`md:grid-cols-2`).
    3.  **Mejoras Visuales:**
        *   Se aumentó el padding interno de las tarjetas (`p-8`).
        *   Se añadieron iconos circulares con fondo para mayor jerarquía visual.
        *   Se centró el título principal de la sección.

## 3. Resultado Visual
La sección ahora presenta una apariencia más limpia y directa, enfocándose exclusivamente en los dos mensajes principales que la iglesia desea transmitir a los visitantes: su visión espiritual ("¿Qué esperar?") y su impacto en la comunidad ("Labor Social").
