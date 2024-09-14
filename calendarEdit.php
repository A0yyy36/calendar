<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    list($year, $month, $day) = explode('-', $id);

    function getSchedule($date){
        $pdo = new PDO('sqlite:calendar.db');
        $stmt = $pdo->prepare('SELECT title FROM schedule WHERE date = :date');
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
        return $result ? $result['title'] : ""; // Return the title or empty string if not found
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
            <input type="hidden" id="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <h2><?php echo htmlspecialchars($year .'年' . intval($month) .'月' . intval($day). '日', ENT_QUOTES, 'UTF-8'); ?></h2>
            <textarea id="content"><?php echo htmlspecialchars(getSchedule($id), ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br><br>
            <div id="ok-button">OK</div>
        </center>
    </body>
</html>
