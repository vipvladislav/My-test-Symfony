<?php
session_start();

if (isset($_SESSION['loggedin']) && ($_SESSION['loggetin'] === true)) {
    header('location: index.php');
    exit;
}

require_once ('../src/functions.php');

$isSubmitted = false;

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $isSubmitted = true;
    $email = $password = '';
    $emailError = $passwordError = '';

    if (empty(trim($_POST['email']))) {
        $emailError = 'Please enter email';
    } else {
        $email = trim($_POST['email']);
    }

    if (empty(trim($_POST['password']))) {
        $passwordError = 'Please enter password';
    } else {
        $password = trim($_POST['password']);
    }

    if (!$emailError && !$passwordError) {
        $link = connection();

        $sql = 'SELECT id, username, password FROM users WHERE email = ?';
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s",  $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_fetch($stmt);


            if (password_verify($password, $storedPassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                header('location: index.php');
                exit();
            } else {
                $emailError = 'Incorrect login or password';
            }
        } else {
            $emailError - 'User not exist';
        }
    }
}

require_once ('inc/_head.php');
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
    <div class="container">
        <a href="index.html" class="navbar-brand">Blogen</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </div>
</nav>

<header id="main-header" class="py-2 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1><i class="fa fa-user"></i> Blogen Admin</h1>
            </div>
        </div>
    </div>
</header>

<!-- ACTIONS -->
<section id="action" class="py-4 mb-4 bg-light">
    <div class="container">
        <div class="row">

        </div>
    </div>
</section>

<!-- LOGIN -->
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Account Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="<?=$isSubmitted ? 'was-validated' : 'needs-validation' ?>">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" value="<?=$email ?? ''?>" required>
                                <div class="invalid-feedback"><?=$emailError?></div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback"><?=$passwordError?></div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" value="Login">
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
require_once ('inc/_footer.php');
?>