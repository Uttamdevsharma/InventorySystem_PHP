<?php  
// low_stock_alert.php  
$page_title = 'Low Stock Alert';  
require_once('includes/load.php');  
page_require_level(2);  
  
// Set minimum stock threshold  
$threshold = 10;  
  
// Get products with low stock  
$sql = "SELECT p.id, p.name, p.quantity, c.name AS category ";  
$sql .= "FROM products p ";  
$sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";  
$sql .= "WHERE p.quantity <= {$threshold} ";  
$sql .= "ORDER BY p.quantity ASC";  
$low_stock_products = find_by_sql($sql);  
?>  
  
<?php include_once('layouts/header.php'); ?>  
  
<div class="row">  
  <div class="col-md-12">  
    <div class="panel panel-default">  
      <div class="panel-heading">  
        <strong>  
          <span class="glyphicon glyphicon-warning-sign"></span>  
          <span>কম স্টক অ্যালার্ট</span>  
        </strong>  
      </div>  
      <div class="panel-body">  
        <?php if(empty($low_stock_products)): ?>  
          <div class="alert alert-success">সব পণ্যের স্টক পর্যাপ্ত আছে!</div>  
        <?php else: ?>  
          <table class="table table-bordered table-striped">  
            <thead>  
              <tr>  
                <th class="text-center" style="width: 50px;">#</th>  
                <th>পণ্যের নাম</th>  
                <th>ক্যাটাগরি</th>  
                <th class="text-center" style="width: 15%;">বর্তমান স্টক</th>  
                <th class="text-center" style="width: 15%;">অ্যাকশন</th>  
              </tr>  
            </thead>  
            <tbody>  
              <?php foreach ($low_stock_products as $product): ?>  
                <tr class="<?php echo ($product['quantity'] <= 5) ? 'danger' : 'warning'; ?>">  
                  <td class="text-center"><?php echo count_id(); ?></td>  
                  <td><?php echo remove_junk($product['name']); ?></td>  
                  <td><?php echo remove_junk($product['category']); ?></td>  
                  <td class="text-center"><?php echo (int)$product['quantity']; ?></td>  
                  <td class="text-center">  
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs">  
                      স্টক আপডেট করুন  
                    </a>  
                  </td>  
                </tr>  
              <?php endforeach; ?>  
            </tbody>  
          </table>  
        <?php endif; ?>  
      </div>  
    </div>  
  </div>  
</div>  
  
<?php include_once('layouts/footer.php'); ?>