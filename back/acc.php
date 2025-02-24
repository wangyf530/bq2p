<fieldset>
    <legend>帳號管理</legend>
    <table class="ct" style="width:75%; margin:auto;">
        <tr>
            <td>帳號</td>
            <td>密碼</td>
            <td>刪除</td>
        </tr>
        <?php
        $rows = $User->all();
        foreach ($rows as $row):
        ?>
        <tr>
            <td><?=$row['acc'];?></td>
            <td><?=str_repeat("*",strlen($row['pw']));?></td>
            <td><input type="checkbox" name="del[]" id="del" value='<?=$row['id']?>'></td>
        </tr>
        <?php endforeach;?>
    </table>
    <div class="ct">
        <button onclick="del()">確定刪除</button>
        <button onclick="resetChk()">清空選取</button>
    </div>
</fieldset>