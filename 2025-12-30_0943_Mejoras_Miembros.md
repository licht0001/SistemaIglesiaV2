# Mejoras en Gestión de Miembros

**Fecha:** 30 de Diciembre de 2025 - 09:43 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se ha actualizado el formulario de creación y edición de miembros (modal) en la sección de administración para mejorar la usabilidad y organización de los datos.

## 2. Cambios Realizados

### Frontend
*   **Archivo:** `frontend/src/views/Members.vue`
*   **Modificaciones en Modal:**
    1.  **Estado Civil:** Se eliminó la restricción que lo ocultaba para categorías no adultas. Ahora el campo "Estado Civil" está disponible para edición en todos los perfiles, permitiendo correcciones o actualizaciones sin importar la categoría asignada inicialmente.
    2.  **Agrupación de Roles y Sacramentos:** Se creó una nueva sección visualmente diferenciada (fondo gris claro) al final del formulario llamada "Roles y Sacramentos".
    3.  **Checkboxes Unificados:** Los campos "Bautizado" y "Es Servidor" ahora coexisten en esta nueva sección agrupada para una selección más intuitiva de la información eclesiástica.

## 3. Rutas Afectadas
*   `/members` (Panel de Administración -> Miembros)

## 4. Notas Técnicas
*   No se requirieron cambios en el backend ya que la estructura de datos `members` ya soportaba estos campos.
