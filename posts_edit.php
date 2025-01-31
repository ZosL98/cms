<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    secure();
    include('includes/header.php');

    if (isset($_POST['title'])) {
        if($stm = $connect->prepare('UPDATE posts SET title = ?, content = ?, date = ? WHERE id = ?')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('sssi', $_POST['title'], $_POST['content'], $_POST['date'], $_GET['id']);
            $stm->execute();

            set_message("A user " . $_GET['id'] . " has been updated");

            $stm->close();



                set_message("A user " . $_GET['id'] . " has been updated");
                header('location: posts.php');
                die();

            } else {
                echo 'could not prepare post statement';
            }
        }


    if (isset($_GET['id'])) {
        if($stm = $connect->prepare('SELECT * FROM posts WHERE id = ?')) {
            $stm->bind_param('i', $_GET['id']);
            $stm->execute();

            $result = $stm->get_result();
            $post = $result->fetch_assoc();

            var_dump($user);

            if($post) {


?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="display-1">Edit post</h1>

            <form method="post">

            <!-- title input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="title" name="title" class="form-control" value="<?php echo $post['title'] ?>" />
                <label class="form-label" for="title">Title</label>
            </div>


            <!-- Content input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <textarea name="content" id="content"><?php echo $post['content'] ?></textarea>
            </div>

            <!-- Date select -->
            <div class="form-outline mb-4">
                <input type="date" id="date" name="date" class="form-control" value="<?php echo $post['date'] ?>" />
                <label class="form-label" for="date">Date</label>
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Edit post</button>
            </form>
            </div>
        </div>
    </div>


    <script src="js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content'
        })
    </script>


<?php

            }
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