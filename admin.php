<?php
    include 'conn/config.php';
    require('assets/snippets/header.php'); 
    if(!isset($_SESSION['logged_in']) || $_SESSION['admin'] <= 0) {
        header('location: index');
        exit;
    }
    if(isset($_GET['id']) && isset($_GET['action'])) {
        $id_query = $_GET['id'];
        $actiunea = $_GET['action'];
        
        //actiunea 1 - acceptare, actiunea 2 - stergere, actiune 3 - blocare, actiune 4 - deblocare, 5 - defect masina, 6 - reparat masina
        if($actiunea == 1) {
            $check = $conn->prepare("UPDATE users SET userStatus = '1' WHERE userID = '$id_query'");
            $check->execute();
        }
        elseif($actiunea == 2) {
            $check = $conn->prepare("DELETE FROM users WHERE userID = '$id_query'");
            $check->execute();
        }
        elseif($actiunea == 3) {
            $check = $conn->prepare("UPDATE users SET userStatus = '2' WHERE userID = '$id_query'");
            $check->execute();
        }
        elseif($actiunea == 4) {
            $check = $conn->prepare("UPDATE users SET userStatus = '1' WHERE userID = '$id_query'");
            $check->execute();
        }
        elseif($actiunea == 5) {
            $check = $conn->prepare("UPDATE d1 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d2 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d3 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d4 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d5 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d6 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d7 SET status = '0' WHERE id = '$id_query'");
            $check->execute();
        }
        elseif($actiunea == 6) { 
            $check = $conn->prepare("UPDATE d1 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d2 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d3 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d4 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d5 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d6 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
            $check = $conn->prepare("UPDATE d7 SET status = '1' WHERE id = '$id_query'");
            $check->execute();
        }
        header('location:admin');
    }
?>
<hmtl>
<head>
    <title>Administrare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--===============================================================================================-->	
    <link rel="shortcut icon" href="favicon.ico" /> 
<!--===============================================================================================-->
</head>
<body>
    <a href = "index">&larr; inapoi</a>
        <br><br>
    <?php
        $check = $conn->prepare("SELECT * FROM users WHERE userStatus = 0");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog >= 1)
        {
            $row = $check->fetch();
            while($row != NULL) {
                $array[] = $row;
                $row = $check->fetch();
            }
        }
    ?>
        
        <?php
        
            if(isset($array)):
        ?>
        
        
        &rarr; Administare cereri
    <section class="week">
    <table>
        <thead>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Email</th>
            <th>Camera</th>
            <th>Actiune</th>
        </thead>
        <tbody>
            <?php foreach($array as $a): ?>
                <tr>
                    <td><?=$a['userFirstName']?></td>
                    <td><?=$a['userLastName']?></td>
                    <td><?=$a['userEmail']?></td>
                    <td><?=$a['userRoom']?></td>
                    <td>
                        <a href="admin.php?id=<?=$a['userID']?>&action=1">Acceptare</a>/<a href="admin.php?id=<?=$a['userID']?>&action=2">Stergere</a>
                    </td>
                </tr>
            <?php endforeach; ?>                                                                                        
        </tbody>

    </table>
    </section>
        
        <?php
        
            endif;
        ?>
    
    <br><br>
    
    &rarr; Administrare chiriasi
    <?php
        $mailuthau = $_SESSION['userEmail'];
        $check = $conn->prepare("SELECT * FROM users WHERE userEmail != '$mailuthau' AND userStatus >= 1");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog >= 1)
        {
            $row = $check->fetch();
            while($row != NULL) {
                $array1[] = $row;
                $row = $check->fetch();
            }
        }
    ?>
        
        <?php 
            if(isset($array1)):
        ?>
    <section class="week">
    <table>
        <thead>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Email</th>
            <th>Camera</th>
            <th>Actiune</th>
        </thead>
        <tbody>
            <?php foreach($array1 as $a): ?>
                <tr>
                    <td><?=$a['userFirstName']?></td>
                    <td><?=$a['userLastName']?></td>
                    <td><?=$a['userEmail']?></td>
                    <td><?=$a['userRoom']?></td>
                    <td>
                        <?php 
                            if($a['userStatus'] == 2) {
                                echo '<a href="admin.php?id='. $a['userID'] . '&action=4'. '">Deblocare</a>/<a href="admin.php?id='. $a['userID'] . '&action=2'. '">Stergere</a>';
                            }
                            else {
                                echo '<a href="admin.php?id='. $a['userID'] . '&action=3'. '">Blocare</a>/<a href="admin.php?id='. $a['userID'] . '&action=2'. '">Stergere</a>';
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    </section>
        <?php
            else:
        ?>
        
        <?php
            echo '<br>Nu avem chiriasi cu conturi la spalatorie. :(';
        ?>
        
        <?php
            endif;
        ?>
    <br><br>
    &rarr; Administrare masini
    <br>
    <a href = "resetvar.php"> &rarr; Resetare manuala! </a>
    <?php
        $check = $conn->prepare("SELECT * FROM d1");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog >= 1)
        {
            $row = $check->fetch();
            while($row != NULL) {
                $masini[] = $row;
                $row = $check->fetch();
            }
        }
    ?>
    <section class="week">
    <table>
        <thead>
            <th>Masina</th>
            <th>Status</th>
            <th>Optiuni</th>
        </thead>
        <tbody>
            <?php foreach($masini as $a): ?>
                <tr>
                    <td><?=$a['id']?></td>
                    <td><?php if($a['status'] == 1) echo '<font color="green">Functionala</font>'; else echo '<font color="red">Defecta</font>'; ?></td>
                    <td><?php if($a['status'] == 1) echo '<a href="admin.php?id=' . $a['id'] . '&action=5"><font color="red">S-a defectat!</font></a>'; else echo '<a href="admin.php?id=' . $a['id'] . '&action=6"><font color="green">A fost reparata!</font></a>'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    </section>
        
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
</hmtl>