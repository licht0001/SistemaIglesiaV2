# Actualización: Identidad de la Iglesia

**Fecha:** 30 de Diciembre de 2025 - 09:55 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se han actualizado los textos ("copy") y los elementos visuales de la sección `#features` en la landing page para alinearlos con la identidad institucional de la iglesia (Misión y Visión).

## 2. Cambios Realizados

### Frontend (Landing Page)
*   **Archivo:** `frontend/src/views/Landing.vue`
*   **Modificaciones:**
    1.  **Título de Sección:** Cambiado de "Comprometidos con el Reino y la Sociedad" a **"Nuestra Identidad"**.
    2.  **Tarjeta Izquierda:**
        *   Título: **"Misión"** (Antes "¿Qué esperar?").
        *   Icono: **`pi-bullseye`** (Objetivo/Blanco) para representar el propósito.
        *   Contenido: Muestra el campo `whatToExpect` de la configuración.
    3.  **Tarjeta Derecha:**
        *   Título: **"Visión"** (Antes "Labor Social").
        *   Icono: **`pi-compass`** (Brújula) para representar la dirección y el futuro.
        *   Contenido: Muestra el campo `socialWork` de la configuración.
    4.  **Diseño:** Se implementó un layout **flex** donde el icono se ubica a la izquierda del bloque de texto (título + descripción) para mejorar la legibilidad y la jerarquía.

## 3. Notas Técnicas
*   Se mantienen las variables de configuración existentes (`whatToExpect` y `socialWork`) en el backend y frontend para evitar refactorizaciones innecesarias en la base de datos, simplemente se ha re-significado su uso en la interfaz pública.
