<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController extends BaseController
{
    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $this->flash->addMessage('info', 'Sample flash message');

        $this->view->render($response, 'signin.php');
        return $response;
    }

    public function viewPost(Request $request, Response $response, $args)
    {
        $this->logger->info("View post using Doctrine with Slim 3");

        $messages = $this->flash->getMessage('info');

        try {
            $post = $this->em->find('App\Model\Post', intval($args['id']));
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }

        $this->view->render($response, 'post.twig', ['post' => $post, 'flash' => $messages]);
        return $response;
    }

    public function getsignIn(Request $request, Response $response){
        $this->view->render($response, 'signin.php');
        return $response;
    }


    public function getsignUp(Request $request, Response $response){
        $this->view->render($response, 'signup.php');
        return $response;
    }

    public function getsignout(Request $request, Response $response){
        $this->view->render($response, 'signin.php');
        return $response;
    }

    public function postsignout(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'signin.php');
        return $response;
    }


     public function getresetpassword(Request $request, Response $response){
        $this->view->render($response, 'resetpw.php');
        return $response;
    }

/*
    Send password to given E-mail
*/

    public function postresetpassword(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'signin.twig');
        return $response;
    }


    public function getchangepassword(Request $request, Response $response){
        $this->view->render($response, 'changepw.php');
        return $response;
    }

    public function postchangepassword(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'main.twig');
        return $response;
    }


     public function getdashboard(Request $request, Response $response){
        $this->view->render($response, 'dashboard.php');
        return $response;
    }

    public function postdashboard(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'dashboard.php');
        return $response;
    }

    public function getmaps(Request $request, Response $response){
        $this->view->render($response, 'maps.php');
        return $response;
    }

    public function postmaps(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'maps.php');
        return $response;
    }

    public function getidcancellation(Request $request, Response $response){
        $this->view->render($response, 'idcancellation.php');
        return $response;
    }

    public function postidcancellation(Request $request, Response $response){
        // var_dump($request->getParams());
        $this->view->render($response, 'idcancellation.php');
        return $response;
    }
}
