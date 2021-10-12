<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

class ArticlesController extends BaseController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('main/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null)
        {
            $this->view->renderHtml("errors/404.php");
        }

        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();
    }

    public function add()
    {
        $author = User::getById(1);
        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи 2');
        $article->setText('Новый текст статьи 2');

        $article->save();
        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null){
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $article->delete($articleId);
    }
}