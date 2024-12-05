<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Wish;
use App\Form\CommentType;
use App\Form\WishType;
use App\Repository\CommentRepository;
use App\Repository\WishRepository;
use App\Service\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    public function detail(Wish $wish, Request $request, CommentRepository $commentRepository, EntityManagerInterface $entityManager, Censurator $censurator): Response {

        $comments = $commentRepository->findBy(['wish' => $wish]);

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setWish($wish);
            $comment->setContent($censurator->purify($comment->getContent()));
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', "The comment has been posted !");
            return $this->redirectToRoute('wish_detail', ["id" => $wish->getId()]);
        }

        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'WishController',
            'wish' => $wish,
            'commentForm' => $commentForm,
            'comments' => $comments
        ]);
    }

    #[Route('/add', name: 'wish_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager){

        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()) {
            $user = $this->getUser();
            if($user) {
                $wish->setUser($user);
            }
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
    #[IsGranted('WISH_EDIT', 'wish')]
    public function update(Wish $wish, Request $request ,EntityManagerInterface $entityManager) {

//        if($this->getUser()->getUserIdentifier() === $wish->getUser()->getUserIdentifier()) {
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
//        } else {
//
//            $this->addFlash('error', 'You can\'t modify this wish because you are not the owner');
//            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
//        }

    }
    #[Route('/delete/{id}', name: 'wish_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
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
