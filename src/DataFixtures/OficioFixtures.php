<?php

namespace App\DataFixtures;

use App\Entity\Oficio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OficioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $oficios = [
            // Construcción y mantenimiento
            'Albañil',
            'Plomero',
            'Electricista',
            'Carpintero',
            'Pintor',
            'Gasista',
            'Techista',
            'Herrero',
            'Vidriero',
            'Ceramista',
            'Yesero',
            
            // Servicios del hogar
            'Jardinero',
            'Empleada doméstica',
            'Niñera',
            'Cuidador de personas',
            'Cocinero/a',
            'Lavandero/a',
            
            // Transporte y delivery
            'Chofer',
            'Remisero',
            'Fletero',
            'Delivery',
            'Mensajero',
            
            // Tecnología y reparaciones
            'Técnico en computación',
            'Técnico en celulares',
            'Técnico en refrigeración',
            'Técnico en aire acondicionado',
            'Técnico en electrodomésticos',
            'Cerrajero',
            
            // Belleza y cuidado personal
            'Peluquero/a',
            'Barbero',
            'Manicura',
            'Pedicura',
            'Masajista',
            'Cosmetólogo/a',
            'Maquillador/a',
            
            // Educación y cuidado
            'Profesor particular',
            'Profesor de inglés',
            'Profesor de música',
            'Entrenador personal',
            'Instructor de manejo',
            
            // Salud
            'Enfermero/a',
            'Cuidador geriátrico',
            'Fisioterapeuta',
            'Podólogo/a',
            
            // Eventos y entretenimiento
            'Fotógrafo',
            'Camarógrafo',
            'DJ',
            'Animador de eventos',
            'Decorador de eventos',
            'Sonidista',
            
            // Oficios varios
            'Modista/Costurero',
            'Zapatero',
            'Tapicero',
            'Mecánico',
            'Chapista',
            'Gomero',
            'Soldador',
            'Tornero',
            'Panadero',
            'Pastelero/a',
            'Carnicero',
            'Verdulero',
            
            // Servicios profesionales
            'Contador',
            'Abogado',
            'Escribano',
            'Gestor',
            'Traductor',
            'Diseñador gráfico',
            'Programador',
            'Community Manager',
        ];

        foreach ($oficios as $oficioName) {
            $oficio = new Oficio();
            $oficio->setName($oficioName);
            $oficio->setStatus(true); // Todos activos por defecto
            
            $manager->persist($oficio);
        }

        $manager->flush();
    }
}