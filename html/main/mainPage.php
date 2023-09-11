<?php
    session_start();
    if($_SESSION["result"]){
        $result = $_SESSION["result"];
    
foreach ($result as $row) {
    $name = $row["name"];
    $name_json = json_encode($name);
}
    }else{
        header("Location: ../index.php");
    }


    $password=$_ENV["password"];
    $dsn_format = "mysql:host=%s;dbname=%s;port=%s";
    
    $dsn=sprintf($dsn_format,$_ENV["HOST"],$_ENV["DB"],$_ENV["PORT"]);
    try{
        global $dsn;
        global $password;
        $connection = new PDO($dsn,$_ENV['USER'],$password);
    } catch (PDOException $e) {
        print("エラー!: " . $e->getMessage() . "<br/gt;");
        die();
    }
    global $connection;
    try{
        $sql_format = "select * from chat.log";
        $sql = $connection -> prepare($sql_format);
        $sql -> execute();
    }catch(PDOException $e){
        print $e;
        $warn = "エラーが発生しました";
    }
    global $sql;
    $result = $sql -> fetchAll(PDO::FETCH_ASSOC);
    if(!isset($result)){
        $warn = "メッセージがありません";
    }
    print $warn;
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Dashboard</h1>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
            scroll = function(){
                $("#content").scrollTop(10000)
            }        
        //メッセージの登録
        var msgsend = function(){
            var info_obj =  {"message": $("#message").val(),"name": <?php echo $name_json ?>}
            $.ajax({
                type: "POST",
                url: "msgsend.php",
                data: info_obj,
                datatype: "json"
            })
            .done(function(){
                $("#message").val("")
                $.when(msgloader()
                ).done(function(){
                })


            })
            .fail(function(XMLHttpRequest, textStatus, errorThrown){
                alert(errorThrown)
            })

                    }
        
        //メッセージのロード(送信時)
        const msgloader = function(){
                $.ajax({
                    type: "POST",
                    url: "msgloader.php",
                    dataType: "json"
                })
                .done(function(data){
                        $("#content").text(null)
                    for(n=0;n<data.length;n++){//メッセージの挿入
                        $("#content").append("<p class=time>"+data[n].time+"</p>")
                        $("#content").append("<p class=content>"+data[n].content+"</p><br>")
                    }
                    scroll()
                })
                .fail(function(XMLHttpRequest, textStatus, errorThrown){
                    alert(errorThrown)
                })
        
        
        
        }
        //メッセージのロード(定期読み込み)
        const Nload = function(){
                $.ajax({
                    type: "POST",
                    url: "msgloader.php",
                    dataType: "json"
                })
                .done(function(data){
                        $("#content").text(null)
                    for(n=0;n<data.length;n++){//メッセージの挿入
                        $("#content").append("<p class=time>"+data[n].time+"</p>")
                        $("#content").append("<p class=content>"+data[n].content+"</p><br>")
                    }
                    var element=document.getElementById("content")
                    var nowheight = element.scrollTop
                    var maxheight = $("#content")[0].scrollHeight-601
                    if(maxheight-nowheight<=80){
                        scroll()
                    }
                })
                .fail(function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus)
                })
        
        
        
        }

        //ロード
        $(function(){
            h = $(window).height();
            $("#loading").css('display','block')
        })
        $(window).on('load',function(){
            h = $(window).height();
            $("#content").css("display","block")
            $(".content").css("display","block")
            $("#loading").delay(2000).fadeOut(2000)
            $("#loading_message").delay(1000).fadeOut(2000)
            scroll()
            //１メッセージ40px

        })
        //送信時の処理
        $(function(){
            $("form").submit(function(event){
                if($("#message").val()){
                    $("#warn").text("")
                    msgsend()
                        
            }else{
                $("#warn").text("メッセージを入力してください！")   
            }})
            })
        setInterval(Nload,2000)
    </script>

    <div id="loading">
        <div id=loading_message>
            <p class="name">ようこそ、<?php
            global $name;
            echo $name;
            ?>さん</p>
            <img src="loading.gif" alt="ロード中・・・" height="150px" width="150px">
        </div>
    </div>
    <div id="content">
    </div>
    <div id="msgbox">
        <form method="post" onsubmit="return false">
            <input id= "message" type="text" name="message" placeholder="ここにメッセージを入力">
            <input class="send" type="submit" name="send" value="送信">
        </form>
    </div>
    <p id="warn"><?php $warn ?></p>

</body>
</html>