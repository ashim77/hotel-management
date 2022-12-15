<?php require_once('header.php'); ?>

<?php

if (isset($_POST['add_role_form'])) {
    $user_full_name = strip_tags($_POST['user_full_name']);
    $user_email = strip_tags($_POST['user_email']);
    $user_password = strip_tags($_POST['user_password']);
    $role_id = strip_tags($_POST['role_id']);
    try {
        if (empty($_POST['user_full_name'])) {
            throw new Exception("User name can not be empty!");
        }
        if (empty($_POST['user_email'])) {
            throw new Exception("Email can not be empty!");
        } else {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email ID is invalid");
            }
        }
        if (empty($_POST['user_password'])) {
            throw new Exception("User Password can not be empty!");
        }

        // Insert data into my database
        $q = $pdo->prepare("INSERT INTO user(user_full_name,user_email,user_password,user_hash,role_id) VALUES(?,?,?,?,?)");
        $q->execute([$user_full_name, $user_email, md5($user_password), '', $role_id]);

        $_SESSION['tmp_success'] = 'User is added successfully';
        header('location: user_add.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add User</h1>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Form Elements
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
                            <!-- User Full Name -->
                            <div class="form-group">
                                <label for="user_full_name" class="col-sm-2 control-label">Full Name *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="user_full_name" name="user_full_name">
                                </div>
                            </div>
                            <!-- User Email Address -->
                            <div class="form-group">
                                <label for="user_email" class="col-sm-2 control-label">Email Address *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="user_email" name="user_email">
                                </div>
                            </div>
                            <!-- User Password -->
                            <div class="form-group">
                                <label for="user_password" class="col-sm-2 control-label">Password *</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="user_password" name="user_password">
                                </div>
                            </div>
                            <!-- Select Role -->
                            <div class="form-group">
                                <label for="role_id" class="col-sm-2 control-label">Select Role *</label>
                                <div class="col-sm-10">
                                    <select name="role_id" id="role_id" class="form-control">
                                        <?php
                                        $q = $pdo->prepare("SELECT * FROM role WHERE role_id != ? AND role_id != ? ORDER BY role_id ASC");
                                        $q->execute([1, 2]);
                                        $res = $q->fetchAll();
                                        foreach ($res as $row) {
                                        ?>
                                            <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
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