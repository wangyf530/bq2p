<?php include_once "db.php";
$id = $_POST['id'];
$acc = $_SESSION['user'];

$news = $News->find($id);

$chk = $Like->find(['acc'=>$acc, 'news'=>$id]);
echo $id,$acc,$chk;
if($chk>0){
    $Like->del(['news'=>$id, 'acc'=>$acc]);
    $news['likes']--;
} else {
    $Like->save(['news'=>$id, 'acc'=>$acc]);
    $news['likes']++;
}

$News->save($news);
