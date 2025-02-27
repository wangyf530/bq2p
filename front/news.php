<style>
    .detail {
        display: none;
    }
</style>

<fieldset style="width:95%; display:inline-block; vertical-align:top">
    <legend>目前位置：首頁 > 分類網誌 > 最新文章區</legend>
    <table width="100%">
        <tr>
            <th width="30%">標題</th>
            <th width="60%">內容</th>
            <th></th>
        </tr>
        <?php

        $total = $News->count();
        $div = 5;
        $pages = ceil($total / $div);
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $div;
        $rows = $News->all(['sh' => 1], " LIMIT $start, $div");
        foreach ($rows as $row):
        ?>
            <tr>
                <td class='title'><?= $row['title']; ?></td>
                <td>
                    <span class="content">
                        <?= mb_substr($row['content'], 0, 20); ?>...
                    </span>
                    <span class='detail'><?= $row['content']; ?></span>
                </td>
                <td>
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
        echo "<a href='?do=news&p=" . ($now - 1) . "'>&lt;</a>";
    }
    for ($i = 1; $i <= $pages; $i++) {
        $size = ($now == $i) ? '24px' : '16px';
        echo "<a href='?do=news&p=$i' style='font-size:$size; margin:0 5px;'>$i</a>";
    }

    if (($now) < $pages) {
        echo "<a href='?do=news&p=" . ($now + 1) . "'>&gt;</a>";
    }
    ?>
</div>

<script>
    $(".title").on("click", function() {
        $(this).next().children(".content,.detail").toggle();
    })

    $(".like").on("click", function() {
        let id = $(this).data('id');
        let like = $(this).text();
        $.post("./api/like.php", {
            id
        }, () => {
            switch (like) {
                case '讚':
                    $(this).text('收回讚')
                    break;
                case '收回讚':
                    $(this).text('讚')
                    break;
            }
        })
    })
</script>