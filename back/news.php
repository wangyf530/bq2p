<fieldset style="width:85%; margin:auto">
    <legend>最新文章管理</legend>
    <table class="ct" width="100%">
        <tr>
            <th>編號</th>
            <th width="60%">標題</th>
            <th>顯示</th>
            <th>刪除</th>
        </tr>
        <?php
        $total = $News->count();
        $div = 3;
        $pages = ceil($total/$div);
        $now = $_GET['p']??1;
        $start = ($now-1)*$div;

        $rows = $News->all(" limit $start, $div");
        foreach ($rows as $idx => $row):
        ?>
        <tr>
            <td><?=$start+$idx+1;?>.</td>
            <td><?=$row['title'];?></td>
            <td>
                <input type="checkbox" name="sh[]" id="sh" value="<?=$row['id'];?>" 
                <?=($row['sh']==1)?'checked':'';?>>
            </td>
            <td>
                <input type="checkbox" name="del[]" id="del" value="<?=$row['id'];?>">    
            </td>
        </tr>
        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
        <?php endforeach; ?>
        </table>
        <!-- page -->
         <div class="ct">
            
            <?php
            if(($now)-1>0){
                echo "<a href='?do=news&p=". ($now-1). "'> &lt; </a>";
            }
            for ($i=1; $i <= $pages; $i++) { 
                $size=($i==$now)?'24px':'16px';
                echo "<a href='?do=news&p=$i' style='font-size:$size'> $i </a>";
            }

            if(($now)+1<$pages){
                echo "<a href='?do=news&p=". ($now+1). "'> &gt; </a>";
            }
            ?>
         </div>


        <!-- button -->
         <div class="ct">
            <button onclick="edit()">確定修改</button>
         </div>
</fieldset>

<script>
    function edit(){
        let ids = $("input[name='id[]']").map((idx,item)=>$(item).val()).get();
        let del = $("input[name='del[]']:checked").map((idx,item)=>$(item).val()).get();
        let sh = $("input[name='sh[]']:checked").map((idx,item)=>$(item).val()).get();
        // console.log({ids,dels,sh});
        
        $.post("./api/edit_news.php",{ids, del, sh},(res)=>{
            // console.log(res);
            location.reload();
        })
    }
</script>