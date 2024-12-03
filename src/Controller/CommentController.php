<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/update/{id}', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $entityManager)
    {
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $wishId = $comment->getWish()->getId();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'The comment has been successfully updated');
            return $this->redirectToRoute('wish_detail', ['id' => $wishId]);
        }

        return $this->render('comment/update.html.twig', [
            'comment' => $comment,
            'commentForm' => $commentForm,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function update(Comment $comment, EntityManagerInterface $entityManager)
    {

        if ($comment) {
            $wishId = $comment->getWish()->getId();
            $entityManager->remove($comment);
            $entityManager->flush();

            $this->addFlash('success', 'The comment has been successfully removed !');
            return $this->redirectToRoute('wish_detail', ['id' => $wishId]);
        }
    }
}
