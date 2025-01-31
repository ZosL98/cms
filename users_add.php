<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    secure();
    include('includes/header.php');

    if (isset($_POST['username'])) {
        if($stm = $connect->prepare('INSERT INTO users(username, email, password, active) VALUES(?, ?, ?, ?)')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['active']);
            $stm->execute();

            set_message("A new user " . $_SESSION['username'] . " has been added");
            header('location: users.php');
            die();

            $stm->close();
        } else {
            echo 'could not prepare statement';
        }
    }

?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="display-1">Add user</h1>

            <form method="post">

            <!-- Username input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control" />
                <label class="form-label" for="email">Username</label>
            </div>

            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="email" id="email" name="email" id="form1Example1" class="form-control" />
                <label class="form-label" for="email">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" />
                <label class="form-label" for="password">Password</label>
            </div>

            <!-- Active select -->
            <div class="form-outline mb-4">
                <select name="active" id="active" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add user</button>
            </form>

            </div>
        </div>
    </div>




<?php


    include('includes/footer.php');
?>