<?php
require __DIR__ . "/src/config.php";

try {
  $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $pdo->exec("CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
  $pdo->exec("USE $db_name");

  foreach (glob(__DIR__ . "/migrations/*.sql") as $file) {
    $sql = file_get_contents($file);
    try {
      $pdo->exec($sql);
      echo "Executed: " . basename($file) . "<br>";
    } catch (PDOException $e) {
      echo "Failed in " . basename($file) . ": " . $e->getMessage() . "<br>";
    }
  }
  echo "Migration executed";
} catch (PDOException $e) {
  die("DB setup failed: " . $e->getMessage());
}
