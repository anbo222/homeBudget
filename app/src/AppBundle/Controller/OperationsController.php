<?php
/**
 * Bookmarks controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Operation;
use AppBundle\Form\OperationType;
use AppBundle\Repository\OperationsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OperationsController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/operations")
 */
class OperationsController extends Controller
{
    /**
     * Operations repository.
     *
     * @var \AppBundle\Repository\OperationsRepository|null Operation repository
     */
    protected $operationsRepository = null;

    /**
     * OperationsController constructor.
     *
     * @param \AppBundle\Repository\OperationsRepository $operationsRepository Bookmark repository
     */
    public function __construct(OperationsRepository $operationsRepository)
    {
        $this->operationsRepository = $operationsRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="operations_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="operations_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $operations = $this->operationsRepository->findAllPaginated($page);

        return $this->render(
            'operations/index.html.twig',
            ['operations' => $operations]
        );
    }

    /**
     * View action.
     *
     * @param Operation $operation Operation entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="operations_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Operation $operation)
    {
        return $this->render(
            'operations/view.html.twig',
            ['operation' => $operation]
        );
    }

    /**
     * Add action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/add",
     *     name="operations_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationsRepository->save($operation);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('operations_index');
        }

        return $this->render(
            'operations/add.html.twig',
            [
                'operation' => $operation,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP        Request
     * @param \AppBundle\Entity\Operation               $operation  Operation  entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="operations_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Operation $operation)
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationsRepository->save($operation);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('operations_index');
        }

        return $this->render(
            'operations/edit.html.twig',
            [
                'operation' => $operation,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP       Request
     * @param \AppBundle\Entity\Operation               $operation  Operation  entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="operations_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Operation $operation)
    {
        $form = $this->createForm(FormType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationsRepository->delete($operation);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('operations_index');
        }

        return $this->render(
            'operations/delete.html.twig',
            [
                'operation' => $operation,
                'form' => $form->createView(),
            ]
        );
    }
}
