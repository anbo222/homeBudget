<?php
/**
 * Users controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Repository\UsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UsersController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/users")
 */
class UsersController extends Controller
{
    /**
     * Users repository.
     *
     * @var \AppBundle\Repository\UsersRepository|null User repository
     */
    protected $usersRepository = null;

    /**
     * UsersController constructor.
     *
     * @param \AppBundle\Repository\UsersRepository $usersRepository User repository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="users_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="users_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $users = $this->usersRepository->findAllPaginated($page);

        return $this->render(
            'users/index.html.twig',
            ['users' => $users]
        );
    }

    /**
     * View action.
     *
     * @param User $user User entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="users_view",
     * )
     * @Method("GET")
     */
    public function viewAction(User $user)
    {
        return $this->render(
            'users/view.html.twig',
            ['user' => $user]
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
     *     name="users_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersRepository->save($user);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('users_index');
        }

        return $this->render(
            'users/add.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\User                    $user      User      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="users_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersRepository->save($user);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('users_index');
        }

        return $this->render(
            'users/edit.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\User                    $user      User      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="users_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createForm(FormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersRepository->delete($user);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('users_index');
        }

        return $this->render(
            'users/delete.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }
}
