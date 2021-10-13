<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    /** @var int */
    protected $author_id;

    /** @var int */
    protected $article_id;

    /** @var string */
    protected $text;

    /** @var string */
    protected $createdAt;

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return User::getById($this->author_id);
    }

    /**
     * @param int $author_id
     */
    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }

    /**
     * @param int $article_id
     */
    public function setArticleId(int $article_id): void
    {
        $this->article_id = $article_id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }



    protected static function getTableName(): string
    {
        return 'comments';
    }

    public static function createComment(array $fields, User $author, int $articleId): Comment
    {
        $db = Db::getInstance();
        $comment = new Comment();

        $comment->setAuthorId($author->getId());
        $comment->setArticleId($articleId);
        $comment->setText($fields['comment']);

        $comment->save();

        return $comment;
    }

    public static function editComment(array $field, int $commentId)
    {
        $comment = Comment::getById($commentId);
        $comment->setText($field['comment']);
        $comment->save();
    }

    public static function getCommentsByArticleId(int $articleId): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE article_id = :article_id;',
            [':article_id' => $articleId],
            static::class);
    }
}