<?php
    try {
        $pdo = new PDO('sqlite:calendar.db', '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->beginTransaction();
        setDatabase($pdo);
        $pdo->commit();
        echo "Database operation successful.";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Database operation failed: " . $e->getMessage();
    }

    function setDatabase($pdo) {
        $date = $_GET['id'];
        $content = $_GET['content'];
        error_log("Date: " . $date);
        error_log("Content: " . $content);
        $stmt = $pdo->prepare('SELECT count(date) FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $num = $stmt->fetchColumn();

        error_log("Number of entries: " . $num);

        if ($num == 0 && $content != "") {
            $stmt = $pdo->prepare('INSERT INTO schedule (date, title) VALUES (:date, :title)');
        } elseif ($content != "") {
            $stmt = $pdo->prepare('UPDATE schedule SET title = :title WHERE date = :date');
        } else {
            $stmt = $pdo->prepare('DELETE FROM schedule WHERE date = :date');
        }

        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        if ($content != "") {
            $stmt->bindValue(':title', $content, PDO::PARAM_STR);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute database operation.");
        }
    }
?>
