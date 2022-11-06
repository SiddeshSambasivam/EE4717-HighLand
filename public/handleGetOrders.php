<?php
  
  include("../src/db_connect.php");            

  session_start();

  $user_id = $_POST["user_id"];
  
  $sql = "SELECT * FROM orders WHERE user_id = $user_id";
  $result = $conn->query($sql);

  $orders = array();
  
  while($row = $result->fetch_assoc()){
    // push each row into the array
    $order_id = $row['order_id'];
    $user_id = $row['user_id'];
    $total_price = $row['total_price'];
    $order_date = $row['order_date'];
    $address = $row['address'];
    $status = $row['status'];

    $order = array(
      "order_id" => $order_id,
      "user_id" => $user_id,
      "total_price" => $total_price,
      "order_date" => $order_date,
      "address" => $address,
      "status" => $status
    );

    array_push($orders, $order);
    
  }

  echo json_encode($orders);

?>
