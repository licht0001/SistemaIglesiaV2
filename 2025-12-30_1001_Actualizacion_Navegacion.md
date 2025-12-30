# Actualización: Navegación y Estructura de Landing Page

**Fecha:** 30 de Diciembre de 2025 - 10:01 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Reestructuración completa del menú de navegación de la landing page y eliminación de información redundante, enfocándose en la identidad y servicios de la iglesia.

## 2. Cambios Realizados

### Frontend (Landing Page)
*   **Archivo:** `frontend/src/views/Landing.vue`
*   **Menú de Navegación (Header):**
    1.  **"Sobre el sistema"** → Renombrado a **"Nuestra Iglesia"** (Ancla: `#about`).
    2.  **"Módulos"** → Renombrado a **"Servicios"** (Ancla: `#modules`).
    3.  **"Beneficios"** → Renombrado a **"Identidad"** (Ancla: `#features`).
    4.  **"Destacado"** (Nuevo) → Enlace condicional al video de YouTube (Ancla: `#video`).
    5.  **"Contacto"** → Se mantiene igual.

*   **Secciones de Contenido:**
    1.  **Eliminación:** Se eliminó por completo la sección **"Módulos Principales"**, ya que esta información estaba más orientada a vender el software y no a la iglesia en sí.
    2.  **Identificador de Video:** Se agregó el atributo `id="video"` a la sección del video de YouTube para permitir el desplazamiento suave (scroll) desde el menú de navegación.

## 3. Notas Técnicas
*   El enlace "Destacado" solo aparece si existe una URL de video configurada en el backend, manteniendo la interfaz limpia si no hay contenido destacado.
*   Las anclas (`#about`, `#modules`, etc.) siguen funcionando con los mismos IDs en las secciones, solo cambió el texto visible para el usuario.
