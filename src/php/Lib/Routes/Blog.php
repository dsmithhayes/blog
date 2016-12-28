<?php

namespace Blog\Lib\Routes;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;
use Blog\Lib\Route;
use Blog\Lib\Routes\Post;

class Blog
{
    public function index(): Route
    {
        return new class() extends Route {
            public function __construct()
            {
                $this->setName('blog-listing')
                     ->setMethod('get')
                     ->setRoute('/blog')
                     ->setCallback(function (Request $req, Response $res) {
                         $posts = $this->posts->findAll();

                         if (!$posts) {
                             $posts = 'No posts!';
                         }

                         return $this->view->render($res, 'blog.twig', [
                             'title' => 'Blog',
                             'post' => $posts
                         ]);
                     });
            }
        };
    }

    public function post(): Route
    {
        return new class() extends Route {
            public function __construct()
            {
                $this->setName('blog-post')
                     ->setMethod('get')
                     ->setRoute('/blog/{slug}')
                     ->setCallback(function (Request $req, Response $res) {

                         return $this->view->render($res, 'blog-post.twig', [
                             'title' => 'Blog Post'
                         ]);
                     });
            }
        };
    }
}
