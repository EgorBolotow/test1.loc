<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <?php if ($user !== null && $user->isAdmin()): ?>
        <p><a href="http://test1.loc/articles/<?= $article->getId() ?>/edit">Редактировать статью</a></p>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>