<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Recomendacion;


class RecomendacionController extends AbstractController
{
    #[Route('/crear-recomendacion', name: 'app_crear_recomendacion', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $em): Response
    {
        // Obtener el texto del formulario
        $text = $request->request->get('recomendacionText');

        // Verificar si es una petición AJAX
        $isAjax = $request->headers->get('X-Requested-With') === 'XMLHttpRequest';

        if ($text) {
            try {
                // Crear una nueva recomendación
                $recomendacion = new Recomendacion();
                $recomendacion->setText($text);
                $recomendacion->setDate(new \DateTime());

                // Guardar en la base de datos
                $em->persist($recomendacion);
                $em->flush();

                if ($isAjax) {
                    return new JsonResponse(['success' => true]);
                }

                // Añadir mensaje flash para peticiones normales
                $this->addFlash('success', 'Recomendación creada con éxito.');
            } catch (\Exception $e) {
                if ($isAjax) {
                    return new JsonResponse(['success' => false, 'error' => 'Error al guardar la recomendación']);
                }
                $this->addFlash('error', 'Error al crear la recomendación.');
            }
        } else {
            if ($isAjax) {
                return new JsonResponse(['success' => false, 'error' => 'El texto es requerido']);
            }
        }

        // Redirigir para peticiones normales
        return $this->redirectToRoute('app_oficio');
    }
}
