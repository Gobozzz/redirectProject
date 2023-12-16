<?php
require('model/Link.php');

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$link = new Link();
$redirect = $link->redirectLink($url);

if ($redirect['status']) {
    header("Location: " . $redirect['link']);
} else {
    header('Location: /notFound.html');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перенаправление</title>
</head>

<body>


</body>

</html>