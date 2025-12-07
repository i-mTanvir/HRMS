<?php

    include 'connection.php';

    $id = $_GET['id'];

    $query = "DELETE FROM product WHERE id = '$id'";
    
    $run = mysqli_query($con, $query);

    if(!$run){
        echo 'delete operation failed!';
    } else{
        header("location: product_display.php");
    }

?>