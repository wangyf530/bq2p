<?php include_once "db.php";
$sub = $_POST['subject'];
$Que->save(['text'=>$sub,'main_id'=>0]);

$sub_id = q("SELECT `id` FROM `Que` WHERE `text` = '$sub'");

$_POST['subject']='';
foreach ($_POST['options'] as $opt) {
    $Que->save(['text'=>$opt, 'main_id'=>$sub_id]);
}