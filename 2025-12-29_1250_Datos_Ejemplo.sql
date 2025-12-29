-- Script de Población de Datos (Seed) - Sistema Iglesia V2
-- Fecha: 29 de Diciembre de 2025

SET FOREIGN_KEY_CHECKS=0;

-- 1. Insertar Usuario Administrador por defecto
-- Password es 'password' (hash bcrypt típico de Laravel)
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
('Administrador', 'admin@iglesia.com', NOW(), '$2y$12$K.F7.F/F./F./F./F./F./F./F./F./F./F./F./F./F./F./F.', 'admin', 'active', NOW(), NOW());

-- 2. Insertar Configuración del Landing Page (Default Settings)
-- Se inserta el JSON completo con la estructura que usa el frontend
INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('landing', 
'{
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
            "url": "https://images.unsplash.com/photo-1544427928-14203fb72291?q=80&w=2070",
            "title": "Eventos Especiales",
            "subtitle": "Momentos de adoración compartida"
        }
    ],
    "video": {
        "youtubeUrl": "",
        "title": "Último Mensaje"
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
            "showImage": false,
            "imageUrl": ""
        },
        {
            "day": "Miércoles",
            "time": "07:30 PM",
            "title": "Célula de Oración",
            "showImage": false,
            "imageUrl": ""
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
        "googleMapsEmbedUrl": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.4674796332616!2d-68.1258!3d-16.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDMwJzAwLjAiUyA2OMKwMDcnMzIuOSJX!5e0!3m2!1ses!2sbo!4v1703428800000!5m2!1ses!2sbo",
        "whatsapp": "",
        "whatsappMessage": "Hola, quisiera más información sobre la iglesia.",
        "facebook": "",
        "instagram": ""
    },
    "prayerRequestSuccessMessage": "Estaremos orando por ti. ¡Dios te bendiga!"
}', NOW(), NOW());

-- 3. Insertar Peticiones de Oración de Ejemplo
INSERT INTO `prayer_requests` (`name`, `request`, `is_anonymous`, `contact_info`, `status`, `created_at`, `updated_at`) VALUES
('María López', 'Pido oración por la salud de mi padre que está en el hospital.', 0, '555-1234', 'pendiente', NOW(), NOW()),
('Anónimo', 'Por un problema familiar difícil de resolver. Necesito sabiduría.', 1, NULL, 'pendiente', NOW(), NOW()),
('Carlos Ruiz', 'Agradecimiento por el nuevo trabajo que conseguí después de meses.', 0, 'carlos@email.com', 'mensionado', DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
('Ana Torrez', 'Oración por mi hijo que viaja al extranjero.', 0, '555-9876', 'completado', DATE_SUB(NOW(), INTERVAL 5 DAY), NOW());

-- 4. Insertar Tipos de Actividad Básicos
INSERT INTO `activity_types` (`name`, `color`, `created_at`, `updated_at`) VALUES
('Culto General', '#10B981', NOW(), NOW()),
('Reunión de Jóvenes', '#3B82F6', NOW(), NOW()),
('Escuela Dominical', '#F59E0B', NOW(), NOW()),
('Ensayo de Alabanza', '#8B5CF6', NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
