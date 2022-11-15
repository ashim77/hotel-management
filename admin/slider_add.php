<?php require_once('header.php'); ?>

<?php
if (isset($_POST['add_slider_form'])) {

    // Requeired input field validation
    $valid = 1;
    $path = $_FILES['slider_photo']['name'];
    $path_tmp = $_FILES['slider_photo']['tmp_name'];

    // Check error
    if (empty($path)) {
        $valid = 0;
        $error_message = 'You must have to slect a photo';
    } else {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            $valid = 0;
            $error_message = 'Only jpg, png and gif file are allowed for slider photo <br>';
        }
    }

    // Success Message
    if ($valid == 1) {

        // get the database table auto increment number
        $q = $pdo->prepare("SHOW TABLE STATUS LIKE 'slider'");
        $q->execute();
        $result = $q->fetchALL();
        foreach ($result as $row) {
            $ai_id = $row[10];
        }

        // Select database table column
        $slider_title = $_POST['slider_title'];
        $slider_subtitle = $_POST['slider_subtitle'];
        $slider_button_text = $_POST['slider_button_text'];
        $slider_button_url = $_POST['slider_button_url'];

        // Set image extenstion
        if ($mime == 'image/jpeg') {
            $ext = 'jpg';
        } elseif ($mime == 'image/png') {
            $ext = 'png';
        } elseif ($mime == 'image/gif') {
            $ext = 'gif';
        }

        // Uploaded photo name with extention
        $final_name = 'slider_' . $ai_id . '.' . $ext;

        // Upload the photo location
        move_uploaded_file($path_tmp, '../uploads/' . $final_name);

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO slider(slider_title,slider_subtitle,slider_button_text,slider_button_url,slider_photo) VALUES(?,?,?,?,?)");
        $q->execute([$slider_title, $slider_subtitle, $slider_button_text, $slider_button_url, $final_name]);

        $success_message = 'Slider is added successfully';
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Slider</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Slider Form Elements
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">


                        <?php
                        if (isset($error_message)) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        }
                        if (isset($success_message)) {
                            echo '<div class="alert alert-success">' . $success_message . '</div>';
                        }
                        ?>


                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <!-- Slider Title -->
                            <div class="form-group">
                                <label for="slider_title" class="col-sm-2 control-label">Slider Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slider_title" name="slider_title">
                                </div>
                            </div>
                            <!-- Slider Sub Title -->
                            <div class="form-group">
                                <label for="slider_subtitle" class="col-sm-2 control-label">Slider Sub Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slider_subtitle" name="slider_subtitle">
                                </div>
                            </div>
                            <!-- Slider Button Text -->
                            <div class="form-group">
                                <label for="slider_button_text" class="col-sm-2 control-label">Slider Button Text</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slider_button_text" name="slider_button_text">
                                </div>
                            </div>
                            <!-- Slider Button URL -->
                            <div class="form-group">
                                <label for="slider_button_url" class="col-sm-2 control-label">Slider Button URL</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slider_button_url" name="slider_button_url">
                                </div>
                            </div>
                            <!-- Slider Photo -->
                            <div class="form-group">
                                <label for="slider_photo" class="col-sm-2 control-label">Slider Photo *</label>
                                <div class="col-sm-10" style="padding-top: 5px;">
                                    <input type="file" name="slider_photo" id="slider_photo">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="add_slider_form">Submit</button>
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