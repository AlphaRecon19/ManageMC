<?php
sleep (1);
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/log.php');
if (isset($_GET['cmd']) && !empty($_GET['cmd']) && Check_Login_Value() == 1) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/mysql.php');
    $con = mysql_mysqli_connect();
    if ($_GET['cmd'] == "activity_log") {
		
		$start = $_GET['s'];
		
		$result = mysqli_query($con, "SELECT * FROM activity_log");
		$numrows = mysqli_num_rows($result);
		$limit = $_GET['limit'];

		if(isset($_GET['v1']) && isset($_GET['v2'])) 
		{
			if ($_GET['v1'] == "hash" ) { $nv1 = "UID";}
			if ($_GET['v1'] == "time" )  { $nv1 = "TIMESTAMP";}
			if ($_GET['v1'] == "ip" )  { $nv1 = "IP";}
			if ($_GET['v1'] == "user" )  { $nv1 = "USER";}
			if ($_GET['v1'] == "message" )  { $nv1 = "MESSAGE";}
			else { $nv1 = "UID"; }
			
			if ($_GET['v2'] == "a" ) { $nv2 = "DESC";}
			else { $nv2 = "ASC";}
		
		$from = $start + 1;
		if($start == ($limit - $start) )
		
		{
			$end = 'From:['. $from . '] To:['. ($_GET['limit'] + $start) .'] Total:['. $numrows .'] <a href="dashboard.php?page=Activity&s='. ($start + $limit) .'"> > </a>';
		}
		
		elseif($start == 0)
		
		{
			$end = 'From:['. $from . '] To:['. ($_GET['limit'] + $start) .'] Total:['. $numrows .'] <a href="dashboard.php?page=Activity&s='. ($start + $limit) .'"> > </a>';
		}
		
		elseif(($start + $limit) > $numrows )
		
		{
			$end = '<a href="dashboard.php?page=Activity&s='. ($start - $limit) .'"> < </a> From:['. $from . '] To:['. $numrows .'] Total:['. $numrows .']';
		}
		
		else
		{
			$end = '<a href="dashboard.php?page=Activity&s='. ($start - $limit) .'"> < </a> From:['. $from . '] To:['. ($_GET['limit'] + $start) .'] Total:['. $numrows .'] <a href="dashboard.php?page=Activity&s='. ($start + $limit) .'"> > </a>';	
		}
			
		$data['header'] = $end;
		
		
		$to = ($_GET['limit'] + $start);
		$result = mysqli_query($con, "SELECT * FROM activity_log WHERE UID BETWEEN $from AND $to ORDER BY`activity_log`.`$nv1` $nv2 LIMIT 0 , " . $_GET['limit'] . "");	
		}
		else
		{
        $result = mysqli_query($con, "SELECT * FROM activity_log ORDER BY`activity_log`.`UID` DESC LIMIT 0 , " . $_GET['limit'] . "");
		}
		$data['table'] = "";
        while ($row = mysqli_fetch_array($result)) {
            $data['table'] .= "<tr>";
            $data['table'] .= "<td><center>" . $row['UID'] . "</center></td>";
            $data['table'] .= "<td><center>" . date("g:i a F j, Y ", $row['TimeStamp']) . "</center></td>";
            $data['table'] .= "<td><center>" . $row['IP'] . "</center></td>";
            $data['table'] .= "<td><center>" . $row['User'] . "</center></td>";
            $data['table'] .= "<td><center>" . $row['Message'] . "</center></td>";
            $data['table'] .= "</tr>";
        }
        mysqli_close($con);
		header('Content-Type: application/json');
		echo json_encode($data);
        exit;
    }
    if ($_GET['cmd'] == "activity_log_clear") {
        mysqli_query($con, 'TRUNCATE TABLE activity_log;');
        Add_log_entry("Activity Log Cleared", "System");
        echo 'done';
        mysqli_close($con);
        exit;
    }
}
?>
