<?php
    $id = $_GET['id'];
    $subject = $Que->find($id);
    $options = $Que->all(['main_id'=>$id]);
?>
<style>
.result{
    display: flex;
    align-items: center;
}

.result p {
    width: 40%;
}
</style>
<fieldset style="width:95%;">
    <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>
    <h3><?=$subject['text'];?></h3>
    
        <?php 
            foreach($options as $idx => $option){
                if($subject['vote']==0){
                    $rate = 0;
                } else {
                    $rate = $option['vote']/$subject['vote'];
                }
                $rateStr = round($rate*100,2);
                $rateNum = $rate * 45;
        ?>
        <div class="result">
            <p> <?=$option['text'];?> </p>
            <div style="height:20px; width:<?=$rateNum;?>%; background-color:#999;"> &nbsp; </div>
            <div><?=$option['vote'];?>票 (<?=$rateStr;?>%)</div>
        </div>
        
        <?php };?>

        <div class="ct">
            <button onclick="location.href='?do=que'">返回</button>
        </div>
    
</fieldset>