# Corrección de Rutas para Imágenes Locales

**Fecha:** 29 dem Diciembre de 2025
**Estado:** Solucionado

## 1. Problema Identificado
El usuario intentaba configurar una imagen local usando la ruta `backend//public/img/landing/CristoDavid.jpeg`.
Esta ruta no era reconocida por el navegador porque:
1.  Contenía un doble slash `//` y una referencia al sistema de archivos local o estructura de carpetas (`backend/public`) que no es accesible directamente desde la URL del frontend (puerto 5173).
2.  El frontend no sabía que debía solicitar esa imagen al servidor del backend (puerto 8000).

## 2. Solución Aplicada
Se implementó una función auxiliar `getImageUrl` tanto en el panel de administración (`LandingSettings.vue`) como en la vista pública (`Landing.vue`).

**Lógica de `getImageUrl`:**
1.  Si la URL comienza con `http` o `https` (ej. imagen externa de Unsplash), se usa tal cual.
2.  Si es una ruta local, se realizan las siguientes limpiezas automáticamente:
    - Se convierten backslashes `\` a slashes `/`.
    - Se eliminan prefijos erróneos comunes como `backend/public/` o `backend//public/`.
    - Se asegura que la ruta comience con `/`.
3.  Se añade el prefijo del backend `http://127.0.0.1:8000` para que el navegador sepa dónde encontrar el archivo.

### Ejemplo de Conversión Automática:
- **Entrada (Usuario):** `backend//public/img/landing/CristoDavid.jpeg`
- **Limpieza Interna:** `/img/landing/CristoDavid.jpeg`
- **Resultado Final (Navegador):** `http://127.0.0.1:8000/img/landing/CristoDavid.jpeg`

## 3. Archivos Modificados
- `frontend/src/views/LandingSettings.vue`: Previsualización en tiempo real en el admin.
- `frontend/src/views/Landing.vue`: Visualización en el sitio público.

## 4. Instrucciones para el Usuario
Puede continuar introduciendo las rutas tal como lo estaba haciendo (ej. `backend/public/img/...`) o usar la ruta relativa corta (`/img/landing/...`). El sistema ahora entenderá ambas y mostrará la imagen correctamente.
