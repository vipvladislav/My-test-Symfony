<?php
require_once ('../src/functions.php');
require_once ('../src/Article.php');

$connection = connection();
$articleObj = new Article($connection);


$id = null;

//if (empty($_POST['content']));

//if ('POST' === $_SERVER['REQUEST_METHOD'])
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//    if (isset($_POST['title'])) {
        $id = (int)($_POST['id'] ?? 0);
        $title = mysqli_real_escape_string($connection, $_POST['title'] ?? '');
        $category = (int)($_POST['category'] ?? null);
        $content = mysqli_real_escape_string($connection, $_POST['content'] ?? '');


        $articleObj->createArticle($title, $content, $connection = null);
//        return createArticle($title, $content, $category, $connection = null);
//    $connection->close();
    redirect();

}

if (isset($_GET['id']) && $_GET['id']) {
    $id = $_GET['id'];
    $id = (int)($id);
}

//$categories = getCategories($connection);

