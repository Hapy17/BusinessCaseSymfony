<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/profile')]
class UserProfileController extends AbstractController
{
    
    #[Route('/{id}', name: 'app_user_profile_show', methods: ['GET'])]
    public function show(
        User $user
    ): Response
    {
        return $this->render('front/user_profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        $userId = $user->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_profile_show',[] , Response::HTTP_SEE_OTHER);
            // TODO: redirection vers la page profil avec le parametre id de l'user
        }

        return $this->renderForm('front/user_profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_profile_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
