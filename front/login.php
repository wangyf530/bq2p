<fieldset style="width: 50%; margin:auto;">
    <legend>會員登入</legend>
    <table width='100%'>
        <tr>
            <td style='background-color:#eee'>帳號</td>
            <td>
                <input type="text" name="acc" id="acc">
            </td>
        </tr>
        <tr>
            <td style='background-color:#eee'>密碼</td>
            <td>
                <input type="password" name="pw" id="pw">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="登入" onclick="login()">
                <input type="reset" value="清除" onclick="resetForm()">
            </td>
            <td style="text-align:right">
                <a href="?do=forgot">忘記密碼</a>
                &nbsp;| &nbsp;
                <a href="?do=reg">尚未註冊</a>
            </td>
        </tr>
    </table>
</fieldset>

<script>
    function login(){
        let user = {
            acc:$("#acc").val(),
            pw:$("#pw").val()
        };
        $.get("api/chk_acc.php",{acc:user.acc},function(res){
            if(parseInt(res)==0){
                // no such acc
                alert("查無帳號")
                resetForm();
            } else {
                $.post("api/chk_pw.php",user,function(res){
                    if(parseInt(res)==1){
                        alert("登入成功");
                        if (user.acc=='admin'){
                            location.href='admin.php';
                        } else {
                            location.href='index.php';
                        }
                    } else {
                        alert("密碼錯誤");
                        resetForm();
                    }
                })
            }
        })
    }

    function resetForm(){
        $("#acc").val("");
        $("#pw").val("");
    }
</script>