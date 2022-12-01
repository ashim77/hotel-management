<?php require_once('header.php'); ?>

<?php
if (isset($_POST['add_role_form'])) {
    try {
        if (empty($_POST['role_name'])) {
            throw new Exception("Role name can not be empty!");
        }

        $role_name = strip_tags($_POST['role_name']);

        // auto increment id
        $q = $pdo->prepare("SHOW TABLE STATUS LIKE 'role'");
        $q->execute();
        $res = $q->fetchAll();
        foreach ($res as $row) {
            $ai_id = $row[10];
        }

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO role(role_name) VALUES(?)");
        $q->execute([$role_name]);

        // select page id
        $q = $pdo->prepare("SELECT * FROM pages ORDER BY page_id ASC");
        $q->execute();
        $pages = $q->fetchAll();
        // var_dump($pages);
        foreach ($pages as $page) {
            // $page_ids[] = $page['page_id'];
            $r = $pdo->prepare("INSERT INTO role_access(role_id, page_id, access_status) VALUES(?,?,?)");
            $r->execute([$ai_id, $page['page_id'], 0]);
        }

        $_SESSION['tmp_success'] = 'Role is added successfully';
        header('location: role_add.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Role</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Role Form Elements
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
                            <!-- Role Name -->
                            <div class="form-group">
                                <label for="role_name" class="col-sm-2 control-label">Role Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="role_name" name="role_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="add_role_form">Submit</button>
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