<?php

namespace Controller;

class IndexController extends \Engine\Controller
{


    protected function prepareViewData()
    {
        $pg = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $artPerPage = 2;

        $startFrom = (($pg ?: 1) - 1) * $artPerPage;

        $articles = $this->database->getAllArticles($artPerPage, $startFrom);

        $articlesData = [];

        foreach ($articles as $article) {
            $articleData = [
                'title' => $article['title'],
                'date' => $article['create_date'],
                'img_url' => $article['image'],
                'text' => substr($article['text'], 0, 1000) . '...',
                'author' => $article['author'],
                'comments' => $this->database->getCommentsNumber($article['id'])
            ];


            $articlesData[] = $articleData;
        }

        $this->templateDataAppend('articles', $articlesData);
    }
}