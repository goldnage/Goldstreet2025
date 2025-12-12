<?php
session_start();
$servername = "127.0.0.1:3306";
$username = "root";
$password = "Titan@2025";
$dbname = "phpusers";

$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch(PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
    die("ERROR: Could not connect. " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["passwd"]);

    echo $username;

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT user_name, user_passwd FROM login_users WHERE user_name = :user_name");
    $user_name_to_fetch = $username;
    echo $input_username;
    $stmt->bindParam(':user_name', $user_name_to_fetch, PDO::PARAM_STR);
    echo $user_name_to_fetch;
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo $row['user_passwd'];
        echo $row['user_name'];
        
       if ($password == $row['user_passwd']) {
            $_SESSION['username'] = $row['user_name'];

            header("Location: welcome.php");
       } else {
            echo "Oops! Something went wrong.";
       }
    } else {
        echo "Oops Something went wrong!";
    }
}
    
$conn = null;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login form</title>
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Login</h2>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username"><br><br>
      <label for="passwd">Password:</label>
      <input type="password" id="passwd" name="passwd"><br><br>
      <input type="submit" value="Login">
    </form>
  </body>
</html>