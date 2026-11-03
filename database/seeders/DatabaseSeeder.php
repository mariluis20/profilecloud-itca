<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@profilecloud.local']);
        $admin->name = 'Administrador ProfileCloud';
        $admin->first_name = 'Administrador';
        $admin->last_name = 'ProfileCloud';
        $admin->password = 'Admin.Profile2026';
        $admin->role = User::ROLE_ADMIN;
        $admin->is_active = true;
        $admin->save();

        foreach ($this->students() as $data) {
            $user = User::firstOrNew(['email' => $data['email']]);
            $words = explode(' ', $data['name']);
            $user->name = $data['name'];
            $user->first_name = $words[0];
            $user->middle_name = count($words) >= 4 ? $words[1] : null;
            $user->last_name = count($words) >= 4 ? $words[2] : ($words[1] ?? null);
            $user->second_last_name = count($words) >= 4 ? $words[3] : ($words[2] ?? null);
            $user->password = 'Estudiante2026';
            $user->role = User::ROLE_STUDENT;
            $user->is_active = true;
            $user->save();

            if ($user->profile) {
                continue;
            }

            $profile = $user->profile()->create([
                'slug' => Profile::uniqueSlug($data['name']),
                'headline' => $data['headline'],
                'bio' => $data['bio'],
                'carrera' => $data['carrera'],
                'sede' => $data['sede'],
                'ciclo' => $data['ciclo'],
                'github_url' => $data['github'] ?? null,
                'linkedin_url' => $data['linkedin'] ?? null,
                'is_public' => true,
                'available' => $data['available'],
            ]);

            foreach ($data['skills'] as $name => $level) {
                $profile->skills()->create(['name' => $name, 'level' => $level]);
            }

            foreach ($data['projects'] as $project) {
                $profile->projects()->create($project);
            }
        }
    }

    private function students(): array
    {
        return [
            [
                'name' => 'Andrea Valeria Hernández López',
                'email' => 'andrea.hernandez@profilecloud.local',
                'headline' => 'Desarrolladora web full stack en formación',
                'bio' => 'Me apasiona construir aplicaciones web accesibles y rápidas. Actualmente profundizo en Laravel y en buenas prácticas de despliegue sobre Linux.',
                'carrera' => 'Ingeniería en Desarrollo de Software',
                'sede' => 'Santa Tecla',
                'ciclo' => 6,
                'available' => true,
                'github' => 'https://github.com/',
                'linkedin' => 'https://www.linkedin.com/',
                'skills' => ['Laravel' => 4, 'PHP' => 4, 'MySQL / MariaDB' => 4, 'JavaScript' => 3, 'Git' => 4, 'Bootstrap' => 5],
                'projects' => [
                    ['title' => 'Sistema de reservas de laboratorio', 'description' => 'Aplicación web para reservar laboratorios de cómputo con calendario, roles y notificaciones por correo.', 'technologies' => 'Laravel, MariaDB, Bootstrap', 'year' => 2026],
                    ['title' => 'Portal de becas estudiantiles', 'description' => 'Formulario de solicitud de becas con carga de documentos y panel de revisión para el comité.', 'technologies' => 'PHP, MySQL, JavaScript', 'year' => 2025],
                ],
            ],
            [
                'name' => 'Carlos Ernesto Martínez Ramos',
                'email' => 'carlos.martinez@profilecloud.local',
                'headline' => 'Administración de redes y servidores Linux',
                'bio' => 'Técnico enfocado en infraestructura: configuración de switches, VLAN, servidores Debian y monitoreo de servicios.',
                'carrera' => 'Técnico en Ingeniería de Redes Informáticas',
                'sede' => 'San Miguel',
                'ciclo' => 4,
                'available' => true,
                'linkedin' => 'https://www.linkedin.com/',
                'skills' => ['Linux' => 5, 'Cisco IOS' => 4, 'Apache' => 4, 'Bash' => 3, 'Firewall UFW' => 4],
                'projects' => [
                    ['title' => 'Red segmentada para PYME', 'description' => 'Diseño e implementación de una red con VLAN, DHCP y políticas de acceso para una empresa de 40 equipos.', 'technologies' => 'Cisco, Packet Tracer, VLAN', 'year' => 2026],
                ],
            ],
            [
                'name' => 'Gabriela Sofía Rivas Aguilar',
                'email' => 'gabriela.rivas@profilecloud.local',
                'headline' => 'Diseño UI y experiencia de usuario',
                'bio' => 'Diseño interfaces limpias y centradas en las personas. Me interesa que la tecnología se vea bien y se entienda mejor.',
                'carrera' => 'Técnico en Diseño Gráfico',
                'sede' => 'Santa Ana',
                'ciclo' => 5,
                'available' => false,
                'skills' => ['Figma' => 5, 'Illustrator' => 4, 'UX Research' => 3, 'HTML y CSS' => 3],
                'projects' => [
                    ['title' => 'Rediseño de app de transporte', 'description' => 'Propuesta de rediseño de una app de rutas de buses con pruebas de usabilidad con 12 usuarios.', 'technologies' => 'Figma, Prototipado', 'year' => 2026],
                    ['title' => 'Identidad visual para cafetería', 'description' => 'Logotipo, paleta de colores y piezas para redes sociales de un emprendimiento local.', 'technologies' => 'Illustrator, Photoshop', 'year' => 2025],
                ],
            ],
            [
                'name' => 'José Alberto Flores Mejía',
                'email' => 'jose.flores@profilecloud.local',
                'headline' => 'Desarrollo móvil con Flutter',
                'bio' => 'Construyo apps móviles multiplataforma conectadas a APIs REST. Busco pasantía en equipos de desarrollo ágil.',
                'carrera' => 'Técnico en Ingeniería de Sistemas Informáticos',
                'sede' => 'Santa Tecla',
                'ciclo' => 5,
                'available' => true,
                'github' => 'https://github.com/',
                'skills' => ['Flutter' => 4, 'Dart' => 4, 'Firebase' => 3, 'API REST' => 4, 'Java' => 3],
                'projects' => [
                    ['title' => 'App de control de gastos', 'description' => 'Aplicación móvil para registrar gastos personales con gráficos mensuales y respaldo en la nube.', 'technologies' => 'Flutter, Firebase', 'year' => 2026],
                ],
            ],
            [
                'name' => 'María José Castillo Pérez',
                'email' => 'maria.castillo@profilecloud.local',
                'headline' => 'Automatización y sistemas mecatrónicos',
                'bio' => 'Integro sensores, PLC y programación para automatizar procesos industriales de forma segura y eficiente.',
                'carrera' => 'Técnico en Ingeniería Mecatrónica',
                'sede' => 'Zacatecoluca',
                'ciclo' => 4,
                'available' => true,
                'skills' => ['PLC Siemens' => 4, 'Arduino' => 5, 'AutoCAD' => 3, 'Python' => 3],
                'projects' => [
                    ['title' => 'Banda clasificadora por color', 'description' => 'Prototipo de banda transportadora que clasifica piezas por color usando sensores y un PLC.', 'technologies' => 'PLC, Sensores, Arduino', 'year' => 2025],
                ],
            ],
            [
                'name' => 'Diego Alejandro Portillo Cruz',
                'email' => 'diego.portillo@profilecloud.local',
                'headline' => 'Backend y bases de datos',
                'bio' => 'Me gusta modelar datos y construir APIs robustas. Practico seguridad web y optimización de consultas SQL.',
                'carrera' => 'Ingeniería en Desarrollo de Software',
                'sede' => 'La Unión',
                'ciclo' => 3,
                'available' => true,
                'github' => 'https://github.com/',
                'skills' => ['SQL' => 4, 'Node.js' => 3, 'Laravel' => 3, 'Docker' => 2, 'Git' => 4],
                'projects' => [
                    ['title' => 'API de inventario', 'description' => 'API REST con autenticación por tokens para el control de inventario de una ferretería.', 'technologies' => 'Laravel, MariaDB, Postman', 'year' => 2026],
                    ['title' => 'Dashboard de ventas', 'description' => 'Panel con indicadores de ventas diarias y reportes exportables a CSV.', 'technologies' => 'PHP, Chart.js, MySQL', 'year' => 2025],
                ],
            ],
        ];
    }
}
