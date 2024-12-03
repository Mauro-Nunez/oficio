<?php

namespace App\Controller;

use App\Entity\Registro;
use App\Form\RegistroType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\BusquedaType;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'app_registro')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $registro = new Registro();
        $form = $this->createForm(RegistroType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registro);
            $entityManager->flush();

            // Redirigir al controlador app_send con los parámetros nombre y email
            return $this->redirectToRoute('app_send', [
                'nombre' => $registro->getName(),
                'email' => $registro->getEmail(),
            ]);
        }

        return $this->render('registro/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/buscar', name: 'app_lista')]
    public function lista(EntityManagerInterface $entityManager, Request $request): Response
    {
        $registro = new Registro();
        $form = $this->createForm(BusquedaType::class, $registro);

        $form->handleRequest($request);

        // Si se envía el formulario, buscar con los filtros aplicados
        if ($form->isSubmitted() && $form->isValid()) {
            $oficio = $registro->getOficio();
            $delegaciones = $registro->getDelegacion()->toArray();

            $lista = $entityManager->getRepository(Registro::class)->buscar($oficio, $delegaciones);

            return $this->render('registro/lista.html.twig', [
                'lista' => $lista,
                'form' => $form,
            ]);
        }

        // Filtrar registros habilitados (status = 1)
        $query = $entityManager->createQuery(
            'SELECT r 
             FROM App\Entity\Registro r
             WHERE r.status = :status'
        )->setParameter('status', true);

        $lista = $query->getResult();

        return $this->render('registro/lista.html.twig', [
            'lista' => $lista,
            'form' => $form,
        ]);
    }

    #[Route('/registro/{id}/toggle-status', name: 'registro_toggle_status', methods: ['POST'])]
    public function toggleStatus($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $registro = $entityManager->getRepository(Registro::class)->find($id);

        if (!$registro) {
            return new JsonResponse(['error' => 'Registro no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!isset($data['status'])) {
            return new JsonResponse(['error' => 'Estado no proporcionado'], 400);
        }

        $registro->setStatus($data['status']);
        $entityManager->persist($registro);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}
