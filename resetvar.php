<?php
    include 'conn/config.php';
    $check = $conn->prepare("UPDATE users SET userWashMachine = 0, userWashMachine1 = 0, userDay = 0, userP = 0, userDay1 = 0, userP1 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d1 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d2 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d3 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d4 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d5 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d6 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    $check = $conn->prepare("UPDATE d7 SET p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0, p9 = 0");
    $check->execute();
    header("location:index");
?>