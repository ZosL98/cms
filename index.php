<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    include('includes/header.php');

    // just to make sure user cannot go back to login by clicking home if he is already logged in
    if(isset($_SESSION['id'])) {
        header('Location: dashboard.php');
        die();
    }

    if (isset($_POST['email']) && isset($_POST['password'])) {
        if($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('ss', $_POST['email'], $hashed);
            $stm->execute();

            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if($user) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                set_message("You have succesfully logged in " . $_SESSION['username']);
                header('location: dashboard.php');
                die();
            }

            echo '<div class="alert alert-danger" role="alert">Wrong username or password!</div>';

            $stm->close();
        } else {
            echo 'could not prepare statement';
        }
    }

?>

    <h1>Posts</h1>

    <table class="table table-dark table-hover">
        <th scope="col">Title</th>
        <th scope="col">View full post</th>

<?php
    // CONTINUE HERE <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    if ($stm = $connect->prepare('SELECT * FROM posts')) {
        $stm->execute();
        $result = $stm->get_result();

        while($row = mysqli_fetch_array($result)) {

?>

            <tr>
                <td><?php echo $row['title'] ?></td>
                <td><a href="view.php?id=<?php echo $row['id'] ?>">View</a></td>
            </tr>

<?php
        }
    }
?>

</table>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post">
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

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>
    </div>
</div>




<?php
    include('includes/footer.php');
?>