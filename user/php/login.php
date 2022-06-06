<?php
   if(isset($_POST['submit'])){
      include 'dbconnect.php';
      $email = $_POST['email'];
      $password = sha1($_POST['password']);

      $sqllogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_pass = '$password'";
      $stmt = $conn->prepare($sqllogin);
      $stmt ->execute();
      $number_of_rows = $stmt->fetchColumn();

      if($number_of_rows>0){
         session_start();
         $_SESSION["sessionid"]=session_id();
         echo "<script>alert('Login Successful!')</script>";
         echo "<script> window.location.replace('courses.php')</script>";
      }else{
         echo "<script>alert('Login Failed! Please try again :(')</script>";
         echo "<script> window.location.replace('login.php')</script>";
      }
   }
?>

<!DOCTYPE html>
<html>
  <head>
      <title>MY Tutor</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">      <link rel="stylesheet" type="text/css" href="../css/style.css">
      <link rel="stylesheet" type="text/css" href="../css/style.css">
      <script src="../js/script.js"></script>
   </head>

   <body onload="loadCookies()"> 
      <div class="background">
         <div class="w3-main w3-container w3-content w3-padding-32 w3-animate-bottom" style="max-width:1400px;">
            <div class="w3-row">
               <div class="w3-half w3-container w3-padding-64 w3-start" style="margin-top:150px;">
                  <h2>Looking for tutor suit with your learning style and progress?</h2>
                  <p class="textp">MY Tutor provide you the best tutors from different backgrounds of expertise to help you learn better. Get started with us for a better future!</p>
                  <a class="btnLoginReg w3-button w3-red w3-hover-white w3-large" href = "register.php">Get started!</a>
                  <br>
               </div>
               <div class="backdev w3-half w3-container w3-card w3-padding-64">
                  <img style="display: block; margin-left: auto; margin-right: auto; width: 50%;" src="../images/logo.png">   
                  <h4 class="welcome">Welcome back!</h4>
                  <p class="textp w3-center">We make it easy for you to search for the best tutors.</p>
                  <form name="loginForm" action="login.php" method="post">
                     <p>
                        <label class="w3-text-white"><b><i class="fa-solid fa-envelope"></i> | Email</b></label>
                        <input class="w3-input w3-border w3-round" name="email" type="email" id="emailid" placeholder="eg. taylor@gmail.com" required>
                     </p><br>
                     <p>
                        <label class="w3-text-white"><b><i class="fa-solid fa-lock"></i> | Password</b></label>
                        <input input class="w3-input w3-border w3-round" name="password" type="password" id="passid" placeholder="eg. abcde12&" required>
                     </p><br>
                     <p class="btnRemember">
                        <input class="w3-check" type="checkbox" id="rememberid" name="remember" onclick="rememberMe()">
                        <label>Remember me</label>
                     </p><br>
                     <p>
                        <button class="btnLoginReg w3-hover-white w3-large w3-block" name="submit" value="login">Login</button>
                     </p>
                  </form>
                  <hr>
                  <p class="w3-center w3-text-white">Dont have an account yet? 
                     <b><a class="w3-text-red" style="text-decoration:none;" href="register.php"> Register now</a></b>
                  </p>
               </div>
            </div>
         </div>
      </div>
      <div id="cookieNotice" class="smalltext w3-container w3-block">
         <div class="w3-black">
            <h4 >Cookie Consent</h4>
            <p>This website uses cookies or similar technologies, to enhance your browsing experience and to provide personalizations.
               By continuing to use our website, you agree to <a class="w3-text-red">Privacy Policy <button class="w3-button w3-red" onclick="acceptCookieConsent()">Accept cookies</button></a>
            </p>
         </div>
      </div>

      <footer class="smalltext">
        <p>Copyright &copy;2022 MY Tutor | Get serious, get tutor | Your use of this website constitutes acceptance of the Terms of Use, Privacy Policy and Cookie Policy. Do Not Sell My Personal Information </p>
      </footer>
   </body>
   
   <script>
      let cookie_consent = getCookie("user_cookie_consent");
      if(cookie_consent != ""){
         document.getElementById(cookieNotice).style.display = "none";
      }else{
         document.getElementById(cookieNotice).style.display = "block";
      }
   </script>
</html>