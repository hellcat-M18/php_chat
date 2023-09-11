<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(function(){    
        $('form').submit(function(event){
            let name = $("#name").val()
            let Upassword = $("#Upassword").val()
            if(name&&Upassword){
                let info_obj = {"name": name}
                $.ajax({
                    type: "POST",
                    url: "mysql-read.php",
                    data: info_obj,
                    datatype: "json"
                })
                .done(function(data){
                    if(data == true){
                        console.log(data)
                        $("#warn").text("このユーザー名は既に使われています！")
                    }else{
                        let info_obj = {"name": name,"Upassword": Upassword}
                        $.ajax({
                            type: "POST",
                            url: "mysql-write.php",
                            data: info_obj,
                            datatype: "json"
                        })
                        .done(function(){
                            sessionStorage.setItem('name', name)
                            sessionStorage.setItem('password', Upassword)
                            location.href = "./completed/completed.php"
                        })
                        .fail(function(XMLHttpRequest, textStatus, errorThrown){
                            alert(errorThrown)
            })

                    }
                })
                .fail(function(XMLHttpRequest, textStatus, errorThrown){
                    alert(errorThrown)
            })
            }else{
                $("#warn").text("必要事項を入力してください！")
            }
        })
    })
    </script>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
    <h1>アカウント作成</h1>
    <form method="post" onsubmit="return false">
    <table class="center_block" border="1">
        <tr><td>ユーザー名</td><td><input id="name" type="text" name="name" value=""></td></tr>
        <tr><td>パスワード</td><td><input id="Upassword" type="text" name="Upassword" value=""></td></tr>
    </table>
    
    <div class="center_block">
    <input class="button" type="submit" value="登録">
    </div>
    </form>
    <p id=warn></p>
   
    
</body>
</html>