<?php
$code = $code ?? 500;
$messages = [
    404 => 'Not found',
    405 => 'Method Not allowed',
    500 => 'Internal Server Error'
];

$message = $messages[$code] ?? 'Unknown Error';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code . " " . htmlspecialchars($message) ?></title>
</head>
<body>
    <h1><?= $code ?></h1>
    <p><?= htmlspecialchars($message) ?></p>
    <p><a href="/login">Go back</a></p>
</body>
</html>
    