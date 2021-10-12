<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
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

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Вы должны быть администратором для этого');
        }

        if (!empty($_POST)) {
            try {
                $article::updateFromArray($_POST, $article);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php',
                [
                    'error' => $e->getMessage(),
                    'article' => $article
                ]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Вы должны быть администратором для этого');
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                    $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                    return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

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