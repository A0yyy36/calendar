<?php
    // URLパラメータ 'id' を取得。無ければ空文字
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    
    // 'id' を '-' で区切り、年・月・日を取得
    list($year, $month, $day) = explode('-', $id);

    // 月と日をゼロ埋めしてフォーマットを統一
    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    $day = str_pad($day, 2, '0', STR_PAD_LEFT);

    // ゼロ埋めされた 'YYYY-MM-DD' 形式の id を作成
    $formatted_id = $year . '-' . $month . '-' . $day;

    // スケジュールを取得する関数
    function getSchedule($date) {
        // SQLiteデータベースに接続
        $pdo = new PDO('sqlite:calendar.db');
        // 指定された日付に対応するスケジュールを取得
        $stmt = $pdo->prepare('SELECT title FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // 1行のみ取得
        return $result ? $result['title'] : ""; // タイトルが存在すれば返す。なければ空文字を返す
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="calendarEdit.css">
        <script src="jquery-3.7.1.min.js"></script>
        <script src="calendar.js"></script>
        <title>Edit Schedule</title>
    </head>
    <body>
        <center>
            <!-- hiddenフィールドにフォーマットされたidの値をセット -->
            <input type="hidden" id="id" value="<?php echo htmlspecialchars($formatted_id, ENT_QUOTES, 'UTF-8'); ?>">
            <!-- 年、月、日の表示 -->
            <h2><?php echo htmlspecialchars($year . '年' . intval($month) . '月' . intval($day) . '日', ENT_QUOTES, 'UTF-8'); ?></h2>
            <!-- テキストエリアにスケジュール内容を表示 -->
            <textarea id="content"><?php echo htmlspecialchars(getSchedule($formatted_id), ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br><br>
            <!-- OKボタン -->
            <div id="ok-button">OK</div>
        </center>
    </body>
</html>
