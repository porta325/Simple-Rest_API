<?php

require __DIR__ . "/vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $database = new Database($_ENV["DB_HOST"],
                             $_ENV["DB_NAME"],
                             $_ENV["DB_USER"],
                             $_ENV["DB_PASS"]);
                             
    $conn = $database->getConnection();
    
    $sql = "INSERT INTO user (name, username, password_hash, api_key)
            VALUES (:name, :username, :password_hash, :api_key)";
            
    $stmt = $conn->prepare($sql);
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $api_key = bin2hex(random_bytes(16));
    
    $stmt->bindValue(":name", $_POST["name"], PDO::PARAM_STR);
    $stmt->bindValue(":username", $_POST["username"], PDO::PARAM_STR);
    $stmt->bindValue(":password_hash", $password_hash, PDO::PARAM_STR);
    $stmt->bindValue(":api_key", $api_key, PDO::PARAM_STR);
    
    $stmt->execute();
    
    echo "Thank you for registering. Your API key is ", $api_key;
    exit;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h2>Register</h2>
      <form>
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
        </div>
        <div class="forWm-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" id="username" placeholder="Enter a username" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Enter a password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>

        
        
        
        
        
        
        
        
        
        
        