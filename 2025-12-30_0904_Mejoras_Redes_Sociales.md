# Mejoras en Gestión de Redes Sociales

**Fecha:** 30 de Diciembre de 2025 - 09:04 AM
**Estado:** Implementado

## 1. Descripción del Cambio
Se ha actualizado el módulo de "Administrar Web" (Landing Settings) para incluir soporte completo para **YouTube** y **TikTok**, además de mejorar la gestión de Facebook e Instagram. Ahora cada red social cuenta con un interruptor (switch) independiente para decidir si se muestra o no en el sitio público, sin necesidad de borrar la URL.

Adicionalmente, se ha rediseñado el pie de página (footer) de la página pública para mostrar los iconos de las redes sociales activos con un tamaño mayor y respetando sus colores de marca originales (Azul, Rosa, Rojo, Negro).

## 2. Archivos Modificados

### Backend
*   **Archivo:** `backend/app/Http/Controllers/Api/SettingsController.php`
    *   **Cambio:** Se actualizaron los arrays `$defaults` en los métodos `getLandingSettings` y `updateLandingSettings` para incluir las nuevas claves:
        *   `youtube`, `showYoutube`
        *   `tiktok`, `showTiktok`
        *   `showFacebook`, `showInstagram` (nuevos toggles)

### Frontend (Administración)
*   **Archivo:** `frontend/src/views/LandingSettings.vue`
    *   **Ruta:** `/landing-settings` (Requiere Auth)
    *   **Cambio:** 
        *   Se actualizó la interfaz de la pestaña `contact`.
        *   Se añadieron campos de entrada para YouTube y TikTok.
        *   Se incorporaron componentes `InputSwitch` para cada red social.
        *   Se mejoró la organización visual con separadores.

### Frontend (Público)
*   **Archivo:** `frontend/src/views/Landing.vue`
    *   **Ruta:** `/` (Home)
    *   **Cambio:**
        *   Se actualizó el objeto reactivo `config` para soportar las nuevas propiedades y se corrigió la lógica de inicialización para valores por defecto.
        *   Se reescribió la sección `<footer>`.
        *   Se implementó renderizado condicional (`v-if`) basado en los toggles `showX`.
        *   **Mejora Visual:** Se aumentó el tamaño de los iconos en el footer en un **60%** (de `text-2xl` a `text-[40px]`) para mayor visibilidad y se ajustó el espaciado (`gap-6`).
        *   Estilos actualizados: Efectos `hover:scale-110` y colores de marca.

## 3. Previos pasos para probar
1.  Ingresar al sistema como Administrador.
2.  Ir a **Configuración -> Administrar Web**.
3.  Seleccionar la pestaña **Información de Contacto**.
4.  Llenar las URLs de YouTube o TikTok y activar sus interruptores.
5.  Guardar cambios.
6.  Ir a "Ver Sitio Público" y bajar hasta el pie de página para confirmar los nuevos iconos.
