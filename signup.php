<?php 
  include 'conn/config.php';

    if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['nume']) && isset($_POST['prenume']) && isset($_POST['camera']) && isset($_POST['tel']))
    {
        $email = htmlentities($_POST['email']);
        $password = MD5(htmlentities($_POST['pass']));
        $nume = htmlentities($_POST['nume']);
        $prenume = htmlentities($_POST['prenume']);
        $camera = htmlentities($_POST['camera']);
        $tel = htmlentities($_POST['tel']);
        $checkmail = $conn->prepare("SELECT * FROM users WHERE userEmail = '$email'");
        $checkmail->execute();
        $countlogmail = $checkmail->rowCount();
        if($countlogmail >= 1)
        {
            $mesaju = 'Exista deja un utilizator cu acest mail.';
        }
        else 
        {
            $check = $conn->prepare("INSERT INTO users (userFirstName, userLastName, userEmail, userPassword, userRoom, userPhone) VALUES ('$nume', '$prenume', '$email', '$password', '$camera', '$tel')");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog >= 1)
            {
                $mesaju = 'Contul tau a fost inregistrat. Urmeaza ca un administrator sa il activeze.';
            }
            else
            {
                $mesaju = 'O eroare a aparut la inregistrare. Incearca mai tarziu.';
            }   
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spalatorie C16</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
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
<!--===============================================================================================-->
</head>
<body>
    
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
	<script language="JavaScript" src="js/main.js"></script>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="signup" method="post">
					<span class="login100-form-title p-b-33">
						Inregistrare
					</span>
                    
                    <?php if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['nume']) && isset($_POST['prenume']) && isset($_POST['camera']) && isset($_POST['tel'])) echo $mesaju; ?>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Este necesara o adresa de mail valida: ex@e-uvt.ro">
						<input class="input100" type="text" name="email" id="email" placeholder="Email(@e-uvt.ro)">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Acest camp este obligatoriu">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Parola">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Acest camp este obligatoriu">
						<input class="input100" type="text" name="nume" id="nume" placeholder="Nume">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Acest camp este obligatoriu">
						<input class="input100" type="text" name="prenume" id="prenume" placeholder="Prenume">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Acest camp este obligatoriu">
						<input class="input100" type="text" name="camera" id="camera" placeholder="Camera">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Este necesar un numar de telefon valid">
						<input class="input100" type="text" name="tel" id="tel" placeholder="Numar de telefon">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn">
							Inregistreaza-te
						</button>
					</div>

					
				</form><br>
                <center><a href = "index">&larr; inapoi la login</a></center>
			</div>
		</div>
	</div>

</body>
</html>