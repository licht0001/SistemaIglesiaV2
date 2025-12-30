# Mejoras en Dashboard y Desglose de Estado Civil

**Fecha:** 30 de Diciembre de 2025 - 09:49 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se han añadido nuevas tarjetas estadísticas en el Dashboard principal para desglosar la información de los miembros adultos por estado civil de manera más detallada y accesible.

## 2. Cambios Realizados

### Frontend (Dashboard)
*   **Archivo:** `frontend/src/views/Dashboard.vue`
*   **Nuevas Tarjetas:**
    1.  **Viudos:**
        *   **Icono:** `pi-minus-circle` (Con animación de rotación al hacer hover).
        *   **Color:** Gris (`gray-600` / `gray-50`).
        *   **Filtro:** Muestra miembros con categoría `adulto` y estado civil `widowed`.
    2.  **Divorciados/Separados:**
        *   **Icono:** `pi-sort-alt-slash` (Alternativo para representar separación/ruptura).
        *   **Color:** Naranja (`orange-500` / `orange-50`).
        *   **Filtro:** Muestra miembros con categoría `adulto` y estado civil `divorced`.

*   **Funcionalidad:**
    *   Ambas tarjetas son interactivas (`clickable`).
    *   Al hacer clic, abren el modal de detalle filtrando la lista de miembros correspondientes.

## 3. Rutas Afectadas
*   `/dashboard` (Panel Principal)

## 4. Notas Técnicas
*   El backend ya devolvía estos contadores dentro del objeto `breakdown` (`adults_widowed`, `adults_divorced`), por lo que la implementación fue netamente visual en el frontend.
