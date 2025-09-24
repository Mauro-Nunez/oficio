<?php

namespace App\Controller;

use App\Entity\Registro;
use App\Form\BusquedaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $registro = new Registro();
        $form = $this->createForm(BusquedaType::class, $registro);

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}