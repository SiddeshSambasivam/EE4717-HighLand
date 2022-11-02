<?php
  
  include("../src/db_connect.php");            

  session_start();

  $data = $_POST['data'];
  $user_id = $_POST["user_id"];
  $total_price = $_POST["total_price"];
  $address = $_POST["address"];
  $status = $_POST["status"];
  $date = date("Y-m-d H:i:s");
  
  $sql = "INSERT INTO `orders` (`user_id`, `total_price`, `order_date`,`address`, `status`) VALUES ('$user_id', '$total_price', '$date', '$address', '$status')";
  $result = $conn->query($sql);
  $order_id = $conn->insert_id;
    

  for($i = 0; $i < count($data); $i++){
    $item = $data[$i];
    $item_id = $item['id'];
    $item_qty = $item['qty'];
    $item_price = $item['price'];


    $item_size = $item['size'];
    $item_color = $item['color'];


    $total_price = $item_price * $item_qty;
    
    $sql = "INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`, `size`, `color`) VALUES ('$order_id', '$item_id', '$item_qty', '$item_price', '$item_size', '$item_color')";
    $result = $conn->query($sql);

  }
  
  echo $order_id;
?>
