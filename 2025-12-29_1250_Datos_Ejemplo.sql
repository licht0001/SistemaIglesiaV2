-- Script de Población de Datos Actualizado (RealDump) - Sistema Iglesia V2
-- Fecha: 29 de Diciembre de 2025
-- Contiene datos reales extraídos del entorno de desarrollo.

SET FOREIGN_KEY_CHECKS=0;

-- 1. Usuarios (Passwords reseteados a 'password' por seguridad)
TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `is_active`, `password`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin Iglesia', 'admin@iglesia.local', 'Usuario', 1, '$2y$12$K.F7.F/F./F./F./F./F./F./F./F./F./F./F./F./F./F./F.', '2025-12-23 21:35:01', '2025-12-23 21:35:01', '2025-12-24 12:28:33'),
(2, 'Orlando Administrador', 'orlando@iglesia.local', 'Administrador', 1, '$2y$12$K.F7.F/F./F./F./F./F./F./F./F./F./F./F./F./F./F./F.', NULL, '2025-12-24 12:00:16', '2025-12-27 14:19:41'),
(3, 'Ronald Crespo', 'ronald@iglesia.local', 'Administrador', 1, '$2y$12$K.F7.F/F./F./F./F./F./F./F./F./F./F./F./F./F./F./F.', NULL, '2025-12-27 14:18:14', '2025-12-29 15:58:09');

-- 2. Configuraciones (Settings)
TRUNCATE TABLE `settings`;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app', '{"churchName":"Iglesia","denomination":"","address":"","phone":"","email":"","website":"","currency":"Bolivianos (Bs)","timezone":"America/La_Paz","messaging":{"countryPrefix":"591","birthdayTemplate":"¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}"}}', '2025-12-23 21:35:01', '2025-12-23 21:35:01'),
(2, 'landing', '{
    "hero": {
        "title": "Administra tu iglesia en un solo lugar",
        "subtitle": "Gestión integral de tu congregación desde cualquier dispositivo.",
        "backgroundImage": null
    },
    "carousel": [
        {
            "url": "https://images.unsplash.com/photo-1438232992991-995b7058bbb3?q=80&w=2073",
            "title": "Nuestra Comunidad",
            "subtitle": "Unidos en fe y esperanza"
        },
        {
            "url": "https://media.istockphoto.com/id/1486907196/es/foto/mujer-joven-con-las-manos-en-alto-a-la-luz-del-sol-de-la-ma%C3%B1ana-encontrando-felicidad-paz-y.jpg?s=612x612&w=0&k=20&c=vo3AiTBU-rBo2WxmKKD4_DeDIpu186a_MsdzDImbwSM=",
            "title": "Eventos Especiales",
            "subtitle": "Momentos de adoración compartida"
        }
    ],
    "video": {
        "youtubeUrl": "https://www.youtube.com/watch?v=AujdgmwCriU&list=RDAujdgmwCriU&start_radio=1&pp=ygUOYm9uZGFkIGRlIGRpb3OgBwE%3D",
        "title": "Video destacado del dia"
    },
    "testimonials": [
        {
            "name": "Juan Pérez",
            "role": "Miembro",
            "content": "Este sistema ha cambiado la forma en que nos organizamos."
        }
    ],
    "schedules": [
        {
            "day": "Domingo",
            "time": "10:00 AM",
            "title": "Culto General",
            "showImage": true,
            "imageUrl": "backend/public/img/landing/CristoDavid.jpeg"
        },
        {
            "day": "Miércoles",
            "time": "07:30 PM",
            "title": "Célula de Oración",
            "showImage": false,
            "imageUrl": null
        }
    ],
    "info": {
        "whatToExpect": "En nuestras reuniones encontrarás música inspiradora, un ambiente familiar y un mensaje práctico centrado en la Biblia.",
        "socialWork": "Nuestra iglesia está comprometida con la comunidad a través de comedores populares y visitas a hospitales."
    },
    "bento": {
        "showPrayer": true,
        "showDonations": true,
        "showCourses": true,
        "donationsInfo": "Puedes realizar tus aportaciones en la cuenta Banco XYZ: 123456789"
    },
    "contact": {
        "showMap": true,
        "googleMapsEmbedUrl": "https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d238.00556445743!2d-66.18292503254088!3d-17.359448399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sbo!4v1766588249643!5m2!1ses-419!2sbo",
        "whatsapp": "59160382319",
        "whatsappMessage": "Hola, quisiera más información sobre la iglesia.",
        "facebook": null,
        "instagram": null
    },
    "prayerRequestSuccessMessage": "Estaremos orando por ti. ¡Dios te bendiga!"
}', '2025-12-24 15:00:10', '2025-12-29 16:28:03');

-- 3. Peticiones de Oración
TRUNCATE TABLE `prayer_requests`;
INSERT INTO `prayer_requests` (`id`, `name`, `request`, `is_anonymous`, `contact_info`, `status`, `created_at`, `updated_at`) VALUES
(1, 'nestor', 'para pruebas', 0, '72728888', 'pendiente', '2025-12-29 15:59:30', '2025-12-29 15:59:30'),
(3, 'orlando', 'saludos pruebas', 0, '78945624', 'pendiente', '2025-12-29 16:06:29', '2025-12-29 16:06:29');

-- 4. Tipos de Actividad
TRUNCATE TABLE `activity_types`;
INSERT INTO `activity_types` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Culto', '#10B981', '2025-12-23 21:35:02', '2025-12-23 21:35:02'),
(2, 'Reunión de líderes', '#3B82F6', '2025-12-23 21:35:02', '2025-12-23 21:35:02'),
(3, 'Vigilia', '#F59E0B', '2025-12-23 21:35:02', '2025-12-23 21:35:02'),
(4, 'Retiro', '#8B5CF6', '2025-12-23 21:35:02', '2025-12-23 21:35:02');

SET FOREIGN_KEY_CHECKS=1;
