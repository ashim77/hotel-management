<?php require_once('header.php'); ?>

<?php
if (isset($_POST['add_feature_form'])) {
    try {
        if (empty($_POST['feature_title'])) {
            throw new Exception("Feature title can not be empty!");
        }
        if (empty($_POST['feature_text'])) {
            throw new Exception("Feature Text can not be empty!");
        }
        if (empty($_POST['feature_icon'])) {
            throw new Exception("Feature Icon can not be empty!");
        }

        $feature_title = strip_tags($_POST['feature_title']);
        $feature_text = strip_tags($_POST['feature_text']);
        $feature_icon = strip_tags($_POST['feature_icon']);

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO feature(feature_title,feature_text,feature_icon) VALUES(?,?,?)");
        $q->execute([$feature_title, $feature_text, $feature_icon]);

        $_SESSION['tmp_success'] = 'Feature is added successfully';
        header('location: feature_add.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Feature</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Feature Form Elements
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


                        <form class="form-horizontal" action="" method="post">
                            <!-- Feature Title -->
                            <div class="form-group">
                                <label for="feature_title" class="col-sm-2 control-label">Feature Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="feature_title" name="feature_title">
                                </div>
                            </div>
                            <!-- Feature text -->
                            <div class="form-group">
                                <label for="feature_text" class="col-sm-2 control-label">Feature Text</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="feature_text" id="feature_text" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <!-- Feature Icon -->
                            <div class="form-group">
                                <label for="feature_icon" class="col-sm-2 control-label">Feature Icon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="feature_icon" name="feature_icon">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="add_feature_form">Submit</button>
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