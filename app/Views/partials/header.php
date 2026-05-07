<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?></title>
    <link rel="icon" href="assets/images/logo.png"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/media.css"/>
</head>
<body>
    <div id="responseContainer"></div>
    <?php require __DIR__ . "/../partials/sidebar.php"; ?>
    <?php require __DIR__ . "/../partials/notification.php"; ?>