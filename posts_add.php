<?php
    include('includes/database.php');
    include('includes/functions.php');
    include('includes/config.php');
    secure();
    include('includes/header.php');



    if (isset($_POST['title'])) {
        post_add($_POST['title'], $_POST['content'], $_SESSION['id'], $_POST['date'], basename($_FILES['image']['name']));
    }

?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
            <h1 class="display-1">Add post</h1>

            <form method="post" enctype="multipart/form-data">
                <!-- title input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>


                <!-- Content input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date select -->
                <div class="form-outline mb-4">
                    <input type="date" id="date" name="date" class="form-control" />
                    <label class="form-label" for="date">Date</label>
                </div>

                <!-- File Input -->
                <div class="mb-3">
                    <label for="formFile" class="form-label">Add image</label>
                    <input class="form-control" type="file" id="formFile" name="image">
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add post</button>
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
    include('includes/footer.php');
?>