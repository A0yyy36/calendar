<?php
    $retry_count = 10;
    $retry_wait_ms = 10;
    while(true){
        try{
            $pdo = new PDO('sqlite:calendar.db', '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $pdo->beginTransaction();
            setDatabase($pdo);
            $result = true;
            $pdo->commit();
        }
        catch(PDOException $e){
            $pdo->rollBack();
            $result = false;
            print $e->getMessage();
        }
        if(!$result && $retry_count > 0){
            usleep($retry_wait_ms * 1000);
            $retry_count--;
        }
        else{
            break;
        }
    }
    print $result;

    function setDatabase($pdo) {
        $date = $_GET['id'];
        $content = $_GET['content'];
    
        // デバッグ: 変数の確認
        var_dump($date, $content);
    
        // 日付に基づいて現在のエントリ数を確認
        $stmt = $pdo->prepare('SELECT count(date) FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $num = $stmt->fetchColumn();
    
        // デバッグ: クエリ結果の確認
        var_dump($num);
    
        if ($num == 0 && $content != "") {
            // エントリが存在しない場合は挿入
            $stmt = $pdo->prepare('INSERT INTO schedule (date, title) VALUES (:date, :title)');
        } elseif ($content != "") {
            // エントリが存在し、コンテンツが空でない場合は更新
            $stmt = $pdo->prepare('UPDATE schedule SET title = :title WHERE date = :date');
        } else {
            // エントリが存在し、コンテンツが空の場合は削除
            $stmt = $pdo->prepare('DELETE FROM schedule WHERE date = :date');
        }
    
        // 共通のバインド処理
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        if ($content != "") {
            $stmt->bindValue(':title', $content, PDO::PARAM_STR);
        }
    
        // クエリの実行
        if ($stmt->execute()) {
            echo "Database operation successful.";
        } else {
            echo "Failed to execute database operation.";
        }
    }    
?>