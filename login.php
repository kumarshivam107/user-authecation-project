<?php
include 'dbconnect.php';
$loggedin  = false;
$loggedinErrorone=false;
$loggedinError = false;
$logininactive = false;
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = $_POST["email"];
    $password =$_POST["password"];
    $sql = "Select * from users where email ='$email'";
    $result = mysqli_query($connection,$sql);
    $num = mysqli_num_rows($result);
    if($num==1){
        $row = mysqli_fetch_assoc($result);
        $status = $row["status"];
        if($status=="inactive"){
            $logininactive= true;
        }
        else{
            if (password_verify($password,$row['password'])){
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["email"]= $email;
                header("location:/finalauth/welcome.php");
            }
            else{
                $loggedinError=true;
            }
        }
    }
    else{
        $loggedinError=true;
    }
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
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="index.css">
    <title>Login Page</title>

    <style>
        .ii {
            border: 2px solid grey;
            border-left: 0px;
            border-right: 0px;
            border-top: 0px;
        }

        .main-sectionone{
            width:100%;
            background-image: url("images/bg-01.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .form-section {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
        }
        .loginBtn{
            background-color: rgb(235, 37, 192)!important;
            border:none!important;
        }
    </style>

</head>

<body>
     <!--********* Navbar Section Starts Here ******************-->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Authentication Project</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
        <a class="nav-link" href="/finalauth/projectdesc.php">Project Description</a>
      </li>
    </ul>
  </div>
</nav>
    <!--********* Navbar Section Closes Here ******************-->

    <!--******** Massege Showwing Section As A Dismissable Alert Starts Here  -->
    <?php
    if ($loggedinErrorone){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Error! Invalid Credential. Please Fill with Right Credentials.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if ($logininactive){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Error! Your Account is Inactive. Kindly Activate Your Account By Clicking on Verfication Email.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <!--******** Massege Showwing Section As A Dismissable Alert Close Here  -->
    <section class="main-sectionone">
        <div class="container">
            <div class="row">
                <div class="col-lg-5  offset-lg-4 col-md-6 col-sm-6 my-3 form-section">
                    <h3 class="text-center my-5 mb-5">Login</h3>
                    <form onsubmit="return validiateFrom()" action="login.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Username</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class='far fa-user'
                                            style='font-size:24px'></i></span>
                                </div>
                                <input type="text" class="form-control ii" id="nameValue" name="email" placeholder="Username" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <!-- Showwing Username Error Field -->
                        <p style="color:red;" id="userErr"></p>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class="fa fa-lock"
                                            style="font-size:24px"></i></span>
                                </div>
                                <input type="password" class="form-control ii" name="password" id="passwordValue" placeholder="Type Your Passwword Here"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <!-- Showing Error For Password Field-->
                        <p style="color:red;" id="passwordErr"></p>

                        <div style="text-align:right; margin-bottom: 5px;">
                            <a href="#" data-toggle="modal" data-target="#forgotModal">Forget Password</a>
                        </div>
                    <button type="submit" class="btn btn-primary loginBtn btn-block">Submit</button>
                </form>

                <div class="socianBtn my-5">
                    <p class="text-center">Or Login Using</p>
                    <p class="text-center"><i class="fa fa-google" style="font-size:48px;color:red"></i>
                    <i class="fa fa-facebook-square mx-4" style="font-size:48px;color:blue"></i>
                    <i class="fa fa-twitter-square" style="font-size:48px;color:rgb(28, 138, 153)"></i></p>
                </div>

                <div>
                    <p class="text-center">Don't Have a Account</p>
                    <p class="text-center"><a href="/finalauth/signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
        </div>
    </section>

            <!--********* Forget Password Starts Here ***************-->
            <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="forgotModalLabel">Forget Password</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <form id="forgotForm">
                        <p style="color:green;" id="massegeBody"></p>
                        <p style="color:red;" id="massegeErr"></p>
                          <div class="form-group">
                                <p class="forgotResponse"></p>
                              <label for="name">Email</label>
                              <input type="email" class="form-control" id="forgotemail" name="forgotemail" placeholder="Enter Your Email id">
                          </div>
                          <button type="submit"  id="forgetBtn" class="btn btn-primary">Recover Your Account</button>
                          <button class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--********* Forget Password Closes Here ***************-->
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#forgetBtn").click(function(e){
                e.preventDefault();
                var email = $("#forgotemail").val();
                $.ajax({
                    url:"forgotpassword.php",
                    type:"post",
                    data:{email:email},
                    success:function(data){
                        if (data==1){
                            $("#massegeBody").text("A Confirmation Mail Send to Email Id With Passord Resest Instructions.");
                            $("#forgotForm").trigger("reset");
                        }
                        else{
                            $("#massegeErr").text("No Such Email Exists in Our Database.");
                            $("#forgotForm").trigger("reset");
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>