<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }

    #[Route('/detail/{id}', name: 'wish_detail', methods: ['GET', 'POST'])]
    public function detail(int $id): Response {
        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }
}
