<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
if (isset($_GET['cmd']) && !empty($_GET['cmd']) && Check_Login_Value() == 1) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
    $con = mysql_mysqli_connect();
    if ($_GET['cmd'] == "activity_log") {
        $result = mysqli_query($con, "SELECT * FROM activity_log ORDER BY`activity_log`.`UID` DESC LIMIT 0 , " . $_GET['limit'] . "");
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td><center>" . $row['UID'] . "</center></td>";
            echo "<td><center>" . date("g:i a F j, Y ", $row['TimeStamp']) . "</center></td>";
            echo "<td><center>" . $row['IP'] . "</center></td>";
            echo "<td><center>" . $row['User'] . "</center></td>";
            echo "<td><center>" . $row['Message'] . "</center></td>";
            echo "</tr>";
        }
        mysqli_close($con);
        exit;
    }
    if ($_GET['cmd'] == "activity_log_clear") {
        mysqli_query($con, 'TRUNCATE TABLE activity_log;');
        Add_log_entry("Activity Log Cleared", "");
        echo 'done';
        mysqli_close($con);
        exit;
    }
}
?>
