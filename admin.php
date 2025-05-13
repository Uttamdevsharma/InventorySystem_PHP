<?php    
  $page_title = 'Admin Home Page';    
  require_once('includes/load.php');    
  // Checkin What level user has permission to view this page    
  page_require_level(1);    
?>    
<?php    
  // Add error checking and default values    
  $c_categorie     = count_by_id('categories') ?: ['total' => 0];    
  $c_product       = count_by_id('products') ?: ['total' => 0];    
  $c_sale          = count_by_id('sales') ?: ['total' => 0];    
  $c_user          = count_by_id('users') ?: ['total' => 0];    
  $products_sold   = find_higest_saleing_product('10') ?: [];    
  $recent_products = find_recent_product_added('5') ?: [];    
  $recent_sales    = find_recent_sale_added('5') ?: [];    
      
  // Get count of low stock products      
  $threshold = 10;      
  $sql = "SELECT COUNT(id) AS low_stock_count FROM products WHERE quantity <= {$threshold}";      
  $result = $db->query($sql);      
  $low_stock = $db->fetch_assoc($result);      
  $low_stock_count = isset($low_stock['low_stock_count']) ? $low_stock['low_stock_count'] : 0;      
?>  
<?php include_once('layouts/header.php'); ?>  
  
<!-- Remove debug information in production -->  
<?php if(false): // Set to false to hide debug info ?>  
  <pre>Database connection: <?php var_dump($db); ?></pre>  
  <pre>Test query result: <?php var_dump($db->query("SELECT COUNT(*) FROM users")); ?></pre>  
<?php endif; ?>  
        
<div class="row">    
   <div class="col-md-6">    
     <?php echo display_msg($msg); ?>    
   </div>    
</div>    
  
<div class="dashboard-container">    
  <div class="stats-row">    
    <!-- Users Card -->    
    <a href="users.php" class="stat-card users-card">    
      <div class="stat-icon">    
        <i class="glyphicon glyphicon-user"></i>    
      </div>    
      <div class="stat-content">    
        <h3><?php echo $c_user['total']; ?></h3>    
        <p>Users</p>    
      </div>    
    </a>    
        
    <!-- Categories Card -->    
    <a href="categorie.php" class="stat-card categories-card">    
      <div class="stat-icon">    
        <i class="glyphicon glyphicon-th-large"></i>    
      </div>    
      <div class="stat-content">    
        <h3><?php echo $c_categorie['total']; ?></h3>    
        <p>Categories</p>    
      </div>    
    </a>    
        
    <!-- Products Card -->    
    <a href="product.php" class="stat-card products-card">    
      <div class="stat-icon">    
        <i class="glyphicon glyphicon-shopping-cart"></i>    
      </div>    
      <div class="stat-content">    
        <h3><?php echo $c_product['total']; ?></h3>    
        <p>Products</p>    
      </div>    
    </a>    
        
    <!-- Sales Card -->    
    <a href="sales.php" class="stat-card sales-card">    
      <div class="stat-icon">    
        <i >TK</i>    
      </div>    
      <div class="stat-content">    
        <h3><?php echo $c_sale['total']; ?></h3>    
        <p>Sales</p>    
      </div>    
    </a>    
        
    <!-- Low Stock Card -->    
    <a href="low_stock_alert.php" class="stat-card low-stock-card">    
      <div class="stat-icon">    
        <i class="glyphicon glyphicon-warning-sign"></i>    
      </div>    
      <div class="stat-content">    
        <h3><?php echo $low_stock_count; ?></h3>    
        <p>Low Stock</p>    
      </div>    
    </a>    
  </div>    
      
  <div class="dashboard-content">    
    <!-- Highest Selling Products -->    
    <div class="content-card">    
      <h3>    
        <i class="glyphicon glyphicon-th"></i>    
        Highest Selling Productss    
      </h3>    
      <table class="dashboard-table">    
        <thead>    
          <tr>    
            <th>Title</th>    
            <th>Total Sold</th>    
            <th>Total Quantity</th>    
          </tr>    
        </thead>    
        <tbody>    
          <?php foreach ($products_sold as $product_sold): ?>    
            <tr>    
              <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>    
              <td><?php echo (int)$product_sold['totalSold']; ?></td>    
              <td><?php echo (int)$product_sold['totalQty']; ?></td>    
            </tr>    
          <?php endforeach; ?>    
        </tbody>    
      </table>    
    </div>    
        
    <!-- Latest Sales -->    
    <div class="content-card">    
      <h3>    
        <i class="glyphicon glyphicon-th"></i>    
        Latest Sales    
      </h3>    
      <table class="dashboard-table">    
        <thead>    
          <tr>    
            <th class="text-center" style="width: 50px;">#</th>    
            <th>Product Name</th>    
            <th>Date</th>    
            <th>Total Sale</th>    
          </tr>    
        </thead>    
        <tbody>    
          <?php foreach ($recent_sales as $recent_sale): ?>    
            <tr>    
              <td class="text-center"><?php echo count_id();?></td>    
              <td>    
                <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">    
                  <?php echo remove_junk(first_character($recent_sale['name'])); ?>    
                </a>    
              </td>    
              <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>    
              <td>TK<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>    
            </tr>    
          <?php endforeach; ?>    
        </tbody>    
      </table>    
    </div>    
        
    <!-- Recently Added Products -->    
    <div class="content-card">    
      <h3>    
        <i class="glyphicon glyphicon-th"></i>    
        Recently Added Products    
      </h3>    
      <div class="product-list">    
        <?php foreach ($recent_products as $recent_product): ?>    
          <a href="edit_product.php?id=<?php echo (int)$recent_product['id'];?>" class="product-item">    
            <div class="product-image">    
              <?php if($recent_product['media_id'] === '0'): ?>    
                <img src="uploads/products/no_image.png" alt="">    
              <?php else: ?>    
                <img src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />    
              <?php endif;?>    
            </div>    
            <div class="product-details">    
              <h4><?php echo remove_junk(first_character($recent_product['name']));?></h4>    
              <span class="price">TK<?php echo (int)$recent_product['sale_price']; ?></span>    
              <span class="category"><?php echo remove_junk(first_character($recent_product['categorie'])); ?></span>    
            </div>    
          </a>    
        <?php endforeach; ?>    
      </div>    
    </div>    
  </div>    
</div>  
  
<?php include_once('layouts/footer.php'); ?>