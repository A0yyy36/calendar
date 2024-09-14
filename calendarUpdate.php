<?php
    try {
        // データベース接続
        $pdo = new PDO('sqlite:calendar.db', '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        // トランザクション開始
        $pdo->beginTransaction();

        // データベース操作
        setDatabase($pdo);

        // コミット
        $pdo->commit();
        echo "Database operation successful.";
    } catch (PDOException $e) {
        // ロールバック
        $pdo->rollBack();
        echo "Database operation failed: " . $e->getMessage();
    }

    function setDatabase($pdo) {
        $date = $_GET['id'];
        $content = $_GET['content'];

        // デバッグ用: 変数の確認
        // error_log() はサーバーのエラーログに出力します
        error_log("Date: " . $date);
        error_log("Content: " . $content);

        // 日付に基づいて現在のエントリ数を確認
        $stmt = $pdo->prepare('SELECT count(date) FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $num = $stmt->fetchColumn();

        // デバッグ用: クエリ結果の確認
        error_log("Number of entries: " . $num);

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
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute database operation.");
        }
    }
?>
