<fieldset style="width:95%;">
    <legend>目前位置：首頁 > 問卷調查</legend>
    <table width="100%">
        <tr>
            <th width="5%">編號</th>
            <th width="50%">問卷題目</th>
            <th width="10%">投票總數</th>
            <th width="15%">結果</th>
            <th width="15%">狀態</th>
        </tr>
        <?php
        $rows = $Que->all(['main_id'=>0]);
        foreach ($rows as $key=>$row):
        ?>
            <tr class='ct'>
                <td><?=$key+1;?>.</td>

                <td> <?=$row['text'];?></td>
                <td>
                    <?=$row['vote'];?>
                </td>
                <td>
                    <a href="?do=result&id=<?=$row['id'];?>">結果</a>
                </td>
                <td>
                    <?php
                    if (!isset($_SESSION['user'])) {
                        echo "<a href='?do=login'>請先登入</a>";
                    } else{
                        echo "<a href='?do=vote&id={$row['id']}'>參與投票</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>