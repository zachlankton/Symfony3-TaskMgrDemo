<?php

namespace App\Controller;

use App\Entity\Todos;
use App\Form\TodosType;
use App\Repository\TodosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TodosController extends Controller
{
    /**
     * @Route("/", name="todos_index", methods={"GET", "POST"})
     */
    public function index(TodosRepository $todosRepository, Request $request): Response
    {
        $todo = new Todos();
        $form = $this->createForm(TodosType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('todos_index');
        }

        return $this->render('todos/index.html.twig', [
            'todos' => $todosRepository->findAll(),
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="todos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Todos $todo): Response
    {
        $form = $this->createForm(TodosType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todos_index');
        }

        return $this->render('todos/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="todos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Todos $todo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($todo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('todos_index');
    }
}
