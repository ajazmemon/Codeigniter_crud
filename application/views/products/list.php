<div class="row">
  <?php
if(isset($error)){
 echo $error;
}
  ?>
   <?php
$msg = $this->session->flashdata('message_name');
if(isset($msg)) {
$message = $this->session->flashdata('message_name');
?>
<div class="alert alert-success"><?php echo $message; ?></div>
<?php
      } ?>
    <div class="col-lg-12">           
        <h2>Products CRUD           
            <div class="pull-right">
               <a class="btn btn-primary" href="<?php echo base_url('products/create') ?>"> Create New Product</a>
            </div>
        </h2>
     </div>
</div>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
      <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Image</th>
          <th>Category</th>
          <th>Publish</th>
          <th>Type</th>
      <th>Action</th>
      </tr>
  </thead>
  <tbody>
   <?php foreach ($data as $d) { ?>      
      <tr>
          <td><?php echo $d->title; ?></td>
          <td><?php echo $d->description; ?></td>
          <td><img src="<?=base_url()?>uploads/<?php echo $d->image; ?>" style="height: 70px" width="120px"></td>
          <td><?php echo $d->category; ?></td>
          <td><?php echo $d->publish; ?></td>          
          <td><?php echo $d->type; ?></td>
      <td>
        <form method="DELETE" action="<?php echo base_url('products/delete/'.$d->id);?>">
         <a class="btn btn-info btn-xs" href="<?php echo base_url('products/edit/'.$d->id) ?>"><i class="glyphicon glyphicon-pencil"></i></a>
          <button type="submit" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
        </form>
      </td>     
      </tr>
      <?php } ?>
  </tbody>
</table>
</div>
