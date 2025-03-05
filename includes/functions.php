<?php
    function secure() {
        if(!isset($_SESSION['id'])) {
            set_message('Please log in first to view this page');
            header('Location: /cms');
            die();
        }
    };

    function set_message($message) {
        $_SESSION['message'] = $message;

    }

    function get_messsage() {
        if(isset($_SESSION['message'])) {
            echo '<p>' . $_SESSION['message'] . '</p> <hr />';
            unset($_SESSION['message']);
        };
    }
    

    function image_upload($target) {
        if ($_FILES['image']['type'] === 'image/png' || $_FILES['image']['type'] === 'image/jpeg') {
            if ($_FILES['image']['size'] > 500000) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?message=Image is too large');
                die();
            } else {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target);
            }
        } else {
            if(isset($_GET['id'])) {
                header('Location:' . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'] . '&message=File is not type jpg or png');
                die();
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?message=File is not type jpg or png');
                die();
            }
        }
    }


    function post_add($title, $content, $author, $date, $image) {
        global $connect;
        if($stm = $connect->prepare('INSERT INTO posts(title, content, author, date, Image) VALUES(?, ?, ?, ?, ?)')) {


            if(isset($_FILES['image'])) {
                $folder = "uploads/";
                $target = $folder . basename($_FILES['image']['name']);
                $basename = basename($_FILES['image']['name']);

                image_upload($target);

            }


            $stm->bind_param('ssiss', $title, $content, $author, $date, $image);
            $stm->execute();


            set_message("A new post " . $_SESSION['username'] . " has been added");
             header('location: posts.php');
             die();

            $stm->close();
        } else {
            echo 'could not prepare statement';
        }
    }


    function users_add($username, $email, $password, $active) {
        global $connect;
        if($stm = $connect->prepare('INSERT INTO users(username, email, password, active) VALUES(?, ?, ?, ?)')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('ssss', $username, $email, $password, $active);
            $stm->execute();

            set_message("A new user " . $_SESSION['username'] . " has been added");
            header('location: users.php');
            die();

            $stm->close();
        } else {
            echo 'could not prepare statement';
        }
    }


    function post_edit($title, $content, $date, $id) {
        global $connect;
        if($stm = $connect->prepare('UPDATE posts SET title = ?, content = ?, date = ? WHERE id = ?')) {

            if(isset($_FILES['image'])) {
                $folder = "uploads/";
                $target = $folder . basename($_FILES['image']['name']);
                $basename = basename($_FILES['image']['name']);
                
                image_upload($target);

                if ($x = $connect->prepare("UPDATE posts SET Image = ? WHERE id = ?")) {
                    $x->bind_param('si', $basename, $id);
                    $x->execute();
                }
            }

            $stm->bind_param('sssi', $title, $content, $date, $id);
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

    function user_edit($username, $email, $active, $id) {
        global $connect;
        if($stm = $connect->prepare('UPDATE users SET username = ?, email = ?, active = ? WHERE id = ?')) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param('sssi', $username, $email, $active, $id);
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
?>