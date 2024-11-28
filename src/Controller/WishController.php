<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list', methods: ['GET', 'POST'])]
    public function index(WishRepository $wishRepository): Response
    {

        $wishes = $wishRepository->findAllRecentFirst();

        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
            'wishes' => $wishes,
        ]);
    }

    #[Route('/detail/{id}', name: 'wish_detail', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function detail(Wish $wish): Response {

        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'WishController',
            'wish' => $wish,
        ]);
    }
}
