<?php 
  include 'conn/config.php';
    date_default_timezone_set('Europe/Bucharest');
    setlocale(LC_ALL, 'ro_RO');
$programe[0]['i'] = "null";
    $programe[0]['o'] = "null";
    $programe[1]['i'] = "08:00";
    $programe[1]['o'] = "09:30";
    $programe[2]['i'] = "09:40";
    $programe[2]['o'] = "11:10";
    $programe[3]['i'] = "11:20";
    $programe[3]['o'] = "12:50";
    $programe[4]['i'] = "13:00";
    $programe[4]['o'] = "14:30";
    $programe[5]['i'] = "14:40";
    $programe[5]['o'] = "16:10";
    $programe[6]['i'] = "16:20";
    $programe[6]['o'] = "17:50";
    $programe[7]['i'] = "18:00";
    $programe[7]['o'] = "19:30";
    $programe[8]['i'] = "19:40";
    $programe[8]['o'] = "21:10";
    $programe[9]['i'] = "21:20";
    $programe[9]['o'] = "22:50";
    require('calendar.php');
// get the year and number of week from the query string and sanitize it
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$week = filter_input(INPUT_GET, 'week', FILTER_VALIDATE_INT);

// initialize the calendar object
$calendar = new calendar();

// get the current week object by year and number of week
$currentWeek = $calendar->week($year, $week);

// get the first and last day of the week
$firstDay = $currentWeek->firstDay();
$lastDay  = $currentWeek->lastDay();

// get the previous and next week for pagination
$prevWeek = $currentWeek->prev();
$nextWeek = $currentWeek->next();

