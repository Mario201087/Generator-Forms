<?php
session_start();

// Check if there is an error message stored in the session
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    // Unset the session variable to avoid displaying the error again on page reload
    unset($_SESSION['error']);
} else {
    $errorMessage = ''; // Set default value if there is no error message
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3y^D65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Generator Forms</title>
</head>

<body>
    <div id="wrapper">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h2>createplus</h2>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="#">
                        <button id="configureForm" class="btn btn-warning col-10 mb-1">
                            <i class="fa fa-search" style="margin-left: -103px; margin-right: 7px;" aria-hidden="true"></i>Pobierz
                        </button>
                    </a>
                </li>
                <li>
                    <a href="login.php" id="openLoginButton" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Log In
                    </a>
                </li>
            </ul>
        </aside>

        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </nav>
        </div>

       <section id="content-wrapper" class="d-flex justify-content-center align-items-center" style="height: 88vh;">
            <div class="row d-flex justify-content-center align-items-center col-12 m-0 p-0 h-100">
                <div class="col-lg-6 col-12 m-0 p-0">
                    <form class="p-2 mx-auto pe-auto" id="yourIdx" data-element-type="FORM" data-idx="yourIdx" method="POST" action="auth.php">
                        <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="createpl" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="123" required>
                                <?php if (!empty($errorMessage)) : ?>
                                    <div class="text-danger"><?php echo $errorMessage; ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary col-12">Login</button>

                    </form>
                    <p class="mt-3">
                        Don't have an account? <a href="registration.php">Register here</a>.
                    </p>
                </div>
            </div>
        </section>
    </div>


    <script>
        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
</body>
</html>
