<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    secure();
    include('includes/header.php');



    if(isset($_GET['delete'])) {
        delete($_GET['delete'], "A post with id: $_GET[delete] has been deleted", 'location: posts.php', 'DELETE FROM posts WHERE id = ?');
    }

    if($stm = $connect->prepare('SELECT * FROM posts')) {
        $stm->execute();
        $result = $stm->get_result();


        if($result->num_rows > 0) {
            

?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="display-1">Posts Management</h1>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Author's ID</th>
                        <th>Content</th>
                        <th>Added</th>
                        <th>Edit | Delete</th>
                    </tr>
                    <?php
                        while($record = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td> <?php echo $record['id']; ?> </td>
                            <td> <?php echo $record['title']; ?> </td>
                            <td> <?php echo $record['author']; ?> </td>
                            <td> <?php echo $record['content']; ?> <img src="<?php if(!empty($record['Image'])) {echo 'uploads/' . $record['Image'];}; ?>" width="200px" /> </td>
                            <td> <?php echo $record['added']; ?> </td>
                            <td>
                                <a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edit </a><a href="posts.php?delete=<?php echo $record['id']; ?>">Delete</a>
                            </td>
                        </tr>
                            
                        <?php } ?>
                </table>

                <a href="posts_add.php">Add new post</a>
            </div>
        </div>
    </div>




<?php
            } else {
                echo 'No posts found';
            }

            $stm->close();
        } else {
            echo 'could not prepare statement';
        }

    include('includes/footer.php');
?>