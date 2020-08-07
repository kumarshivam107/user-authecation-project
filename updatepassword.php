<?php
include 'dbconnect.php';
$allowChange = false;
    $email = $_GET["email"];
    $token = $_GET["token"];
    $sql ="select * from `users` WHERE email ='$email' AND token = '$token'";
    $result = mysqli_query($connection,$sql);
    $row= mysqli_num_rows($result);
    if($row == 1){
        $allowChange = true;
    }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Update Password</title>
    <style>
    .main-section {
        width: 100%;
        height: 100vh;
        background-image: url("images/bg-01.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }

    .innerSection {
        height: auto;
        background-color: white;
        position: relative;
        top: 100px;
        border-radius: 20px;
        padding:10px;
    }
    </style>
</head>

<body>
    <!--********* Navbar Section Starts Here ******************-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Authentication Project</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/finalauth/signup.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/finalauth/login.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Project Description</a>
                </li>
            </ul>
        </div>
    </nav>
    <!--********* Navbar Section Closes Here ******************-->

    <!-- ********** Update Modal Section Starts Here *********-->
    <div class="main-section">
        <div class="container innerSection">
            <p style="color:green;" id="showMassege"></p>
            <p style="color:red;" id="showErr"></p>
            <form id="ChangeForm">
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password Here">
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter Confirm Your Password Here">
                </div>
            </form>
            <?php
                if($allowChange){
                    echo '<button id="submitBtn" class="btn btn-success">Submit</button><br>
                    <input type="hidden" id="emailval" value="'.$email.'">
                    <input type="hidden" id="tokenval" value="'.$token.'">
                    ';

                }
                else{
                    echo 'You Are Not Allowed To Change The Password.';
                }
            ?>
        </div>
    </div>
    <!--************** Update Modal Section Closes Here ******-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script>
        $(document).ready(function(){
            $("#submitBtn").click(function(e){
                e.preventDefault();
                var password = $("#password").val();
                var cpassword = $("#cpassword").val();
                var emailval = $("#emailval").val();
                var tokenval = $("#tokenval").val();
                $.ajax({
                    url:"resetpassword.php",
                    type:"post",
                    data:{password:password,cpassword:cpassword,emailval:emailval,tokenval:tokenval},
                    success:function(data){
                        console.log(data);
                        if (data == 1){
                            $("#showMassege").text("Your Password Has Been Successfully Changed.");
                            $("#ChangeForm").trigger("reset");
                        }
                        else if (data==2){
                            $("#showErr").text("token Mismatch");
                            $("#ChangeForm").trigger("reset");
                        }
                        else if (data==3){
                            $("#showErr").text("No Email Exists");
                            $("#ChangeForm").trigger("reset");
                        }
                        else{
                            $("#showErr").text("Server Err. Kindly Try After Some Time.");
                            $("#ChangeForm").trigger("reset");
                        }
                    }
                })
            });
        });
     </script>
</body>

</html>