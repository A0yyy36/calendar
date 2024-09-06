<?php
    $id = $_GET['id'];
    list($year, $month, $day) = explode('-', $id);

    function getSchedule($date){
        $pdo = new PDO('sqlite:calendar.db');
        $stmt = $pdo->prepare('SELECT date, title FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row){
            return $row['title'];
        }
        return "";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="calendarEdit.css">
        <script src="jquery-3.7.1.min.js"></script>
        <script src="calendar.js"></script>
        <title>Document</title>
    </head>
    <body>
        <center>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
            <h2><?php echo $year .'年' . intval($month) .'月' . intval($day). '日'; ?></h2>
            <textarea id="content"><?php echo str_replace('<br>', "\n", getSchedule($id)); ?></textarea> <!-- 不要な改行を削除 -->
            <br><br>
            <div id="ok-button">OK</div>
        </center>
    </body>
</html>
