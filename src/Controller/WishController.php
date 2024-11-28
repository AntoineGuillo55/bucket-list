<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/add', name: 'wish_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager){

        $wish = new Wish();

        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()) {

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash("success", "Your wish " . $wish->getTitle() . " has been corrctly added to your bucket list !");

            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/add.html.twig', [
            'wishForm' => $wishForm,
        ]);
    }
    #[Route('/update/{id}', name: "wish_update", requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(Wish $wish, Request $request ,EntityManagerInterface $entityManager) {

        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()) {

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash("success", "Your wish has been correctly updated !");
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/update.html.twig', [
            'wish' => $wish,
            'wishForm' => $wishForm
        ]);
    }
    #[Route('/delete/{id}', name: 'wish_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Wish $wish, EntityManagerInterface $entityManager) {

        if ($wish) {
            $entityManager->remove($wish);
            $entityManager->flush();

            $this->addFlash("success", "Your wish has been correctly removed from your bucket list !");
            return $this->redirectToRoute('wish_list');
        }

        return Response::HTTP_BAD_REQUEST;
    }
}
