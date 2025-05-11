<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

 if(isset($_POST['add_sale'])){  //form submit
  $req_fields = array('s_id','quantity','price','total', 'date' );  
  validate_fields($req_fields);  
  if(empty($errors)){  
    $p_id      = $db->escape((int)$_POST['s_id']);  
    $s_qty     = $db->escape((int)$_POST['quantity']);  
    $s_total   = $db->escape($_POST['total']);  
    $date      = $db->escape($_POST['date']);  
    //$s_date    = make_date();
    $s_date = date('Y-m-d', strtotime($date));  
      //error na thakle db te songroho



    // stock jacai 
    $sql_check = "SELECT quantity FROM products WHERE id = '{$p_id}' LIMIT 1";  
    $result_check = $db->query($sql_check);  
    $product = $db->fetch_assoc($result_check);  
    $current_qty = (int)$product['quantity'];  
      
    if($current_qty < $s_qty) {  
      $session->msg('d', "Insufficient stock! Current stock: {$current_qty}");  
      redirect('add_sale.php', false);  
      return;  
    }  


      
    $sql  = "INSERT INTO sales (";  
    $sql .= " product_id,qty,price,date";  
    $sql .= ") VALUES (";  
    $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";  
    $sql .= ")";  
      
    if($db->query($sql)){  
      $update_result = update_product_qty($s_qty,$p_id);//product stock koma  
      if($update_result) {  
        $session->msg('s',"Sale has been added. ");  
      } else {  
        $session->msg('d',"স্টক আপডেট করতে সমস্যা হয়েছে।");  
      }  
      redirect('add_sale.php', false);  
    } else {  
      $session->msg('d',' দুঃখিত, যোগ করতে ব্যর্থ হয়েছে!');  
      redirect('add_sale.php', false);  
    }  
  } else {  
    $session->msg("d", $errors);  
    redirect('add_sale.php',false);  
  }  
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Find It</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for product name">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Sale Edit</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Item </th>
            <th> Price </th>
            <th> Qty </th>
            <th> Total </th>
            <th> Date</th>
            <th> Action</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
