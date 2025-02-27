<style>
    .title{
        background-color: #ccc;
    }

    .grey-text{
        background-color: #eee;
    }
</style>
<fieldset>
    <legend>帳號管理</legend>
    <table class="ct" style="width:75%; margin:auto;">
        <tr>
            <td class="title">帳號</td>
            <td class="title">密碼</td>
            <td class="title">刪除</td>
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

    <h2>新增會員</h2>
    <div style="color:red">
        *請設定您要註冊的帳號及密碼（最長12個字元）
    </div>
    <table style="width:60%" >
        <tr>
            <td class='grey-text'>Step1:登入帳號</td>
            <td>
                <input type="text" name="acc" id="acc" style="width:98%">
            </td>

        </tr>
        <tr>
            <td class='grey-text'>Step2:登入密碼</td>
            <td>
                <input type="password" name="pw" id="pw" style="width:98%">
            </td>
        </tr>
        <tr>
            <td class='grey-text'>Step3:再次確認密碼</td>
            <td>
                <input type="password" name="pw2" id="pw2" style="width:98%">
            </td>
        </tr>
        <tr>
            <td class='grey-text'>Step4:信箱(忘記密碼時使用)</td>
            <td>
                <input type="text" name="email" id="email" style="width:98%">
            </td>
        </tr>
        <tr>
            <td><input type="button" value="新增" onclick="reg()">
                <input type="button" value="清除" onclick="resetForm()">
            </td>
        </tr>
    </table>
</fieldset>

<script>
    function del(){
        let dels = $("input[name='del[]']:checked");
        let ids = new Array();
        dels.each((idx,item)=>{
            ids.push($(item).val())
        })
        $.post("./api/del_user.php",{ids},()=>{
            location.reload();
        })
    }

    function resetChk(){
        $("input[type='checkbox']:checked").prop("checked",false);
    }

    function reg() {
        let user = {
            acc:$("#acc").val(),
            pw:$("#pw").val(),
            pw2:$("#pw2").val(),
            email:$("#email").val()
        }
        // console.log(user);
        
        if (user.acc=='' ||user.pw=='' ||user.pw2=='' ||user.email==''){
            alert("不可空白");
        } else if (user.pw!=user.pw2){
            alert("密碼錯誤")
        } else {
            $.get("./api/chk_acc.php",{acc:user.acc},(res)=>{
                if(parseInt(res)>0){
                    alert("帳號重複")
                } else {
                    $.post("./api/reg.php",user,function(res){
                        // console.log("reg => ",res);
                        if(parseInt(res)==1){
                            // alert("註冊成功")
                            location.reload();
                        } else {
                            alert("almost there");
                        }
                    })
                }
            })
        }
        resetForm();
    }

    function resetForm(){
        $("#acc").val("");
        $("#pw").val("");
        $("#pw2").val("");
        $("#email").val("");
    }

    
</script>