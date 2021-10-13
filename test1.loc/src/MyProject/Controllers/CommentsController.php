<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class CommentsController extends BaseController
{
    public function comment(int $articleId)
    {
        Comment::createComment($_POST, $this->user, $articleId);
        header('Location: /articles/' . $articleId);
    }

    public function editComment(int $articleId, int $commentId)
    {
        Comment::editComment($_POST, $commentId);
        header('Location: /articles/' . $articleId);
    }
}