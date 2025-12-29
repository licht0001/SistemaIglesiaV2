# Manual de Usuario - SistemaIglesiaV2

**Rol:** Administrador / Pastor
**Fecha:** 29 de Diciembre de 2025

---

## 1. Acceso al Sistema

### 1.1 Sitio Público (Landing Page)
*   **URL:** `http://localhost:5173/` (o el dominio configurado).
*   **Descripción:** Es la página que ve cualquier visitante. Aquí se muestra la información general, horarios y formulario de contacto.

### 1.2 Panel Administrativo
*   **Acceso:** Haga clic en el botón "Iniciar sesión" en la esquina superior derecha del sitio público.
*   **Credenciales:** Ingrese su correo electrónico y contraseña.
*   **Dashboard:** Al ingresar, verá el panel principal con métricas y accesos directos.

---

## 2. Gestión de la Página Web (Landing Page)
Usted tiene control total sobre lo que ven los visitantes sin necesidad de llamar a un técnico.

**Ruta:** Menú Lateral -> Configuración -> **Administrar Web**

### 2.1 Secciones Editables
Encontrará un menú lateral con las siguientes opciones:
1.  **Hero Principal:** Edite el título grande y el subtítulo de bienvenida.
2.  **Carrusel:** Agregue fotos de sus actividades. Puede usar enlaces de internet o rutas locales.
3.  **Video:** Pegue un enlace de YouTube para destacar un mensaje o prédica.
4.  **Horarios:** Agregue los días y horas de sus cultos. Puede incluir una imagen de fondo opcional para cada horario.
5.  **Comunidad (Bento):** Active o desactive los bloques de "Peticiones", "Donaciones" y "Cursos".
6.  **Contacto:** Configure su número de WhatsApp, enlaces a redes sociales y el mapa de ubicación.

### 2.2 Guardar Cambios
*   Una vez realizadas las modificaciones, haga clic en el botón **"Guardar Cambios"** en la parte superior derecha.
*   El sistema le notificará con un mensaje de "Éxito".

---

## 3. Peticiones de Oración
Esta herramienta le permite recibir y gestionar las necesidades espirituales de las personas.

### 3.1 Cómo envían una petición los visitantes
1.  En la página principal, el visitante hace clic en "Enviar Petición".
2.  Completa el formulario (Nombre, Petición, Contacto). Puede ser anónimo.
3.  Al enviar, verán el mensaje de confirmación que usted haya configurado.

### 3.2 Cómo gestionar las peticiones (Administrador)
**Ruta:** Menú Lateral -> **Peticiones de Oración**

*   **Bandeja de Entrada:** Verá una lista de todas las peticiones recibidas, ordenadas por fecha.
*   **Ver Detalles:** Haga clic en el botón (icono de ojo) para leer la petición completa.
*   **Cambiar Estado:**
    *   **Pendiente:** Recién llegada.
    *   **Mencionado:** Ya se oró por ella en el culto o reunión.
    *   **Completado:** Se ha hecho seguimiento o finalizó el proceso.
*   **Configurar Mensaje de Éxito:**
    *   Haga clic en el botón **"Configurar Mensaje"** en la parte superior.
    *   Escriba el texto que desea que lean los visitantes al enviar su petición (ej. "Gracias, oraremos por ti").
    *   Guarde los cambios.

---

## 4. Configuración General
**Ruta:** Menú Lateral -> Configuración -> **Ajustes Generales**

Aquí puede definir datos básicos de la institución que se usan en reportes y encabezados:
*   Nombre de la Iglesia.
*   Moneda (Bolivianos, Dólares, etc.).
*   Zona Horaria.
*   Opciones de seguridad y copias de seguridad.

---

## 5. Solución de Problemas Comunes

*   **"No veo la imagen que subí":** Asegúrese de que la ruta sea correcta. Si la imagen está en su servidor, el sistema corregirá automáticamente rutas como `backend/public/...` pero asegúrese de que el archivo realmente exista en esa carpeta.
*   **"No se guardan mis cambios":** Verifique su conexión a internet. Si persiste, recargue la página (F5) e intente de nuevo. El sistema tiene autoguardado inteligente para no borrar datos previos.
