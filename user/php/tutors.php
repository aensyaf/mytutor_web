<?php
    error_reporting(0);
    session_start();
    if(!isset($_SESSION['sessionid'])){
        echo "<script>alert('Session not available. Please login again');</script>";
        echo "<script> window.location.replace('../php/login.php')</script>";
    }
    include_once("dbconnect.php");

    if(isset($_GET['submit'])){
        $operation = $_GET['submit'];
        if($operation == 'search'){
            $search = $_GET['search'];
            $option = $_GET['option'];
            if($option == 'tutname'){
                $sqltutors = "SELECT * FROM tbl_tutors WHERE tutor_name LIKE '%$search%'";
            }else{
                $sqltutors = "SELECT * FROM tbl_tutors WHERE tutor_id = '$search'";
            }
        }
    }

    $results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    } else {
        $pageno = 1;
        $page_first_result = 0;
    }

    if(!isset($sqltutors)){
        $sqltutors = "SELECT * FROM tbl_tutors";
    }
    
    $stmt = $conn->prepare($sqltutors);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    $sqltutors = $sqltutors . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqltutors);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    $conn= null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tutors</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mr Dafoe">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/styletutor.css">
    </head>
    
    <body>
        <div class="w3-top">
            <div class="w3-bar w3-card w3-black" id="myNavbar">
                <img href="#home" class="w3-bar-item w3-button w3-left w3-hover-black" src="../images/logohome.png">
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

        <header class="resimg-tut">
            <div class="w3-main w3-content" style="display: flex; justify-content: center; margin-bottom:16px; padding-top:128px">
                <h1 class="header-text-tut">TUTORS
                    <hr class="header-line-tut">
                    <p class="header-text2-tut">Looking for tutors suits with your study style? Explore available tutors here...</p>
                </h1>
            </div>

            <div class="w3-card-4 w3-white w3-container w3-padding w3-margin w3-round-large" style="margin-bottom:64px">
            <form>
                <div class="w3-row">
                    <div class="w3-half" style="padding-right:5px">
                        <p><input class="w3-input w3-block w3-round-large w3-border" type="search" name="search" placeholder = "Search tutor here..">
                        </p>
                    </div>
                    <div class="w3-half">
                        <p>
                            <select class="w3-input w3-block w3-round-large w3-border" name="option">
                                <option value="tutname">By Tutor Name</option>
                                <option value="tutid">By Tutor ID</option>
                            </select>
                        </p>
                    </div>
                </div>
                <button class="w3-button w3-right w3-black w3-round-large w3-hover-red" style="width:100%;transition: .4s;" type="submit" name="submit" value="search"><i class="fa-solid fa-search"></i>   Search</button></div>
            </form>
        </div>
        <br>
        </header>
        <br>
        <div class="w3-margin w3-grid-template-tut">
            <a href="#home" class="float"><i class="fa fa-arrow-up my-float"></i></a>
            <?php
                $i = 0;
                foreach ($rows as $tutors) {
                    $i++;
                    $tutid = $tutors['tutor_id'];
                    $tutemail = $tutors['tutor_email'];
                    $tutphone = $tutors['tutor_phone'];
                    $tutname = $tutors['tutor_name'];
                    $tutdesc = $tutors['tutor_description'];
                    $tutdate = $tutors['tutor_datereg'];
                    echo "<div class='w3-black w3-card-4 w3-round' style='margin:8px; border-radius: 10px;  box-shadow: 0px 4px 20px 8px rgba(0, 0, 0, 0.25)'>";
                    echo "<div style='background: white;border-radius: 10px'><a href='' style='text-decoration: none;'>
                            <img class='w3-image' src=../images/tutors/$tutid.jpg" . " onerror=this.onerror=null;this.src='../images/errorimg.png'" . " style='width:100%;height:250px; border-radius: 10px 10px 0px 0px;'></a>
                            <br>
                        </div>";
                    echo "<div class='w3-container w3-margin w3-padding w3-border' >
                    <p style='font-family: Montserrat; font-weight: bold;'>$tutname</p>
                    <p style='font-family: Montserrat; font-size:12px'><i class='fa fa-envelope'></i> | $tutemail</p>
                    <p style='font-family: Montserrat; font-size:12px'><i class='fa-solid fa-phone'></i> | $tutphone</p>
                    <p style='font-family: Montserrat; font-size:12px; text-align:justify'>$tutdesc</p><br></div>
                    </div>";
                }
            ?>
        </div>
        <br>
        <?php
            $num = 1;
            if ($pageno == 1) {
                $num = 1;
            } else if ($pageno == 2) {
                $num = ($num) + 10;
            } else {
                $num = $pageno * 10 - 9;
            }
            echo "<div class='w3-container w3-row'>";
            echo "<center>";
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "tutors.php?pageno=' . $page . '" style="text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
        ?>
        <br>

        <footer class="footer-tut w3-center">
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