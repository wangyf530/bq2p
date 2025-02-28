<?php
    $id = $_GET['id'];
    $subject = $Que->find($id);
    $options = $Que->all(['main_id'=>$id]);
?>
<fieldset style="width:95%;">
    <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>
    <h3><?=$subject['text'];?></h3>
    <form action="./api/vote.php" method="post">
        <?php foreach($options as $option):?>
        <p>
            <input type='radio' name='opt' value='<?=$option['id'];?>'> <?=$option['text'];?>
        </p>
        <?php endforeach;?>
        <div class="ct">
            <input type="submit" value="我要投票">
        </div>
    </form>
</fieldset>