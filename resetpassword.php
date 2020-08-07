<?php
include 'dbconnect.php';
$password=$_POST["password"];
$cpassword = $_POST["cpassword"];
if($password==$cpassword){
    $email = $_POST["emailval"];  
    $sql = "select * from `users` WHERE email ='$email'";
    $query = mysqli_query($connection,$sql);
    $num =mysqli_num_rows($query);
    $row = mysqli_fetch_assoc($query);
    if($num==0){
        echo  3;
    }
    else{
        $token = $_POST['tokenval'];
        $ctoken=$row["token"];
        if($token==$ctoken){
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $updatequery ="UPDATE `users` SET `password` = '$hash' WHERE `users`.`email` = '$email'";
            $updatepassword = mysqli_query($connection,$updatequery);
            if($updatepassword){
                echo 1;

            }
            else{
                echo 0;
            }
        }
        else{
                echo 2;
        }
    }
}

?>