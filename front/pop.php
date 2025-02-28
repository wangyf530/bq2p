<style>
    .detail {
        background: rgba(50, 50, 50, 0.8);
        color: white;
        width: 300px;
        height: 400px;
        position: absolute;
        display: none;
        left: 10px;
        top: 10px;
        z-index: 999;
        overflow: auto;
        font-size:14px;
    }
</style>

<fieldset style="width:95%;">
    <legend>目前位置：首頁 > 人氣文章區</legend>
    <table width="100%">
        <tr>
            <th width="30%">標題</th>
            <th width="50%">內容</th>
            <th>人氣</th>
        </tr>
        <?php

        $total = $News->count();
        $div = 5;
        $pages = ceil($total / $div);
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $div;
        $rows = $News->all(['sh' => 1], " ORDER BY `likes` DESC LIMIT $start, $div");
        foreach ($rows as $row):
        ?>
            <tr>
                <td class=' clo title'><?= $row['title']; ?></td>

                <td style="position:relative;">
                    <span class="content">
                        <?= mb_substr($row['content'], 0, 20); ?>...
                    </span>
                    <span class='detail'>
                        <h3 style="color:skyblue"><?= $row['title']; ?></h3>
                        <?= nl2br($row['content']); ?>
                    </span>
                </td>

                <td class='ct'>
                    <?= $row['likes']; ?>個人說
                    <img src="./icon/02B03.jpg" alt="讚" style="width:25px">
                    <?php
                    if (isset($_SESSION['user'])) {
                        $chk = $Like->count(['news' => $row['id'], 'acc' => $_SESSION['user']]);
                        $like = ($chk > 0) ? "收回讚" : "讚";
                        echo "<a href='#' data-id={$row['id']} class='like'>$like</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>

<div class="ct">

    <?php
    if (($now - 1) > 0) {
        echo "<a href='?do=pop&p=" . ($now - 1) . "'>&lt;</a>";
    }
    for ($i = 1; $i <= $pages; $i++) {
        $size = ($now == $i) ? '24px' : '16px';
        echo "<a href='?do=pop&p=$i' style='font-size:$size; margin:0 5px;'>$i</a>";
    }

    if (($now) < $pages) {
        echo "<a href='?do=pop&p=" . ($now + 1) . "'>&gt;</a>";
    }
    ?>
</div>

<script>
    $(".title").hover(
        
        function() {
            console.log('hover')
            $(this).next().children(".detail").show();
        },
        function() {
            $(this).next().children(".detail").hide();

        })


    $(".like").on("click", function() {
        let id = $(this).data('id');
        let like = $(this).text();
        $.post("./api/like.php", {
            id
        }, () => {
            // console.log(res);

            switch (like) {
                case '讚':
                    $(this).text('收回讚')
                    break;
                case '收回讚':
                    $(this).text('讚')
                    break;
            }
            location.reload();
        })
    })
</script>