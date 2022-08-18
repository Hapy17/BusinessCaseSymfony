<?php

namespace App\Controller\Back;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/gender')]
class GenderController extends AbstractController
{
    #[Route('/', name: 'app_admin_gender_index', methods: ['GET'])]
    public function index(GenderRepository $genderRepository): Response
    {
        return $this->render('back/gender/index.html.twig', [
            'genders' => $genderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_gender_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenderRepository $genderRepository): Response
    {
        $gender = new Gender();
        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genderRepository->add($gender, true);

            return $this->redirectToRoute('app_admin_gender_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/gender/new.html.twig', [
            'gender' => $gender,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_gender_show', methods: ['GET'])]
    public function show(Gender $gender): Response
    {
        return $this->render('back/gender/show.html.twig', [
            'gender' => $gender,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_gender_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gender $gender, GenderRepository $genderRepository): Response
    {
        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genderRepository->add($gender, true);

            return $this->redirectToRoute('app_admin_gender_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/gender/edit.html.twig', [
            'gender' => $gender,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_gender_delete', methods: ['POST'])]
    public function delete(Request $request, Gender $gender, GenderRepository $genderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gender->getId(), $request->request->get('_token'))) {
            $genderRepository->remove($gender, true);
        }

        return $this->redirectToRoute('app_admin_gender_index', [], Response::HTTP_SEE_OTHER);
    }
}
