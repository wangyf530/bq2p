<?php include_once "db.php";
$opt_id = $_POST['opt'];
$option = $Que->find($opt_id);
$sub = $Que->find($option['main_id']);
$option['vote']++;
$sub['vote']++;
// dd($option);
// dd($sub);

$Que->save($option);
$Que->save($sub);

to("../index.php?do=result&id={$option['main_id']}");