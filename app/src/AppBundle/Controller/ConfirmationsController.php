<?php
/**
 * Confirmations controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Confirmation;
use AppBundle\Form\ConfirmationType;
use AppBundle\Repository\ConfirmationsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfirmationsController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/confirmations")
 */
class ConfirmationsController extends Controller
{
    /**
     * Confirmations repository.
     *
     * @var \AppBundle\Repository\ConfirmationsRepository|null Confirmation repository
     */
    protected $confirmationsRepository = null;

    /**
     * ConfirmationsController constructor.
     *
     * @param \AppBundle\Repository\ConfirmationsRepository $confirmationsRepository Confirmation repository
     */
    public function __construct(ConfirmationsRepository $confirmationsRepository)
    {
        $this->confirmationsRepository = $confirmationsRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="confirmations_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="confirmations_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $confirmations = $this->confirmationsRepository->findAllPaginated($page);

        return $this->render(
            'confirmations/index.html.twig',
            ['confirmations' => $confirmations]
        );
    }

    /**
     * View action.
     *
     * @param Confirmation $confirmation Confirmation entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="confirmations_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Confirmation $confirmation)
    {
        return $this->render(
            'confirmations/view.html.twig',
            ['confirmation' => $confirmation]
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
     *     name="confirmations_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $confirmation = new Confirmation();
        $form = $this->createForm(ConfirmationType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->confirmationsRepository->save($confirmation);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('confirmations_index');
        }

        return $this->render(
            'confirmations/add.html.twig',
            [
                'confirmation' => $confirmation,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP              Request
     * @param \AppBundle\Entity\Confirmation            $confirmation      Confirmation      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="confirmations_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Confirmation $confirmation)
    {
        $form = $this->createForm(ConfirmationType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->confirmationsRepository->save($confirmation);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('confirmations_index');
        }

        return $this->render(
            'confirmations/edit.html.twig',
            [
                'confirmation' => $confirmation,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request          HTTP              Request
     * @param \AppBundle\Entity\Confirmation            $confirmation     Confirmation      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="confirmations_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Confirmation $confirmation)
    {
        $form = $this->createForm(FormType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->confirmationsRepository->delete($confirmation);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('confirmations_index');
        }

        return $this->render(
            'confirmations/delete.html.twig',
            [
                'confirmation' => $confirmation,
                'form' => $form->createView(),
            ]
        );
    }
}
