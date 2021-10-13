<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <?php if ($user !== null && $user->isAdmin()): ?>
        <p><a href="http://test1.loc/articles/<?= $article->getId() ?>/edit">Редактировать статью</a></p>
    <?php endif; ?>
    <?php if ($user !== null): ?>
    <form action="http://test1.loc/articles/<?= $article->getId() ?>/comments" method="post">

        <textarea required placeholder="Что думаете?" name="comment" id="comment"></textarea>

        <button type="submit">Опубликовать</button>
    </form>
    <?php endif; ?>

    <br>

    <h2>Комментарии:</h2>

    <?php if (!empty($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <h2><?= $comment->getAuthor()->getNickname() ?></h2>
        <?php if ($user->getId() == $comment->getAuthorId()): ?>
            <form action="http://test1.loc/articles/<?= $article->getId() ?>/comments/<?= $comment->getId()?>/edit" method="post">
                <textarea required placeholder="Измените комментарий" name="comment" id="comment"><?= $comment->getText() ?></textarea>
                <button type="submit">Редактировать</button>
            </form>
        <?php endif; ?>
        <?php if ($user->getId() !== $comment->getAuthorId()): ?>
            <p><?= $comment->getText() ?></p>
        <?php endif; ?>
        <hr>
    <?php endforeach; ?>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>