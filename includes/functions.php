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
    

    function post_add($title, $content, $author, $date, $image) {
        global $connect;
        if($stm = $connect->prepare('INSERT INTO posts(title, content, author, date, Image) VALUES(?, ?, ?, ?, ?)')) {

            if(isset($_FILES['image'])) {
                $folder = "uploads/";
                $target = $folder . basename($_FILES['image']['name']);

                move_uploaded_file($_FILES["image"]["tmp_name"], $target);
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
?>