<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    include('includes/header.php');

    if ($stm = $connect->prepare("SELECT * FROM posts WHERE id = ?")) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $post = $result->fetch_assoc();

        if ($post) {
?>
    <div id="container">
        <p>Title: <?php echo $post['title'] ?></p>
        <p>Content: <?php echo $post['content'] ?></p>
        <div><img src="<?php if(!empty($post['Image'])) {echo 'uploads/' . $post['Image'];}; ?>" width="200px" /></div>
    </div>
<?php
        }

        $stm->close();
    }
?>