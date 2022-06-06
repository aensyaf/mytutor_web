<?php
   session_start();
   if(!isset($_SESSION['sessionid'])){
       echo "<script>alert('Session not available. Please register again');</script>";
       echo "<script> window.location.replace('../php/login.php')</script>";
   }
   
   if (isset($_POST['submit'])) {
      include_once("dbconnect.php");
      $name = $_POST["name"];
      $email = $_POST["email"];
      $num = $_POST["num"];
      $address = $_POST["address"];
      $password = sha1($_POST["password"]);
      $sqlregister = "INSERT INTO `tbl_users`(`user_name`, `user_email`, `user_num`, `user_address`, `user_pass`) 
      VALUES ('$name','$email','$num','$address','$password')";

      try {
         $conn->exec($sqlregister);
         if(file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])){
            $last_id = $conn->lastInsertId();
            uploadImage($last_id);
            echo "<script>alert('Registration successful! You may login to our website')</script>";
            echo "<script>window.location.replace('login.php')</script>";
         }
      }
      catch (PDOException $e) {
         echo "<script>alert('Registration failed. Please try again.')</script>";
         echo "<script>window.location.replace('register.php')</script>";
      }
   }

   function uploadImage($filename){
      $target_dir= "../images/userpic/";
      $target_file= $target_dir . $filename . ".png";
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
   }
?>

<!DOCTYPE html>
<html>
  <head>
      <title>Registration</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="../css/style.css">
      <script src="../js/script.js"></script>
      <script>
        function sideMenu() {
            var x = document.getElementById("idsidemenu");
            if(x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            }
            else{
                x.className = x.className.replace(" w3-show", "");
            }
        }
      </script>
   </head>
   <body> 
      <section class="w3-black">
         <div class="w3-bar w3-padding">
               <a href="login.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-grey w3-round-xlarge w3-hover-red">Login</a>
               <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="sideMenu()">&#9776</a>
         </div>
         <div id="idsidemenu" class="w3-white w3-hover-red w3-bar-block w3-hide w3-hide-large w3-hide-medium">
            <a href="login.php" class="w3-bar-item w3-button w3-center">Login</a>
         </div>
         <div class="w3-main w3-content w3-padding-32 w3-animate-bottom" style="max-width:1400px;font-family:Montserrat">
            <div class="w3-row w3-padding-16">
               <div class="w3-half w3-container w3-min-opacity w3-center w3-min-opacity w3-padding-32">
                  <br><img class="w3-center" style="width:100%; height:100%;" src="../images/regimg.png">
               </div>
               <div class="w3-half w3-container w3-padding-16 w3-border">
                  <h4 class="welcome w3-center" style="font-size:32px">Create an account</h4>
                  <p class="textp w3-center">We make it easy for you to search for the best tutors.</p>
                     <form name="registerForm" id="form" action="register.php" method="post" onsubmit="return confirmDialog()" enctype="multipart/form-data">
                        <div class="w3-container w3-center w3-padding">
                           <img class="w3-image w3-round w3-margin w3-border" src="../images/profile.png" style="width:200px; max-width:600px;"><br>
                           <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                        </div><br>
                        <div style="font-family:Montserrat">
                           <label class="w3-text-white"><i class="fa fa-user"></i> | Full name</label>
                           <input class="w3-input w3-border w3-round" type="name" name="name" placeholder="e.g Ali bin Abu" id="nameid" />
                        </div><br>
                        <div style="font-family:Montserrat">
                           <label class="w3-text-white"><i class="fa fa-envelope"></i> | Email</label>
                           <input class="w3-input w3-border w3-round" type="email" name="email" placeholder="e.g ali@gmail.com" id="emailid" />
                        </div><br>
                        <div style="font-family:Montserrat">
                           <label class="w3-text-white"><i class="fa fa-phone"></i> | Contact no</label>
                           <input class="w3-input w3-border w3-round" placeholder="e.g 0123459876" name="num" id="numid" />
                        </div><br>
                        <div style="font-family:Montserrat">
                           <label class="w3-text-white"><i class="fa-solid fa-house-chimney-user"></i> | Address</label>
                           <textarea class="w3-input w3-border w3-round" type="address" name="address" placeholder="Street, city, postcode, state" id="addid" ></textarea>
                        </div><br>
                        <div style="font-family:Montserrat">
                           <label class="w3-text-white"><i class="fa-solid fa-lock"></i> | Password</label>
                           <input class="w3-input w3-border w3-round" type="password" name="password" placeholder="********" id="passid"/>
                        </div><br>
                        <input style="font-family:Montserrat" class="w3-btn w3-round w3-border w3-red w3-block w3-hover-white" type="submit" value="REGISTER" name="submit"></input>
                     </form>
                     <hr>
                     <p>
                        <p class="w3-center w3-text-white">Already registered?<b><a class="w3-text-red" style="text-decoration:none;" href="login.php"> Login Here</a></b>
                        </p>
                     </p>
               </div>
            </div>
         </div>
      </section>
      <footer class="smalltext w3-red">
        <p>Copyright &copy;2022 MY Tutor | Get serious, get tutor | Your use of this website constitutes acceptance of the Terms of Use, Privacy Policy and Cookie Policy. Do Not Sell My Personal Information </p>
      </footer>
   </body>
</html>