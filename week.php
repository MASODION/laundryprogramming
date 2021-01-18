<?php

    $numar_programe=9;
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
    
    $ora123 = date("H:i");
    $ziuamea = date("d");
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { 
        
                $check = $conn->prepare("SELECT * FROM d1");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d1[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d2");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d2[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d3");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d3[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d4");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d4[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d5");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d5[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d6");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d6[] = $row;
                        $row = $check->fetch();
                    }
                }
                $check = $conn->prepare("SELECT * FROM d7");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $d7[] = $row;
                        $row = $check->fetch();
                    }
                }
        
                $check = $conn->prepare("SELECT * FROM users WHERE userStatus = 1");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog >= 1)
                {
                    $row = $check->fetch();
                    while($row != NULL) {
                        $array[$row['userID']] = $row;
                        $row = $check->fetch();
                    }
                }
    }





require('assets/snippets/header.php'); 

?>

<style>
ul#menu li {
  display:inline;
}
</style>

<section class="week">

  <center><h4>
    <!--<a class="arrow" href="<?php echo $prevWeekURL ?>">&larr;</a> -->
    <?php echo $firstDay->padded() ?>/<?php echo $firstDay->month()->inta() ?>/<?php echo substr($firstDay->year()->int(),-2) ?> - 
    <?php echo $lastDay->padded() ?>/<?php echo $lastDay->month()->inta() ?>/<?php echo substr($lastDay->year()->int(),-2) ?>
    <!-- <a class="arrow" href="<?php echo $nextWeekURL ?>">&rarr;</a> -->
  </h4></center>
    <br>
  <div class="row" style="overflow-x:auto;">
    <div class="x_panel">
        <div class="x_content">
  <table class = "table table-responsive">
    <thead>
        <th></th>
      <?php foreach($currentWeek->days() as $day): ?>
        <th><?php echo ucfirst($day->name()) ?><p><?php echo $day->int() ?>/<?php echo $firstDay->month()->inta() ?></p></th>
      <?php endforeach ?>
    </thead>
    <tbody>
    <?php for($i=1;$i<=$numar_programe;$i++): ?>
    <tr>
        <td><?php echo $programe[$i]['i'].' - '.$programe[$i]['o']; ?></td>
        <?php for($j=1;$j<=7;$j++): ?>
        <td>
            
                <!-- Button trigger modal -->
                <?php 
                if($ziuamea > $currentWeek->daysv()[$j-1]->int())
                {
                    $display = 0;
                }
                elseif($ziuamea == $currentWeek->daysv()[$j-1]->int()) {
                    if(substr($ora123, 0, 2) > substr($programe[$i]['i'],0,2)) {
                        $display = 0;
                    }
                    elseif(substr($ora123, 0, 2) == substr($programe[$i]['i'],0,2)){
                        if(substr($ora123, -2, 2) > (substr($programe[$i]['i'], -2, 2) + 5)) {
                            $display = 0;
                        }
                        else $display = 1;
                    }
                    else $display = 1;
                }
                else $display = 1;
                ?>
                <?php 
                    $day = 'd'.$j;
                    $pro = 'p'.$i;
                    $d1p1 = $day.$pro;
                    if(($_SESSION['masina'] > 0 && $_SESSION['userDay'] == $day && $_SESSION['userP'] == $pro) || ($_SESSION['masina1'] > 0 && $_SESSION['userDay1'] == $day && $_SESSION['userP1'] == $pro)):
                ?>
                    <?php 
                        if($_SESSION['masina'] > 0 && $_SESSION['userDay'] == $day && $_SESSION['userP'] == $pro):
                    ?>
                        <?php if($display == 1): ?>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#<?=$d1p1?>">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#<?=$d1p1?>" disabled="disabled">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php endif; ?>
                    <?php
                        else:
                    ?>
                        <?php if($display == 1): ?>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#<?=$d1p1?>">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#<?=$d1p1?>" disabled="disabled">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php endif; ?>
                    <?php
                        endif;
                    ?>
                <?php 
                    else:
                ?>
                        <?php if($display == 1): ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?=$d1p1?>">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?=$d1p1?>" disabled="disabled">
                            <?php echo $_SESSION[$d1p1]; ?>
                            </button>
                        <?php endif; ?>
                <?php endif; ?>

                <!-- Modal -->
                <div class="modal fade" id="<?=$d1p1?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Rezerva o masina</h5>
                                
                            </div>
                            <div class="modal-body">
                                <ul id="menu">
                                    <?php 
                                        for($masina = 1; $masina <= 5; $masina++) {
                                            if($_SESSION['masina'] == $masina && $_SESSION['userDay'] == $day && $_SESSION['userP'] == $pro):
                                                $butonu = '<li><a href = "index.php?day='.$j.'&p='.$i.'&m=';
                                                $butonu = $butonu . $masina . '">';
                                                $butonu = $butonu . '<button type="button" class="btn btn-danger">Elimina<br>';
                                                $butonu = $butonu . $masina;
                                                $butonu = $butonu . ' </button></a></li>';
                                                echo $butonu;
                                            elseif($_SESSION['masina1'] == $masina && $_SESSION['userDay1'] == $day && $_SESSION['userP1'] == $pro):
                                                $butonu = '<li><a href = "index.php?day='.$j.'&p='.$i.'&m=';
                                                $butonu = $butonu . $masina . '">';
                                                $butonu = $butonu . '<button type="button" class="btn btn-warning">Elimina<br>';
                                                $butonu = $butonu . $masina;
                                                $butonu = $butonu . ' </button></a></li>';
                                                echo $butonu;
                                            elseif($d1[$masina-1]['status'] == 0):
                                                $butonu = '<li><button type="button" class="btn btn-danger" disabled="disabled">Defect<br>';
                                                $butonu = $butonu . $masina;
                                                $butonu = $butonu . ' </button></li>';
                                                echo $butonu;
                                            elseif(($d1[$masina-1][$pro] == 0 && $day == "d1") || ($d2[$masina-1][$pro] == 0 && $day == "d2") || ($d3[$masina-1][$pro] == 0 && $day == "d3") || ($d4[$masina-1][$pro] == 0 && $day == "d4") || ($d5[$masina-1][$pro] == 0 && $day == "d5") || ($d6[$masina-1][$pro] == 0 && $day == "d6") || ($d7[$masina-1][$pro] == 0 && $day == "d7")):
                                                $butonu = '<li><a href = "index.php?day='.$j.'&p='.$i.'&m=';
                                                $butonu = $butonu . $masina . '">';
                                                $butonu = $butonu . '<button type="button" class="btn btn-primary">Liber<br>';
                                                $butonu = $butonu . $masina;
                                                $butonu = $butonu . ' </button></a></li>';
                                                echo $butonu;
                                            else:
                                                $butonu = '<li><button type="button" class="btn btn-secondary" disabled="disabled">Cam:';
                                                if($day == "d1"):
                                                    $butonu = $butonu . $array[$d1[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d2"):
                                                    $butonu = $butonu . $array[$d2[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d3"):
                                                    $butonu = $butonu . $array[$d3[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d4"):
                                                    $butonu = $butonu . $array[$d4[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d5"):
                                                    $butonu = $butonu . $array[$d5[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d6"):
                                                    $butonu = $butonu . $array[$d6[$masina-1][$pro]]['userRoom'] . '<br>';
                                                elseif($day == "d7"):
                                                    $butonu = $butonu . $array[$d7[$masina-1][$pro]]['userRoom'] . '<br>';
                                                endif;
                                                $butonu = $butonu . $masina;
                                                $butonu = $butonu . ' </button></li>';
                                                echo $butonu;
                                            endif;
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
        </td>
        <?php endfor; ?>
    </tr>
    <?php endfor; ?>
  </table>
        </div>
    </div>
    </div>

</section>


<?php require('assets/snippets/footer.php') ?>