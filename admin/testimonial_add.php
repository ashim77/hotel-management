<?php require_once('header.php'); ?>

<?php
if (isset($_POST['add_testimonial_form'])) {
    try {
        if (empty($_POST['person_name_des'])) {
            throw new Exception("Person Name & Designation can not be empty!");
        }
        if (empty($_POST['person_comment'])) {
            throw new Exception("Person Comment can not be empty!");
        }
        if (empty($_FILES['person_photo'])) {
            throw new Exception("You must have to slect a photo");
        }

        // Person Photo
        $path = $_FILES['person_photo']['name'];
        $path_tmp = $_FILES['person_photo']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            $valid = 0;
            throw new Exception("Only jpg, png and gif file are allowed for Person photo <br>");
        }

        // get the database table auto increment number
        $q = $pdo->prepare("SHOW TABLE STATUS LIKE 'testimonial'");
        $q->execute();
        $result = $q->fetchALL();
        foreach ($result as $row) {
            $ai_id = $row[10];
        }

        $person_name_des = strip_tags($_POST['person_name_des']);
        $person_comment = strip_tags($_POST['person_comment']);

        // Set image extenstion
        if ($mime == 'image/jpeg') {
            $ext = 'jpg';
        } elseif ($mime == 'image/png') {
            $ext = 'png';
        } elseif ($mime == 'image/gif') {
            $ext = 'gif';
        }

        // Uploaded photo name with extention
        $final_name = 'testimonial_' . $ai_id . '.' . $ext;

        // Upload the photo location
        move_uploaded_file($path_tmp, '../uploads/testimonial/' . $final_name);

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO testimonial(person_name_des,person_comment,person_photo) VALUES(?,?,?)");
        $q->execute([$person_name_des, $person_comment, $final_name]);

        $_SESSION['tmp_success'] = 'Testimonial is added successfully';
        header('location: testimonial_add.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Testimonail</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Testimonial Form Elements
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <?php
                        if (isset($error_message)) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        }
                        if (isset($_SESSION['tmp_success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['tmp_success'] . '</div>';
                            unset($_SESSION['tmp_success']);
                        }
                        ?>


                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <!-- Person Name -->
                            <div class="form-group">
                                <label for="person_name_des" class="col-sm-2 control-label">Person Name & Des.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="person_name_des" name="person_name_des">
                                </div>
                            </div>
                            <!-- Person Comment text -->
                            <div class="form-group">
                                <label for="person_comment" class="col-sm-2 control-label">Person Comments Text</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="person_comment" id="person_comment" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <!-- Person Photo -->
                            <div class="form-group">
                                <label for="person_photo" class="col-sm-2 control-label">Person Photo *</label>
                                <div class="col-sm-10" style="padding-top: 5px;">
                                    <input type="file" name="person_photo" id="person_photo">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="add_testimonial_form">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php require_once('footer.php'); ?>