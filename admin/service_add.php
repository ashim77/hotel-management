<?php require_once('header.php'); ?>

<?php
if (isset($_POST['add_service_form'])) {
    try {
        if (empty($_POST['service_title'])) {
            throw new Exception("Service title can not be empty!");
        }
        if (empty($_POST['service_text'])) {
            throw new Exception("Service Text can not be empty!");
        }

        $service_title = strip_tags($_POST['service_title']);
        $service_text = strip_tags($_POST['service_text']);

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO service(service_title, service_text) VALUES(?,?)");
        $q->execute([$service_title, $service_text]);

        $_SESSION['tmp_success'] = 'Service is added successfully';
        header('location: service_add.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Service</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Service Form Elements
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
                            <!-- Service Title -->
                            <div class="form-group">
                                <label for="service_title" class="col-sm-2 control-label">Service Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="service_title" name="service_title">
                                </div>
                            </div>
                            <!-- Service text -->
                            <div class="form-group">
                                <label for="service_text" class="col-sm-2 control-label">Service Text</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="service_text" id="service_text" cols="30" rows="10"></textarea>
                                    <script>
                                        CKEDITOR.replace('service_text');
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="add_service_form">Submit</button>
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