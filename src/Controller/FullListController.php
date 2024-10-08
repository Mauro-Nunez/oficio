<?php

namespace App\Controller;

use App\Repository\OficioRepository;
use App\Repository\RecomendacionRepository;
use App\Repository\RegistroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FullListController extends AbstractController
{
    #[Route('/full/list', name: 'app_full_list')]
    public function index(
        OficioRepository $oficioRepository,
        RecomendacionRepository $recomendacionRepository,
        RegistroRepository $registroRepository
    ): Response {
        // Obtener todos los oficios, recomendaciones y registros
        $oficios = $oficioRepository->findAll();
        $recomendaciones = $recomendacionRepository->findAll();
        $registros = $registroRepository->findAll();

        // Pasar los datos a la vista Twig
        return $this->render('full_list/index.html.twig', [
            'oficios' => $oficios,
            'recomendaciones' => $recomendaciones,
            'registros' => $registros,
        ]);
    }
}
