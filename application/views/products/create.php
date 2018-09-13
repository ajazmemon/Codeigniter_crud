    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

        <title>Admin</title>
    
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<style type="text/css">
    /*
/* Created by Filipe Pina
 * Specific styles of signin, register, component
 */
/*
 * General styles
 */

body, html{
     height: 100%;
    background-repeat: no-repeat;
    background-color: #d3d3d3;
    font-family: 'Oxygen', sans-serif;
}

.main{
    margin-top: 70px;
}

h1.title { 
    font-size: 50px;
    font-family: 'Passion One', cursive; 
    font-weight: 400; 
}

hr{
    width: 10%;
    color: #fff;
}

.form-group{
    margin-bottom: 15px;
}

label{
    margin-bottom: 15px;
}

input,
input::-webkit-input-placeholder {
    font-size: 11px;
    padding-top: 3px;
}

.main-login{
    background-color: #fff;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

}

.main-center{
    margin-top: 30px;
    margin: 0 auto;
    max-width: 330px;
    padding: 40px 40px;

}

.login-button{
    margin-top: 5px;
}

.login-register{
    font-size: 11px;
    text-align: center;
}

</style>
</head>
    <body>
          <?php

         if(isset($product)){ echo form_open_multipart('Products/update/'.$product->id, ['class' => 'form-signin GlobalForm', 'role' => 'form','name'=>'registration','id'=>'btnsubmit']); }  
         else { echo form_open_multipart('Products/store', ['class' => 'form-signin GlobalForm', 'role' => 'form','name'=>'registration','id'=>'btnsubmit']); } ?>
        <div class="container">
            <div class="row main">
                <div class="panel-heading">
                   <div class="panel-title text-center">
                        <h1 class="title">Simple Crud</h1>
                        <hr />
                    </div>
                </div> 
                
                <div class="main-login main-center">
                    
                <?php
                $msg = $this->session->flashdata('message_name');
                if(isset($msg)) {
$message = $this->session->flashdata('message_name');
?>
<div class="alert alert-success"><?php echo $message; ?></div>
<?php
      } ?>           
                        <div class="form-group">
    <label for="email">Title:</label>
    <input type="text" class="form-control" id="title" placeholder="Enter Your Title" name="title" value="<?= isset($product) ? @$product->title : set_value('title'); ?>" data-fv-notempty="true" data-fv-notempty-message="Please Enter Title">
    <?php echo form_error('title', '<div class="error" style="color:red">', '</div>'); ?>
    <div id="tit"></div>
  </div>
  
  <div class="form-group">
    <label for="pwd">Description:</label>
    <textarea name="description" placeholder="Enter Your Description" class="form-control" id="description" data-fv-notempty="true" data-fv-notempty-message="Please Enter Description"><?= isset($product) ? @$product->description : set_value('description'); ?></textarea>
    <?php echo form_error('description', '<div class="error" style="color:red">', '</div>'); ?>
    <div id="des"></div>
  </div>
  
  

 <?php  if(isset($product)) { ?>
 <div class="form-group">
    <label for="pwd">Image:</label>
  <input type="file" name="image" size="20" class="form-control" id="image"  data-fv-file="true" data-fv-file-extension="jpeg,jpg,png" data-fv-file-type="image/jpeg,image/png" data-fv-file-maxsize="2097152" data-fv-file-message="The Selected File Only Jpeg Jpg Png"/>
  <?php
if(isset($error)){
 echo "<div class='error' style='color:red'>$error</div>";
}

?>  
<div id="img"></div>
  </div>
<?php }
else{ ?>
<div class="form-group">
    <label for="pwd">Image:</label>
  <input type="file" name="image" size="20" class="form-control" id="image" data-fv-notempty="true" data-fv-notempty-message="Please Select Image" data-fv-file="true" data-fv-file-extension="jpeg,jpg,png" data-fv-file-type="image/jpeg,image/png" data-fv-file-maxsize="2097152" data-fv-file-message="The Selected File Only Jpeg Jpg Png"/>
  <?php
if(isset($error)){
 echo "<div class='error' style='color:red'>$error</div>";
}

?>  
<div id="img"></div>
  </div> <?php
} 
?>
  <div class="form-group">
    <label>Category:</label>
    <select name="category" class="form-control" id="category">
        <option value="abc" <?php if(isset($product)) if($product->category == 'abc') echo 'selected'; ?>>Abc</option>
        <option value="def" <?php if(isset($product)) if($product->category === 'def') echo "selected"; ?>>Def</option>
        <option value="ghi" <?php if(isset($product)) if($product->category === 'ghi') echo "selected"; ?>>Ghi</option>
    </select>
    <?php echo form_error('category', '<div class="error" style="color:red">', '</div>'); ?>
  </div>
  
  <div class="form-group">
    <label>Publish:</label>&nbsp
    <input type="radio" name="publish" value="yes" <?php if(isset($product)) if($product->publish === 'yes') echo "checked"; ?> checked>Yes
    <input type="radio" name="publish" value="no" <?php if(isset($product)) if($product->publish === 'no') echo "checked"; ?>>No
    <?php echo form_error('publish', '<div class="error" style="color:red">', '</div>'); ?>
  </div>  
  
<?php 
if(isset($product))
{
  $focus=explode(",",@$product->type);
}
?>
  <div class="form-group">
    <label>Type:</label>
    <input type="checkbox" name="type[]" value="a" <?php if(isset($product) && in_array("a",@$focus)) { ?> checked="checked" <?php } ?>>a
    <input type="checkbox" name="type[]" value="b" <?php if(isset($product) && in_array("b",@$focus)) { ?> checked="checked" <?php } ?>>b
    <input type="checkbox" name="type[]" value="c" <?php if(isset($product) && in_array("c",@$focus)) { ?> checked="checked" <?php } ?>>c
    <?php echo form_error('type[]', '<div class="error" style="color:red">', '</div>'); ?>  
  </div>

  <button type="submit" class="btn btn-default" id="submit">Submit</button>
                    
                </div>
            </div>
        </div>


<?php echo form_close(); ?>
