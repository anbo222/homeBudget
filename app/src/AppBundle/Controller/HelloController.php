<?php
/**
 * Created by PhpStorm.
 * User: student
 * Date: 28.02.18
 * Time: 17:44
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HelloController.
 *
 * @package AppBundle\Controller
 *
 * @Route(
 *     "/hello"
 * )
 */
class HelloController extends Controller
{
    /**
     * View action.
     *
     * @param string $name Name
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     defaults={"name": "World"},
     *     name="hello_world",
     * )
     * @Route(
     *     "/{name}",
     *     requirements={"name": "[a-zA-Z]+"},
     *     name="hello_world_user_input",
     * )
     * @Method("GET")
     */
    public function viewAction($name)
    {
        return $this->render(
            'hello/view.html.twig',
            ['name' => $name]
        );
    }
}
