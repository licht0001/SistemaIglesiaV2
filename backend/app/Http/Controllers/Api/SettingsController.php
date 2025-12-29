<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $defaults = [
            'churchName' => 'Iglesia',
            'denomination' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'website' => '',
            'currency' => 'Bolivianos (Bs)',
            'timezone' => 'America/La_Paz',
            'messaging' => [
                'countryPrefix' => '591',
                'birthdayTemplate' => '¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}',
            ],
            'notifications' => [
                'emailEnabled' => true,
                'whatsappEnabled' => true,
                'newMemberAlert' => true,
                'monthlyReportAlert' => true,
            ],
            'security' => [
                'sessionTimeout' => 120,
                'failedAttemptsLimit' => 5,
                'passwordCompliance' => 'medium',
                'maintenanceMode' => false,
            ],
            'database' => [
                'autoBackup' => true,
                'backupFrequency' => 'Semanal',
                'lastBackup' => null,
            ],
        ];

        $setting = Setting::where('key', 'app')->first();
        if ($setting) {
            return response()->json(array_replace_recursive($defaults, $setting->value));
        }

        return response()->json($defaults);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'churchName' => 'nullable|string|max:255',
            'denomination' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:50',
            'timezone' => 'nullable|string|max:100',
            'messaging' => 'nullable|array',
            'notifications' => 'nullable|array',
            'security' => 'nullable|array',
            'database' => 'nullable|array',
        ]);

        $setting = Setting::updateOrCreate(
            ['key' => 'app'],
            ['value' => $data]
        );

        return response()->json($setting->value);
    }

    public function getLandingSettings()
    {
        $defaults = [
            'hero' => [
                'title' => 'Administra tu iglesia en un solo lugar',
                'subtitle' => 'Gestión integral de tu congregación desde cualquier dispositivo.',
                'backgroundImage' => null,
            ],
            'carousel' => [
                ['url' => 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?q=80&w=2073', 'title' => 'Nuestra Comunidad', 'subtitle' => 'Unidos en fe y esperanza'],
                ['url' => 'https://images.unsplash.com/photo-1544427928-14203fb72291?q=80&w=2070', 'title' => 'Eventos Especiales', 'subtitle' => 'Momentos de adoración compartida'],
            ],
            'video' => [
                'youtubeUrl' => '',
                'title' => 'Último Mensaje',
            ],
            'testimonials' => [
                ['name' => 'Juan Pérez', 'role' => 'Miembro', 'content' => 'Este sistema ha cambiado la forma en que nos organizamos.'],
            ],
            'schedules' => [
                ['day' => 'Domingo', 'time' => '10:00 AM', 'title' => 'Culto General', 'showImage' => false, 'imageUrl' => ''],
                ['day' => 'Miércoles', 'time' => '07:30 PM', 'title' => 'Célula de Oración', 'showImage' => false, 'imageUrl' => ''],
            ],
            'info' => [
                'whatToExpect' => 'En nuestras reuniones encontrarás música inspiradora, un ambiente familiar y un mensaje práctico centrado en la Biblia.',
                'socialWork' => 'Nuestra iglesia está comprometida con la comunidad a través de comedores populares y visitas a hospitales.',
            ],
            'bento' => [
                'showPrayer' => true,
                'showDonations' => true,
                'showCourses' => true,
                'donationsInfo' => 'Puedes realizar tus aportaciones en la cuenta Banco XYZ: 123456789',
            ],
            'contact' => [
                'showMap' => true,
                'googleMapsEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.4674796332616!2d-68.1258!3d-16.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDMwJzAwLjAiUyA2OMKwMDcnMzIuOSJX!5e0!3m2!1ses!2sbo!4v1703428800000!5m2!1ses!2sbo',
                'whatsapp' => '',
                'whatsappMessage' => 'Hola, quisiera más información sobre la iglesia.',
                'facebook' => '',
                'instagram' => '',
            ],
            'prayerRequestSuccessMessage' => 'Estaremos orando por ti. ¡Dios te bendiga!',
        ];

        $setting = Setting::where('key', 'landing')->first();
        if ($setting) {
            return response()->json(array_replace_recursive($defaults, $setting->value));
        }

        return response()->json($defaults);
    }

    public function updateLandingSettings(Request $request)
    {
        $data = $request->all();

        // Obtener configuración actual o defaults si no existe
        $defaults = [
            'hero' => [
                'title' => 'Administra tu iglesia en un solo lugar',
                'subtitle' => 'Gestión integral de tu congregación desde cualquier dispositivo.',
                'backgroundImage' => null,
            ],
            'carousel' => [
                ['url' => 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?q=80&w=2073', 'title' => 'Nuestra Comunidad', 'subtitle' => 'Unidos en fe y esperanza'],
                ['url' => 'https://images.unsplash.com/photo-1544427928-14203fb72291?q=80&w=2070', 'title' => 'Eventos Especiales', 'subtitle' => 'Momentos de adoración compartida'],
            ],
            'video' => [
                'youtubeUrl' => '',
                'title' => 'Último Mensaje',
            ],
            'testimonials' => [
                ['name' => 'Juan Pérez', 'role' => 'Miembro', 'content' => 'Este sistema ha cambiado la forma en que nos organizamos.'],
            ],
            'schedules' => [
                ['day' => 'Domingo', 'time' => '10:00 AM', 'title' => 'Culto General', 'showImage' => false, 'imageUrl' => ''],
                ['day' => 'Miércoles', 'time' => '07:30 PM', 'title' => 'Célula de Oración', 'showImage' => false, 'imageUrl' => ''],
            ],
            'info' => [
                'whatToExpect' => 'En nuestras reuniones encontrarás música inspiradora, un ambiente familiar y un mensaje práctico centrado en la Biblia.',
                'socialWork' => 'Nuestra iglesia está comprometida con la comunidad a través de comedores populares y visitas a hospitales.',
            ],
            'bento' => [
                'showPrayer' => true,
                'showDonations' => true,
                'showCourses' => true,
                'donationsInfo' => 'Puedes realizar tus aportaciones en la cuenta Banco XYZ: 123456789',
            ],
            'contact' => [
                'showMap' => true,
                'googleMapsEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.4674796332616!2d-68.1258!3d-16.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDMwJzAwLjAiUyA2OMKwMDcnMzIuOSJX!5e0!3m2!1ses!2sbo!4v1703428800000!5m2!1ses!2sbo',
                'whatsapp' => '',
                'whatsappMessage' => 'Hola, quisiera más información sobre la iglesia.',
                'facebook' => '',
                'instagram' => '',
            ],
            'prayerRequestSuccessMessage' => 'Estaremos orando por ti. ¡Dios te bendiga!',
        ];

        $current = Setting::where('key', 'landing')->first();
        $currentValue = $current ? array_replace_recursive($defaults, $current->value) : $defaults;

        // Mezclar los nuevos datos con los existentes para no perder configuración
        $newValue = array_replace_recursive($currentValue, $data);

        $setting = Setting::updateOrCreate(
            ['key' => 'landing'],
            ['value' => $newValue]
        );

        return response()->json($setting->value);
    }
}
