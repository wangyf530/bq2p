<?php include_once "db.php";
$id = $_POST['id'];
$acc = $_SESSION['user'];

$news = $News->find($id);

$chk = $Like->find(['acc'=>$acc, 'id'=>$id]);

if($chk>0){
    $Like->del(['id'=>$id, 'acc'=>$acc]);
    $news['like']--;
} else {
    $Like->save(['id'=>$id, 'acc'=>$acc]);
    $news['like']++;
}

$News->save($news);
