<?php require_once('header.php'); ?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Testimonail</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>Serial</th>
              <th>Photo</th>
              <th>Name & Des</th>
              <th>Comments</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $q = $pdo->prepare("SELECT * FROM testimonial ORDER BY testimonial_id ASC");
            $q->execute();
            $res = $q->fetchALL();
            foreach ($res as $row) {
              $i++;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td>
                  <img src="../uploads/testimonial/<?php echo $row['person_photo']; ?>" style="width: 100px;">
                </td>
                <td><?php echo $row['person_name_des']; ?></td>
                <td><?php echo $row['person_comment']; ?></td>
                <td>
                  <a href="testimonial_edit.php?id=<?php echo $row['testimonial_id']; ?>" class="btn btn-xs btn-warning">Edit</a>
                  <a href="testimonial_delete.php?id=<?php echo $row['testimonial_id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
              </tr>
            <?php }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<?php require_once('footer.php'); ?>