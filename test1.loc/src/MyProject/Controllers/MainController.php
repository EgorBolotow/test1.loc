<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;

class MainController extends BaseController
{
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
            'user' => UsersAuthService::getUserByToken()
        ]);
    }
}

