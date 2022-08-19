<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\Filter\UserFilterType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

#[Route('/admin/user')]
class UserBackController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_back_index', methods: ['GET'])]
    public function index(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request,
        FilterBuilderUpdaterInterface $builderUpdater
        ): Response

    {

        $qb = $userRepository->getQbAll();

        $filterForm = $this->createForm(UserFilterType::class, null, [
            'method' => 'GET',
        ]);

        if($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->all($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $users = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('back/user_back/index.html.twig', [
            'users' => $users,
            'filters' => $filterForm->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_admin_user_back_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user_back/show.html.twig', [
            'user' => $user,
        ]);
    }

    // #[Route('/new', name: 'app_user_back_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, UserRepository $userRepository): Response
    // {
    //     $user = new User();
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRepository->add($user, true);

    //         return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('user_back/new.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }


    // #[Route('/{id}/edit', name: 'app_user_back_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRepository->add($user, true);

    //         return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('user_back/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_user_back_delete', methods: ['POST'])]
    // public function delete(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $userRepository->remove($user, true);
    //     }

    //     return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
    // }
}
