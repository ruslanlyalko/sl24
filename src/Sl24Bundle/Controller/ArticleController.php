<?php

namespace Sl24Bundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Sl24Bundle\Entity\Functions;
use Sl24Bundle\Entity\User;
use Sl24Bundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getArticlesAction()
    {
        $articles = $this->getDoctrine()->getRepository('Sl24Bundle:Article')->findAll();
        $articlesToJson = Functions::arrayToJson($articles);
        return new JsonResponse($articlesToJson);
    }

    public function addArticlesAction(Request $request)
    {
        $params = array(
            'title' => $request->request->get('article_title'),
            'text' => $request->request->get('article_text'),
            'img' => $request->files->get('article_img'),
        );
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        if($params['title'] != null or $params['text'] != null)
        {
        $article = Article::addNewArticle($em, $user->getId(), $params);
        }
        return $this->redirectToRoute('sl_24_get_articles_page');
    }
}