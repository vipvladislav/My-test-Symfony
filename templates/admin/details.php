<?php
require_once ('../src/functions.php');
require_once ('../src/Article.php');
$connection = connection();
$articleObj = new Article($connection);

$id = null;

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $id = (int)($_POST['id'] ?? 0);
    $title = mysqli_real_escape_string($connection, $_POST['title'] ?? '');
    $category = (int)($_POST['category'] ?? null);
    $content = mysqli_real_escape_string($connection, $_POST['content'] ?? '');
    $articleObj->updateArticleById( $id,  $title,  $category,  $content);

    redirect();
}

if (isset($_GET['id']) && $_GET['id']) {
    $id = $_GET['id'];
    $id = (int)$id;
}

if (!$id || ($id < 1)) {
    redirect();
}


$article  = $articleObj->getArticleById($id);

if (empty($article)) {
    redirect();
}

$categories = getCategories($connection);

$connection->close();

require_once ('../src/check_login.php');
require_once ('inc/_head.php');
require_once ('inc/_navbar.php');
?>

  <header id="main-header" class="py-2 bg-primary text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1> Post One</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- ACTIONS -->
  <section id="action" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mr-auto">
          <a href="index.html" class="btn btn-light btn-block">
            <i class="fa fa-arrow-left"></i> Back To Dashboard
          </a>
        </div>
        <div class="col-md-3">
          <button href="#" class="btn btn-success btn-block" form="edit-article">
            <i class="fa fa-check"></i> Save Changes
          </button>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-danger btn-block">
            <i class="fa fa-remove"></i> Delete Post
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- POSTS -->
  <section id="posts">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <h4>Edit Post</h4>
            </div>
            <div class="card-body">
              <form method="post", enctype="multipart/form-data" action="" id="edit-article">
                  <input type="hidden" name="id" value="<?=$article['id']?>">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" value="<?=$article['title']?>" name="title">
                </div>
                <div class="form-group">
                  <label for="title">Category</label>
                  <select class="form-control" name="category">
                      <option value="0">No category</option>
                      <?php
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                $selected = $category['id'] == $article['category'] ? 'selected' : '';
                                echo sprintf('<option value="%s" %s>%s</option>', $category['id'], $selected, $category['title']);
                            }
                        }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="file">Image Upload</label>
                  <input type="file" class="form-control-file" name="file">
                  <small class="form-text text-muted">Max Size 3mb</small>
                </div>
                <div class="form-group">
                  <label for="body">Body</label>
                  <textarea name="content" class="form-control"><?=$article['content']?></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer id="main-footer" class="bg-dark text-white mt-5 p-5">
    <div class="conatiner">
      <div class="row">
        <div class="col">
          <p class="lead text-center">Copyright &copy; 2017 Blogen</p>
        </div>
      </div>
    </div>
  </footer>


<?php
require_once ('inc/_footer.php')
?>
