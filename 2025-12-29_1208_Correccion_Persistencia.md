# Corrección de Persistencia en Configuración

**Fecha:** 29 de Diciembre de 2025
**Estado:** Solucionado

## 1. Problema Identificado
El usuario reportó que la configuración del "mensaje de éxito" no se guardaba correctamente. Al recargar la página o realizar una prueba, los cambios se perdían.

### Análisis Técnico
- El método `updateLandingSettings` en el backend recibía un JSON parcial con solo los cambios.
- Al hacer `$data = $request->all()`, y luego guardar directamente en la base de datos con `Setting::updateOrCreate(...)`, se estaba sobrescribiendo **toda** la configuración anterior con solo los datos nuevos.
- Esto provocaba que cualquier campo no enviado (como el resto de la configuración del landing) se perdiera o se reiniciara a valores nulos/vacíos en la siguiente lectura.

## 2. Solución Aplicada
Se modificó el archivo `backend/app/Http/Controllers/Api/SettingsController.php`.

**Cambio en la lógica de `updateLandingSettings`:**
1.  **Carga de Defaults:** Se define la estructura completa por defecto (igual que en `getLandingSettings`).
2.  **Recuperación Actual:** Se obtiene la configuración actual de la base de datos.
3.  **Fusión Profunda (Merge):**
    - Se mezcla `defaults` + `actual` para asegurar que tenemos todos los campos.
    - Se mezcla `resultado_anterior` + `nuevos_datos` (`$request->all()`) usando `array_replace_recursive`.
4.  **Guardado Seguro:** Se guarda el resultado final mezclado, garantizando que solo se actualicen los campos modificados sin borrar el resto.

## 3. Archivos Modificados
- `backend/app/Http/Controllers/Api/SettingsController.php`

## 4. Verificación
Ahora, cuando el frontend envía `{ "prayerRequestSuccessMessage": "Nuevo Mensaje" }`, el backend:
1.  Lee la configuración existente (ej. Hero title, colores, etc.).
2.  Actualiza solo `prayerRequestSuccessMessage`.
3.  Guarda el objeto JSON completo de nuevo.
Esto asegura la persistencia correcta de todos los ajustes.
