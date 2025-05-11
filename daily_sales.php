<?php  
  $page_title = 'Daily Sales';  
  require_once('includes/load.php');  
  require_once('includes/sql.php'); // Added this line to ensure the dailySales function is loaded  
  // Checkin What level user has permission to view this page  
  page_require_level(3);  
?>  
  
<?php  
  $year = date('Y');  
  $month = date('m');  
  $day = null;  
    
  // Check if a specific date was selected  
  if(isset($_POST['submit']) && !empty($_POST['selected_date'])) {  
    $selected_date = date('Y-m-d', strtotime($_POST['selected_date']));  
    $year = date('Y', strtotime($selected_date));  
    $month = date('m', strtotime($selected_date));  
    $day = date('d', strtotime($selected_date));  
    $sales = dailySales($year, $month, $day);  
  } else {  
    $sales = dailySales($year, $month);  
  }  
?>  
  
<?php include_once('layouts/header.php'); ?>  
  
<div class="row">  
  <div class="col-md-6">  
    <?php echo display_msg($msg); ?>  
  </div>  
</div>  
  
<div class="row">  
  <div class="col-md-12">  
    <div class="panel panel-default">  
      <div class="panel-heading clearfix">  
        <strong>  
          <span class="glyphicon glyphicon-th"></span>  
          <span>Daily Sales</span>  
        </strong>  
      </div>  
        
      <!-- Add date selection form -->  
      <div class="panel-body">  
        <form method="post" action="daily_sales.php" class="clearfix">  
          <div class="form-group">  
            <div class="input-group">  
              <span class="input-group-addon">  
                <i class="glyphicon glyphicon-calendar"></i>  
              </span>  
              <input type="date" name="selected_date" class="form-control" placeholder="Select Date">  
              <span class="input-group-btn">  
                <button type="submit" name="submit" class="btn btn-primary">Show Sales</button>  
              </span>  
            </div>  
          </div>  
        </form>  
          
        <table class="table table-bordered table-striped">  
          <thead>  
            <tr>  
              <th class="text-center" style="width: 50px;">#</th>  
              <th>Product name</th>  
              <th class="text-center" style="width: 15%;">Quantity sold</th>  
              <th class="text-center" style="width: 15%;">Total</th>  
              <th class="text-center" style="width: 15%;">Date</th>  
            </tr>  
          </thead>  
          <tbody>  
            <?php foreach ($sales as $sale): ?>  
            <tr>  
              <td class="text-center"><?php echo count_id(); ?></td>  
              <td><?php echo remove_junk($sale['name']); ?></td>  
              <td class="text-center"><?php echo (int)$sale['qty']; ?></td>  
              <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>  
              <td class="text-center"><?php echo $sale['date']; ?></td>  
            </tr>  
            <?php endforeach; ?>  
          </tbody>  
        </table>  
      </div>  
    </div>  
  </div>  
</div>  
  
<?php include_once('layouts/footer.php'); ?>