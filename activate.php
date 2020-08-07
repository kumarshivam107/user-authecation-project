<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Activation Page</title>
    <style>
    .main-section {
        width: 100;
        height: 100vh;
        background-image: url("images/bg-01.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }

    .innerSection {
        height: 100px;
        background-color: white;
        position: relative;
        top: 100px;
        border-radius: 20px;
    }
    </style>
</head>

<body>
    <?php
    // Including the Navbar File:-
  include 'navbar.php';
    ?>
    <section class="main-section">
        <div class="container innerSection">
            <?php
              include 'dbconnect.php';
              if(isset($_GET["token"])){
                  $token = $_GET["token"];
                  $email = $_GET["email"];
                  $verifyquery = " Select * from users where email ='$email'";
                  $result = mysqli_query($connection,$verifyquery);
                  $row=mysqli_fetch_assoc($result);
                  $emailtoken=$row["token"];
                  $sno=number_format($row["sno"]);
                  if($token==$emailtoken){
                      $updatequery ="UPDATE `users` SET `status` = 'active' WHERE `users`.`sno` = '$sno'";
                      $res= mysqli_query($connection,$updatequery);
                      echo "<div class='py-2 text-center'>
                        <p>Your Account Has Been Successfully Activated.</p>
                        <p>Click Here To <a href='/finalauth/login.php'>Login<a></p>
                      </div>";
                  }
                  else{
                      echo "inavlid Token Identifier Number";
                  }
              }
              else{
                  echo "Toekn is not set.";
              }
            ?>
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
</body>

</html>