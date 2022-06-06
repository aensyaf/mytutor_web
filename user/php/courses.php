<?php
    session_start();
    if(!isset($_SESSION['sessionid'])){
        echo "<script>alert('Session not available. Please login again');</script>";
        echo "<script> window.location.replace('../php/login.php')</script>";
    }
    include_once("dbconnect.php");
    $sqlcourse = "SELECT * FROM tbl_subjects";

    $results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    } else {
        $pageno = 1;
        $page_first_result = 0;
    }
    
    $stmt = $conn->prepare($sqlcourse);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    $sqlcourse = $sqlcourse . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqlcourse);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    function truncate($string, $length, $dots = "...") {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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
        <link rel="stylesheet" type="text/css" href="../css/stylecoursetut.css">
    </head>

    <body>
        <div class="w3-top">
            <div class="w3-bar w3-white w3-card w3-padding" id="myNavbar">
                <a href="courses.php" class="w3-bar-item w3-button w3-wide" style="font-family: Mr Dafoe; font-size:20px; font-weight:bold;">MY Tutor</a>
                
                <div class="w3-right w3-hide-small">
                <a href="courses.php" class="w3-bar-item w3-button w3-black w3-round-xlarge" style="margin-right:5px;"><i class="fa fa-graduation-cap"></i> Courses</a>
                <a href="tutors.php" class="w3-bar-item w3-button w3-black w3-round-xlarge" style="margin-right:5px;"><i class="fa-solid fa-person-chalkboard"></i> Tutors</a>
                <a href="#subs" class="w3-bar-item w3-button w3-black w3-round-xlarge" style="margin-right:5px;"><i class="fa-solid fa-list"></i> Subscription</a>
                <a href="#profile" class="w3-bar-item w3-button w3-black w3-round-xlarge" style="margin-right:5px;"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="login.php" class="w3-bar-item w3-button w3-black w3-round-xlarge" style="margin-right:5px;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
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
        </nav>

        <header class="background">
            <div class="w3-main w3-content w3-padding-32 w3-animate-bottom"><h1 class="header-text">COURSES<hr class='line'></h1>
            </div>
        </header>
        <br>
        <div class="w3-margin w3-grid-template">
            <?php
                $i = 0;
                foreach ($rows as $courses) {
                    $i++;
                    $subid = $courses['subject_id'];
                    $subname = truncate($courses['subject_name'],50);
                    $subdesc = $courses['subject_description'];
                    $subprice = number_format((float)$courses['subject_price'], 2, '.', ''); // $products['product_price'];
                    $subtutid = $courses['tutor_id'];
                    $subsession = $courses['subject_sessions'];
                    $subrate = number_format((float)$courses['subject_rating'], 2, '.', '');
                    echo "<div class='w3-card-4 w3-round' style='margin:8px; border-radius: 10px;  box-shadow: 0px 4px 20px 8px rgba(0, 0, 0, 0.25)'>";
                    echo "<div style='background: white;border-radius: 10px'><a href='' style='text-decoration: none;'>
                            <img class='w3-image' src=../images/courses/$subid.png" . " onerror=this.onerror=null;this.src='../images/errorimg.png'" . " style='width:100%;height:250px; border-radius: 10px 10px 0px 0px;'></a>
                            <hr class='w3-black'>
                            <div class='w3-row'>
                                <div class='w3-twothird'>
                                    <h1 class='w3-col' style='font-family: Montserrat;font-style: normal;font-weight: bold;font-size: 15px; text-align:left;padding:15px;'>$subname</h1>
                                </div>
                                <div class='w3-third w3-black w3-border'>
                                    <h2 style='font-family: Montserrat;font-style: normal;font-weight: bold;font-size: 20px;text-align: center;height: 15px;margin-top:8px;color: red;'>$subrate</h2>
                                    <p class='w3-center'>RATINGS</p>
                                </div>
                            </div>
                            <p class='w3-margin' style='font-family: Montserrat; font-weight: regular; text-align: justify;'>$subdesc</p>
                        </div>";
                    echo "<div class='w3-container'><p>Price: RM $subprice<br>Session: $subtutid<br><div class='w3-button w3-red w3-round w3-block' style='' onClick=''>Add to Subscription</div></p></div>
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
                echo '<a href = "courses.php?pageno=' . $page . '" style="text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
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