<?php
    include_once("dbconnect.php");
    if(isset($_GET['subid'])){
        $subid = $_GET['subid'];
        $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_id = '$subid'";
        $stmt = $conn->prepare($sqlcourses);
        $stmt->execute();
        $number_of_result = $stmt->rowCount();

        if($number_of_result>0){
            $stmt->execute();$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
        }else{
            echo "<script>alert('Product not found :(');</script>";
            echo "<script> window.location.replace('../php/courses.php')</script>";
        }
    }else{
        echo "<script>alert('PAGE ERROR');</script>";
            echo "<script> window.location.replace('../php/courses.php')</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MYTutor</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mr Dafoe">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/stylecourse.css">
    </head>

    <body class="w3-black">
        <div class="w3-top">
            <div class="w3-bar w3-card w3-black" id="myNavbar">
            <img class="w3-bar-item w3-button w3-left w3-hover-black" src="../images/logohome.png">
                <div class="w3-right w3-hide-small">
                <a href="courses.php" class="w3-bar-item w3-button w3-round-xlarge w3-hover-red" style="margin-right:5px; font-size: 12px"><i class="fa fa-graduation-cap"></i> Courses</a>
                <a href="tutors.php" class="w3-bar-item w3-button w3-round-xlarge w3-hover-red" style="margin-right:5px; font-size: 12px"><i class="fa-solid fa-person-chalkboard"></i> Tutors</a>
                <a href="#subs" class="w3-bar-item w3-button w3-round-xlarge w3-hover-red" style="margin-right:5px; font-size: 12px"><i class="fa-solid fa-list"></i> Subscription</a>
                <a href="#profile" class="w3-bar-item w3-button w3-round-xlarge w3-hover-red" style="margin-right:5px; font-size: 12px"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="login.php" class="w3-bar-item w3-button w3-round-xlarge w3-hover-red" style="margin-right:5px; font-size: 12px"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                </div>

                <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
                <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>

        <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
            <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">CLOSE ×</a><hr>
            <a href="courses.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-graduation-cap"></i> Courses</a><hr>
            <a href="tutors.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa-solid fa-person-chalkboard"></i> Tutors</a><hr>
            <a href="#subs" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa-solid fa-list"></i> Subscription</a><hr>
            <a href="#profile" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa-solid fa-user"></i> Profile</a><hr>
            <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a><hr>
        </nav><br>

        <header>
            <div style="font-size:12px;text-align: center;padding-top:50px;">
                <a class="w3-hover-red w3-button w3-round-large" style="transition: .4s;" href="courses.php"><i class="fa-solid fa-home"></i> RETURN HOME</a>
            </div>
            <h1 class="header-det w3-container">COURSE DETAILS</h1>
            <hr class="header-line" style="width:10%;">
        </header><br>

        <?php
            foreach ($rows as $courses) {
                $subid = $courses['subject_id'];
                $subname = $courses['subject_name'];
                $subdesc = $courses['subject_description'];
                $subprice = number_format((float)$courses['subject_price'], 2, '.', '');
                $subtutid = $courses['tutor_id'];
                $subsession = $courses['subject_sessions'];
                $subrate = number_format((float)$courses['subject_rating'], 2, '.', '');
            }
            echo "
                <div class='w3-container w3-content w3-padding-32 w3-animate-bottom' style='max-width:900px;'>
                    <div style='text-align: center;'>
                        <img src=../images/courses/$subid.png" . " onerror=this.onerror=null; this.src='../images/errorimg.png'" . " style='width: 50%; height: 50%;'>
                    </div>
                    <div class='box-details' style='padding:32px;margin-top:20px; margin-bottom:20px'>
                        <p>
                            <label class='w3-text-white'><b>COURSE NAME</b></label>
                            <p class='w3-container w3-white'>$subname</p>
                        </p>
                        <p>
                        <label class='w3-text-white'><b>ABOUT</b></label>
                            <p class='w3-container w3-white'>$subdesc</p>
                            </p>
                        <p>
                            <div class='w3-row'>
                                <div class='w3-half' style='padding-right:15px'>
                                    <label class='w3-text-white'><b>PRICE</b></label>
                                    <p class='w3-container w3-white'>RM $subprice</p>
                                </div>

                                <div class='w3-half'>
                                    <label class='w3-text-white'><b>SESSION</b></label>
                                    <p class='w3-container w3-white'>$subsession</p>
                                </div>
                            </div>
                        </p>
                    </div>
                    <div class='box-details' style='text-align: center;margin-bottom:20px'>
                        <p style='letter-spacing: 0.4em;font-size: 30px;'><b>RATING</b></p>
                        <p style='letter-spacing: 0.4em; font-size: 55px; color:red'><b>$subrate</b></p>
                    </div>
                    <div class='box-details' style='text-align: center;'>
                        <p style='letter-spacing: 0.4em;font-size: 30px;'><b>OUR TUTOR</b></p>
                        <img class='w3-padding-32' src=../images/tutors/$subtutid.jpg" . " onerror=this.onerror=null; this.src='../images/errorimg.png'" . " style='width: 30%; height: 30%;'>
                    </div>
                </div>
            ";
        ?>
        <br>
        <footer class="footer w3-center">
            <p>Copyright &copy;2022 MY Tutor | Get serious, get tutor | Your use of this website constitutes acceptance of the Terms of Use, Privacy Policy and Cookie Policy. Do Not Sell My Personal Information </p>
        </footer>

        <script>
            var mySidebar = document.getElementById("mySidebar");
            function w3_open() {
                if (mySidebar.style.display === 'block') {
                    mySidebar.style.display = 'none';
                } else {
                    mySidebar.style.display = 'block';
                }
            }
            function w3_close() {
                mySidebar.style.display = "none";
            }
        </script>
    </body>
    
</html>