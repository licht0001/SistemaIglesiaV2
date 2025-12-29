# Corrección de Conexión Frontend-Backend y Rutas

**Fecha:** 29 de Diciembre de 2025
**Hora:** 11:53 AM
**Estado:** Solucionado

## 1. Diagnóstico del Problema
Al separar el proyecto en dos aplicaciones independientes (Frontend Standalone y Backend API), surgieron los siguientes problemas de acceso:
- **Frontend (Visual):** Se intentaba acceder vía puerto 8000, pero Vite corre por defecto en el puerto 5173.
- **Backend (Datos):** El puerto 8000 seguía configurado para servir vistas web (`return view('app')`) que ya no existen en el contexto de la API, generando errores al intentar cargar la página.
- **Conectividad:** Faltaba la configuración de "Proxy" en el servidor de desarrollo de Vite para redirigir las peticiones `/api` hacia el backend Laravel.

## 2. Soluciones Aplicadas

### En el Backend (`SistemaIglesiaV2/backend`)
- **Archivo modificado:** `routes/web.php`
- **Cambio:** Se eliminó la ruta que servía la vista HTML `app`.
- **Nuevo comportamiento:** La ruta raíz (`/`) ahora devuelve una respuesta JSON indicando el estado del servicio:
  ```json
  {
      "message": "Sistema Iglesia API is running",
      "status": "OK"
  }
  ```
  Esto confirma que el servicio de datos está activo sin intentar renderizar interfaz gráfica.

### En el Frontend (`SistemaIglesiaV2/frontend`)
- **Archivo modificado:** `vite.config.js`
- **Cambio:** Se agregó la configuración de `server.proxy`.
- **Detalle Técnico:**
  ```javascript
  proxy: {
      '/api': {
          target: 'http://127.0.0.1:8000', // Redirige al backend Laravel
          changeOrigin: true,
          headers: {
              Accept: 'application/json',
              "Content-Type": "application/json",
          },
      },
  }
  ```
  Esto permite que cuando el frontend solicite `/api/usuarios`, Vite lo redirija transparentemente a `http://127.0.0.1:8000/api/usuarios`, evitando problemas de CORS y rutas no encontradas.

## 3. Instrucciones de Ejecución Actualizadas

Para visualizar la aplicación correctamente, es necesario seguir este nuevo flujo:

1.  **Reiniciar Frontend:**
    - Detenga la terminal de `npm run dev`.
    - Vuelva a ejecutar `npm run dev` para aplicar la nueva configuración del proxy.

2.  **Puntos de Acceso:**
    - **Sitio Web (Landing / App):** [http://localhost:5173](http://localhost:5173)
    - **Panel Administrativo:** [http://localhost:5173/login](http://localhost:5173/login)
    - **API Status (Backend):** [http://localhost:8000](http://localhost:8000) (Solo devolverá JSON)

## 4. Próximos Pasos (Validación)
- Verificar que el login funciona correctamente redirigiendo al Dashboard.
- Confirmar que los datos dinámicos (noticias, eventos) carguen en la Landing Page desde la API.
