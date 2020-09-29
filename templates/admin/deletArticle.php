<?php
require_once('../src/functions.php');
require_once('../src/Article.php');

$connection = connection();
$articleObj = new Article($connection);


$id = null;

if ('POST' === $_SERVER['REQUEST_METHOD']) {
$id = (int)($_POST['id'] ?? 0);
$articleObj->deleteArticle($id);
redirect();
}