<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Knihovna') ?> – KnihovnaApp</title>
    <?= $this->include('Layout/links') ?>
    <?= $this->include('Layout/css') ?>
</head>

<body>
    <?= $this->include('Layout/navbar') ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

</body>

</html>