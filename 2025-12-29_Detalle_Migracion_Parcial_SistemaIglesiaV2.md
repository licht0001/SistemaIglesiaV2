# 2025-12-29_Detalle_Migracion_Parcial_SistemaIglesiaV2.md

## Estado actual de la migración (pausada)

### Backend (`SistemaIglesiaV2/backend`)
- [x] Estructura de carpetas creada:
  - app/, config/, database/ (factories, migrations, seeders), public/ (build, img/landing), resources/ (css, js, views), routes/, storage/, tests/, vendor/, .vscode/
- [x] Modelos principales copiados:
  - User.php, Member.php, Event.php, Transaction.php
- [x] Archivos de configuración base copiados:
  - composer.json, composer.lock, package.json, package-lock.json, .env, artisan, vite.config.js, phpunit.xml
- [x] Carpetas para controladores, migraciones, seeders, providers, exports creadas
- [ ] Faltan por copiar:
  - Controladores completos (app/Http/Controllers y subcarpetas)
  - Todas las migraciones, seeders y factories
  - Recursos públicos adicionales (imágenes, archivos estáticos)
  - Vistas Blade si existen
  - Otros archivos de configuración personalizados

### Frontend (`SistemaIglesiaV2/frontend`)
- [x] Estructura de carpetas creada:
  - src/ (assets, components, layouts, router, services, views), public/
- [x] Archivos principales copiados:
  - src/main.js, src/App.vue, src/router/index.js
- [x] Carpetas para componentes, vistas, layouts y servicios listas
- [ ] Faltan por copiar:
  - Todos los componentes Vue (src/components)
  - Todas las vistas Vue (src/views)
  - Layouts adicionales (src/layouts)
  - Servicios JS (src/services)
  - Assets (imágenes, íconos, etc.)
  - Archivos de configuración frontend (package.json, vite.config.js, etc.) si hay diferencias

### Estado general
- [x] Estructura base y archivos principales migrados
- [ ] Falta copiar y adaptar el resto de archivos fuente y recursos
- [ ] No se han realizado ajustes finales de rutas ni verificación funcional completa

---

_Archivo generado automáticamente por GitHub Copilot el 29/12/2025._