// generate the URLs for pagination
$prevWeekURL = sprintf('?year=%s&week=%s', $prevWeek->year()->int(), $prevWeek->int());
$nextWeekURL = sprintf('?year=%s&week=%s', $nextWeek->year()->int(), $nextWeek->int());
    $zilele[] = $currentWeek->daysv();
    $ora123 = date("H:i");
    $ziuamea = date("d");
    if(isset($_GET['day']) && isset($_GET['p']) && isset($_GET['m'])) {
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
                $_SESSION['mesaj_erroare'] = 'Ceva nu a mers bine! Vei fi redirectionat inapoi in 3 secunde.';
                header("location:index");
                exit;
            }
            if(!ctype_digit($_GET['day']) || !ctype_digit($_GET['p']) || !ctype_digit($_GET['m'])) {
                $_SESSION['mesaj_erroare'] = 'Ceva nu a mers bine! Vei fi redirectionat inapoi in 3 secunde.';
                header("location:index");
                exit;
            }
            if($_GET['day'] <= 0 || $_GET['day'] > 7 || $_GET['p'] <= 0 || $_GET['p'] > 9 || $_GET['m'] <= 0 || $_GET['m'] > 5) {
                $_SESSION['mesaj_erroare'] = 'Ceva nu a mers bine! Vei fi redirectionat inapoi in 3 secunde.';
                header("location:index");
                exit;
            }
            $ziua = 'd' . $_GET['day'];
            $programu = 'p' . $_GET['p'];
            $masina = $_GET['m'];
            $id = $_SESSION['userID'];
            $check = $conn->prepare("SELECT * FROM $ziua WHERE id = '$masina'");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog >= 1)
            {
                $rowa = $check->fetch();
                if($rowa[$programu] > 0 && $rowa[$programu] != $id) {
                    $_SESSION['mesaj_erroare'] = 'Ceva nu a mers bine! Vei fi redirectionat inapoi in 3 secunde.';
                    header("location:index");
                    exit;
                }
            }
            else {
                $_SESSION['mesaj_erroare'] = 'Ceva nu a mers bine! Vei fi redirectionat inapoi in 3 secunde.';
                header("location:index");
                exit;
            }
            if(($_SESSION['masina'] == $masina && $_SESSION['userDay'] == $ziua && $_SESSION['userP'] == $programu) || ($_SESSION['masina1'] == $masina && $_SESSION['userDay1'] == $ziua && $_SESSION['userP1'] == $programu)) {
                $j = $_GET['day'];
                if($ziuamea > $currentWeek->daysv()[$j-1]->int())
                {
                    $_SESSION['mesaj_erroare'] = 'Nu poti anula rezervarea din acea zi!';
                    header("location:index");
                    exit;
                }
                elseif($ziuamea == $currentWeek->daysv()[$j-1]->int()) {
                    if(substr($ora123, 0, 2) > substr($programe[$_GET['p']]['i'],0,2) || (substr($ora123, 0, 2) == substr($programe[$_GET['p']]['i'],0,2) && substr($ora123, -2, 2) >= (substr($programe[$_GET['p']]['i'], -2, 2) + 5))) {
                        $_SESSION['mesaj_erroare'] = 'Nu poti anula rezervarea din acea zi!';
                        header("location:index");
                        exit;
                    }
                }
                if($_SESSION['masina'] == $masina && $_SESSION['userDay'] == $ziua && $_SESSION['userP'] == $programu) {
                    $check = $conn->prepare("UPDATE `$ziua` SET `$programu` = '0' WHERE id = '$masina'");
                    $check->execute();
                    $check = $conn->prepare("UPDATE users SET userWashMachine = '0', userDay = NULL, userP = NULL WHERE userID = '$id'");
                    $check->execute();
                    $_SESSION['masina'] = 0;
                    $_SESSION['userDay'] = NULL;
                    $_SESSION['userP'] = NULL;
                    $_SESSION['mesaj_erroare'] = 'Ai anulat rezervarea cu succes! Vei fi redirectionat in 3 secunde inapoi.';
                    $legat = $ziua . $programu;
                    $_SESSION[$legat]++;
                    header("location:index");
                    exit;
                }
                elseif($_SESSION['masina1'] == $masina && $_SESSION['userDay1'] == $ziua && $_SESSION['userP1'] == $programu) {
                    $check = $conn->prepare("UPDATE `$ziua` SET `$programu` = '0' WHERE id = '$masina'");
                    $check->execute();
                    $check = $conn->prepare("UPDATE users SET userWashMachine1 = '0', userDay1 = NULL, userP1 = NULL WHERE userID = '$id'");
                    $check->execute();
                    $_SESSION['masina1'] = 0;
                    $_SESSION['userDay1'] = NULL;
                    $_SESSION['userP1'] = NULL;
                    $_SESSION['mesaj_erroare'] = 'Ai anulat rezervarea cu succes! Vei fi redirectionat in 3 secunde inapoi.';
                    $legat = $ziua . $programu;
                    $_SESSION[$legat]++;
                    header("location:index");
                    exit;
                }
            }
            elseif($_SESSION['masina'] == 0 || $_SESSION['masina1'] == 0) {
                $j = $_GET['day'];
                if($ziuamea > $currentWeek->daysv()[$j-1]->int())
                {
                    $_SESSION['mesaj_erroare'] = 'Nu poti face o rezervare in acea zi!';
                    header("location:index");
                    exit;
                }
                elseif($ziuamea == $currentWeek->daysv()[$j-1]->int()) {
                    if(substr($ora123, 0, 2) > substr($programe[$_GET['p']]['i'],0,2) || (substr($ora123, 0, 2) == substr($programe[$_GET['p']]['i'],0,2) && substr($ora123, -2, 2) >= (substr($programe[$_GET['p']]['i'], -2, 2) + 5))) {
                        $_SESSION['mesaj_erroare'] = 'Nu poti face o rezervare in acea zi!';
                        header("location:index");
                        exit;
                    }
                }
                if($_SESSION['masina'] == 0) {
                    $check = $conn->prepare("UPDATE `$ziua` SET `$programu` = '$id' WHERE id = '$masina'");
                    $check->execute();
                    $check = $conn->prepare("UPDATE users SET userWashMachine = '$masina', userDay = '$ziua', userP = '$programu' WHERE userID = '$id'");
                    $check->execute();
                    $_SESSION['masina'] = $masina;
                    $_SESSION['userDay'] = $ziua;
                    $_SESSION['userP'] = $programu;
                    $_SESSION['mesaj_erroare'] = 'Ai rezervat cu succes masina ' . $masina . '! Vei fi redirectionat in 3 secunde inapoi.';
                    $legat = $ziua . $programu;
                    $_SESSION[$legat]--;
                    header("location:index");
                    exit;
                }
                elseif($_SESSION['masina1'] == 0) {
                    $check = $conn->prepare("UPDATE `$ziua` SET `$programu` = '$id' WHERE id = '$masina'");
                    $check->execute();
                    $check = $conn->prepare("UPDATE users SET userWashMachine1 = '$masina', userDay1 = '$ziua', userP1 = '$programu' WHERE userID = '$id'");
                    $check->execute();
                    $_SESSION['masina1'] = $masina;
                    $_SESSION['userDay1'] = $ziua;
                    $_SESSION['userP1'] = $programu;
                    $_SESSION['mesaj_erroare'] = 'Ai rezervat cu succes masina ' . $masina . '! Vei fi redirectionat in 3 secunde inapoi.';
                    $legat = $ziua . $programu;
                    $_SESSION[$legat]--;
                    header("location:index");
                    exit;
                }
            }
            else {
                $_SESSION['mesaj_erroare'] = 'Ai facut deja 2 rezervari saptamana aceasta (apare cu rosu/galben daca vrei sa le anulezi).';
                header("location:index");
                exit;
            }
    }
    if(isset($_POST['email']) && isset($_POST['pass']))
    {
        $username = htmlentities($_POST['email']);
        $password = MD5(htmlentities($_POST['pass']));
        $check = $conn->prepare("SELECT * FROM users WHERE userEmail = '$username' and userPassword = '$password'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog >= 1)
        {
            $row = $check->fetch();
            $status = $row['userStatus'];
            if($status == 0) 
            {
                $mesaju = 'Contul tau nu este activat inca.';   
            }
            else if($status == 2) {
                $mesaju = 'Contul tau a fost blocat.';
            }
            else 
            {
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['logged_in'] = true;
                $_SESSION['userEmail'] = $row['userEmail'];
                $_SESSION['firse_name'] = $row['userFirstName'];
                $_SESSION['last_name'] = $row['userLastName'];
                $_SESSION['status'] = $row['userStatus'];
                $_SESSION['room'] = $row['userRoom'];
                $_SESSION['admin'] = $row['userAdmin'];
                $_SESSION['masina'] = $row['userWashMachine'];
                $_SESSION['userDay'] = $row['userDay'];
                $_SESSION['userP'] = $row['userP'];
                $_SESSION['masina1'] = $row['userWashMachine1'];
                $_SESSION['userDay1'] = $row['userDay1'];
                $_SESSION['userP1'] = $row['userP1'];
                $check = $conn->prepare("SELECT * FROM d1 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d1 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d1p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d2 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d2p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d3 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d3p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d4 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d4p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d5 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d5p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d6 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d6p9'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p1 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p1'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p2 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p2'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p3 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p3'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p4 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p4'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p5 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p5'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p6 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p6'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p7 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p7'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p8 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p8'] = $check->rowCount();
                $check = $conn->prepare("SELECT * FROM d7 WHERE p9 = '0' AND status = 1");
                $check->execute();
                $_SESSION['d7p9'] = $check->rowCount();
                header('location: index');
                exit;   
            }
        }
        else
        {
            $mesaju = 'Datele introduse de tine sunt gresite.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spalatorie C16</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="shortcut icon" href="favicon.ico" /> 
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
<!--===============================================================================================-->
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
</head>
<body>
    <?php
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    ?>
    <center>
    <?php
        if(isset($_SESSION['mesaj_erroare'])) {
            echo $_SESSION['mesaj_erroare'];
            echo '<br>';
            unset($_SESSION['mesaj_erroare']);
            header("refresh:3;url=index");
        }
        $mesaj_log = 'Welcome, ' . $_SESSION['last_name'] . ' ' . $_SESSION['firse_name'] . ' (' . $_SESSION['room'] . ')!';
        echo $mesaj_log;
    ?>
    
        <br><?php if($_SESSION['admin'] > 0): ?> <button type="button"> <a href="admin">Administrare</a></button> <?php endif; ?><button type="button"> <a href="logout.php">Log out!</a></button>
        
    </center>
    
    <br><br>
    
    <?php
        include 'week.php';
    ?>
    

    
    <?php else: ?>
        
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="index" method="post">
					<span class="login100-form-title p-b-33">
						Conectare
					</span>
                    
                    <?php if(isset($_POST['email']) && isset($_POST['pass'])) echo $mesaju; ?>

					<div class="wrap-input100 validate-input" data-validate = "Introdu un mail valid">
						<input class="input100" type="text" name="email" id="email" placeholder="Email (@e-uvt.ro)">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Acest camp este obligatoriu">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Parola">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn">
							Conecteaza-te
						</button>
					</div>

					<div class="text-center">
						<span class="txt1">
							Nu ai cont?
						</span>

						<a href="signup" class="txt2 hov1">
							Inregistreaza-te
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
    
    <?php endif; ?>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    
    

</body>
</html>