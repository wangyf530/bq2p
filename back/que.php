<fieldset style="width:80%; margin:auto;">
    <legend>新增問卷</legend>
    <table width="100%">
        <tr>
            <td class="clo">問卷名稱</td>
            <td>
                <input type="text" name="subject" id="subject" style="width:80%">
            </td>
        </tr>
        <tr>
            <td colspan="2" class='clo'>
                <div id = "options">
                    選項
                    <input type="text" name="option[]" id="" style="width:60%">
                    <button onclick='more()'>更多</button>
                </div>
            </td>
        </tr>
    </table>
    <div class="ct">
        <button onclick="addQue()">新增</button>
        <button onclick="resetForm()">清空</button>
    </div>
</fieldset>

<script>
    function more() {
        // console.log('more');
        let el = `<div>
                選項
                <input type="text" name="option[]" id="" style="width:60%">`
        $("#options").before(el)
    }

    function addQue(){
        let subject = $("#subject").val();
        let options = $("input[name='option[]']").map((id,item)=>$(item).val()).get();

        $.post("./api/add_que.php",{subject,options},(res)=>{
            location.reload();
            // console.log(res); 
        })
    }

    function resetForm(){
        $("input[type='text']").val('');
    }
</script>