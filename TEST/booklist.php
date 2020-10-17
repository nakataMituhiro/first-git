<?php //書籍DB取得
    $user ='nakata';
    $pass ='pass';

    try{
        $conn = new PDO('mysql:host=localhost;dbname=bookstore;charaset=UTF8;',$user,$pass);
        
        //一覧取得
        $sql = 'Select count(*) as idCnt from books';
        $state = $conn -> query($sql);
        $records = $state -> fetchAll();
    
        //入力チェック
        if(array_key_exists('book_title',$_POST)){
            $id = (int)$records[0]['idCnt'] + 1;
            $at = date('Y-m-d H:i:s');
            
            //登録処理
            $sql = 'INSERT INTO books (id,title,price,created_at) VALUES(:id,:title,1000,:at)';
            print_r($sql);
            $state = $conn -> prepare($sql);
            $state->bindParam(':id',$id);
            $state->bindParam(':title',$_POST['book_title']);
            $state->bindParam(':at',$at);
            $state->execute();
        }
        
        //一覧取得
        $sql = 'Select * from books order by created_at DESC';
        $state = $conn -> query($sql);
        $records = null;
        $records = $state -> fetchAll();

    }catch(PDOException $e){
        echo $e->getMessage();
    }
    
    //使用後のクリア
    $state = null;
    $conn = null;


?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Booklist</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body class="mt-4">
<?php
    // フォームデータ送受信確認用コード（本番では削除）
    print '<div style="background-color: skyblue;">';
    print '<p>動作確認用:</p>';
    print_r($_POST);
    print '</div>';
?>
        <div class="container">
            <h1><a href="booklist.php">Booklist</a></h1>

            <h2>書籍の登録フォーム</h2>
            <form action="booklist.php" method="POST" class="form-inline mb-2">
                <div class="form-group mr-2">
                    <input type="text" name="book_title" class="form-control" placeholder="書籍タイトルを入力" required>
                </div>
                <button type="submit" name="submit_add_book" class="btn btn-primary">登録</button>
            </form>
            <hr />
            <h2>登録された書籍一覧</h2>
            <ul>
                <li>はじめてのWebアプリケーション</li>
                <li>かんたん！PHPプログラミング</li>
                <li>PHP+MySQLで作るWebアプリケーション</li>
                <br>
<?php
    if ($records){
        foreach($records as $rec){
            //タイトルを取得して配列にセット
            $title = $rec['title'];
            //print("<li>");
            //print_r($title);
            //print("</li>");
?>
             <!--タイトル配列をループ出力する-->
            <li><?php print htmlspecialchars($title,ENT_QUOTES,"UTF-8"); ?></li>
<?php
        }
    }
?>
   
            </ul>
        </div>

        <!-- BootstrapなどのJavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    </body>
    
</html>