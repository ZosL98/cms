<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    secure();
    include('includes/header.php');

    if (isset($_POST['username'])) {
        if($stm = $connect->prepare('UPDATE users SET username = ?, email = ?, active = ? WHERE id = ?')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
            $stm->execute();

            set_message("A user " . $_GET['id'] . " has been updated");

            $stm->close();

            if (isset($_POST['password'])) {
                if($stm = $connect->prepare('UPDATE users SET password = ? WHERE id = ?')) {
                    $hashed = sha1($_POST['password']);
                    $stm->bind_param('si', $hashed, $_GET['id']);
                    $stm->execute();
                } else {
                    echo 'could not prepare statement';
                }
        
                set_message("A user " . $_GET['id'] . " has been updated");
                header('location: users.php');
                die();
                

            } else {
                echo 'could not prepare statement';
            }
        }

    }

    if (isset($_GET['id'])) {
        if($stm = $connect->prepare('SELECT * FROM users WHERE id = ?')) {
            $stm->bind_param('i', $_GET['id']);
            $stm->execute();

            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            var_dump($user);


?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="display-1">Edit user</h1>

            <form method="post">

            <!-- Username input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username'] ?>"/>
                <label class="form-label" for="email">Username</label>
            </div>

            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="email" id="email" name="email" id="form1Example1" class="form-control active" value="<?php echo $user['email'] ?>" />
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
                    <option value="1" <?php ($user['active']) ? "selected" : "" ?>>Active</option>
                    <option value="0" <?php ($user['active']) ? "" : "selected" ?>>Inactive</option>
                </select>
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Update user</button>
            </form>

            </div>
        </div>
    </div>




<?php
                $stm->close();
    
            } else {
                echo 'could not prepare statement';
            }
            
        } else {
            echo 'no user selected';
            die();
        }

    include('includes/footer.php');
?>