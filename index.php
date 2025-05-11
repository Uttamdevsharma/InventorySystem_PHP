<?php  
ob_start();  
require_once('includes/load.php');  
if($session->isUserLoggedIn(true)) { redirect('home.php', false);}  
?>  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ElectroMart Admin Login</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
    }
    
    body {
      height: 100vh;
      background: linear-gradient(to bottom right, #0f054c, #4528dc);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: white;
    }
    
    .container {
      text-align: center;
    }
    
    .brand {
      font-size: 2.5rem;
      font-weight: bold;
    }
    
    .subtitle {
      margin-bottom: 2rem;
      color: #d2d2f4;
    }
    
    .login-card {
      background-color: white;
      color: #333;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
      width: 350px;
      text-align: left;
    }
    
    .login-card h2 {
      color: #4a5dff;
      text-align: center;
      margin-bottom: 0.3rem;
    }
    
    .desc {
      text-align: center;
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 1rem;
    }
    
    label {
      font-weight: 600;
      display: block;
      margin-bottom: 0.3rem;
      margin-top: 1rem;
    }
    
    input {
      width: 100%;
      padding: 10px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 1rem;
    }
    
    button {
      margin-top: 1.5rem;
      width: 100%;
      padding: 12px;
      background-color: #4a5dff;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    
    button:hover {
      background-color: #3541d1;
    }
    
    footer {
      text-align: center;
      font-size: 0.8rem;
      color: #888;
      margin-top: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="brand">ElectroMart</h1>
    <p class="subtitle">Premium Electronics Inventory System</p>
    
    <div class="login-card">
      <h2>Login Panel</h2>
      <p class="desc">Enter your credentials to continue</p>
      
      <?php echo display_msg($msg); ?>
      
      <form method="post" action="auth.php" class="clearfix">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required />
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required />
        
        <button type="submit">Login</button>
      </form>
      
      <footer>© 2025 ElectroMart Inventory System</footer>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
</body>
</html>