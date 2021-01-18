<?php
    include 'conn/config.php';
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
    {
        header('location: index');
        exit;
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
            else 
            {
                $_SESSION['logged_in'] = true;
                $_SESSION['userEmail'] = $row['userEmail'];
                $_SESSION['firse_name'] = $row['userFirstName'];
                $_SESSION['last_name'] = $row['userLastName'];
                $_SESSION['status'] = $row['userStatus'];
                $_SESSION['room'] = $row['userRoom'];
                $_SESSION['admin'] = $row['userAdmin'];
                $_SESSION['masina'] = $row['userWashMachine'];
                header('location: index');
                exit;   
            }
        }
        else
        {
            $mesaju = 'Datele introduse de tine sunt gresite.';
            header('location: index');
        }
    }
?>