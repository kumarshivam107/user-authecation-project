<?php
$showAlert =false;
$showError= false;
$exist= false;
include 'dbconnect.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST['name'];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $cpassword =$_POST["cpassword"];
    $token =  bin2hex(random_bytes(15));
    $emailsql = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($connection,$emailsql);
    $numExitRows = mysqli_num_rows($result);
    if ($numExitRows>0){
        $exist = true;
    }
    else{
        if (($password == $cpassword)){
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $sql ="INSERT INTO `users` (`name`, `email`, `mobile`, `password`, `timestamp`,`token`,`status`) VALUES ('$name', '$email', '$mobile', '$hash', 'current_timestamp()','$token','inactive')";
            $result= mysqli_query($connection,$sql);
            if($result){
                // Load Composer's autoloader
                require 'vendor/autoload.php';

                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'krshivam4545@gmail.com';                     // SMTP username
                $mail->Password   = 'Assam@123';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom($email, 'Mailer');
                $mail->addAddress($email, 'Account Activation Mail');     // Add a recipient

                // Content
                //$mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Account Activation Mail';
                $mail->Body    = "Hii You  have to Activate Your Account By Clicking on this link http://localhost/finalauth/activate.php?token=$token&email=$email";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                $_SESSION['msg']="Cheak Your Mail to Activate your Account '.$email.'";
            }
            $showAlert = true;
        }
        else{
            $showError = true;
        }
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
    <title>Signup Page</title>
    <script src="index.js"></script>
    <style>
    .ii {
        border: 2px solid grey;
        border-left: 0px;
        border-right: 0px;
        border-top: 0px;
    }

    .main-sectiontwo {
        width: 100%;
        background-image: url("images/bg-01.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }

    .form-section {
        background-color: white;
        border-radius: 10px;
        padding: 25px;
    }

    .loginBtn {
        background-color: rgb(235, 37, 192) !important;
        border: none !important;
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

    <!--********* Massege Showing Fields Starts Here************-->
    <?php
    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Success! Account Created. Please Activate Your Account By Clicking on Verification Link Send to Your Mail.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if($showError){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Error! Password Mismatch. Plase ReEnter the password.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if($exist){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Error! Email Id Already Exists. You May Try to Login.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <!--********* Massege Showing Fields Closes Here************-->

    <section class="main-sectiontwo">
        <div class="container">
            <div class="row">
                <div class="col-lg-5  offset-lg-4 col-md-6 col-sm-6 my-3 form-section">
                    <h3 class="text-center my-5 mb-5">Signup Form</h3>
                    <form onsubmit="return signupFrom()" action="/finalauth/signup.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Name</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class='far fa-user'
                                            style='font-size:24px'></i></span>
                                </div>
                                <input type="text" class="form-control ii" name="name" id="nameValue"
                                    placeholder="Type Your Name Here" aria-label="Username"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <!-- Showwing Username Error Field -->
                        <p style="color:red;" id="nameErr"></p>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Email</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class='far fa-envelope'
                                            style='font-size:24px'></i></span>
                                </div>
                                <input type="email" class="form-control ii" name="email" id="emailValue"
                                    placeholder="Type Your Email Here" aria-label="Username"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <!-- Showwing Email Error Field -->
                        <p style="color:red;" id="emailErr"></p>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mobile Number</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class='fa fa-phone'
                                            style='font-size:24px'></i></span>
                                </div>
                                <input type="text" class="form-control ii" name="mobile" id="mobileValue"
                                    placeholder="Type Your Mobile Number Here" aria-label="Username"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <!-- Showwing Mobile Error Field -->
                        <p style="color:red;" id="mobileErr"></p>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class="fa fa-lock"
                                            style="font-size:24px"></i></span>
                                </div>
                                <input type="password" class="form-control ii" name="password" id="passwordValue"
                                    placeholder="Type Your Passwword Here" aria-label="Username"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <!-- Showing Error For Password Field-->
                        <p style="color:red;" id="passwordErr"></p>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <div class="input-group mb-3 my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text ii" id="basic-addon1"><i class="fa fa-lock"
                                            style="font-size:24px"></i></span>
                                </div>
                                <input type="password" class="form-control ii" name="cpassword" id="cpasswordValue"
                                    placeholder="Type Your Passwword Here" aria-label="Username"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <!-- Showing Error For Confirm Password Field-->
                        <p style="color:red;" id="cpasswordErr"></p>

                        <button type="submit" class="btn btn-primary loginBtn btn-block">Submit</button>
                    </form>

                    <div class="my-3">
                        <p class="text-center">Already Have an Account</p>
                        <p class="text-center"><a href="/finalauth/login.php">Login</a> Here</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
    <script>
    function signupFrom() {
        // Showing Error For the Name Field is Less Than 5:-
        var name = document.getElementById("nameValue").value;
        if((name.length)<5){
            document.getElementById("nameErr").innerText ="Minimum Lenth of Name is 5.";
            return false;
        }
        
        // Showing Error For Mobile No is less than 10 Character:-
        var mobile = document.getElementById("mobileValue").value;
        console.log(mobile.length);
        if((mobile.length)==10){
            document.getElementById("mobileErr").innerText ="Mobile Number Have At least 10 Digits";
            return flase;
        }

        // Showwing Password if Password is less than 5:-
        var password = document.getElementById("passwordValue").value;
        if((password.length)<5){
            document.getElementById("passwwordErr").innerText ="Length of Password Must be Minimum 5.";
            return flase;
        }
        return true;
    }
    </script>
</body>

</html>