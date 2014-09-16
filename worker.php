<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
mb_internal_encoding('UTF-8');
$aColumns          = array(
    'UID',
    'TimeStamp',
    'IP',
    'User',
    'Message'
);
$sIndexColumn      = 'UID';
$sTable            = 'activity_log';
$gaSql['user']     = $MYSQL_USERNAME;
$gaSql['password'] = $MYSQL_PASSWORD;
$gaSql['db']       = $MYSQL_PASSWORD;
$gaSql['server']   = $MYSQL_HOST;
$gaSql['port']     = 3306;
$input =& $_GET;
$gaSql['charset'] = 'utf8';
$db               = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
if (mysqli_connect_error()) {
    die('Error connecting to MySQL server (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
} //mysqli_connect_error()
if (!$db->set_charset($gaSql['charset'])) {
    die('Error loading character set "' . $gaSql['charset'] . '": ' . $db->error);
} //!$db->set_charset($gaSql['charset'])
$sLimit = "";
if (isset($input['start']) && $input['start'] != '-1') {
    $sLimit = " LIMIT " . intval($input['iDisplayStart']) . ", " . intval($input['iDisplayLength']);
} //isset($input['start']) && $input['start'] != '-1'
$aOrderingRules = array();
if (isset($input['iSortCol_0'])) {
    $iSortingCols = intval($input['iSortingCols']);
    for ($i = 0; $i < $iSortingCols; $i++) {
        if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
            $aOrderingRules[] = "`" . $aColumns[intval($input['iSortCol_' . $i])] . "` " . ($input['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
        } //$input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true'
    } //$i = 0; $i < $iSortingCols; $i++
} //isset($input['iSortCol_0'])
if (!empty($aOrderingRules)) {
    $sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
} //!empty($aOrderingRules)
else {
    $sOrder = " ORDER BY  `activity_log`.`UID` DESC ";
}
$iColumnCount    = count($aColumns);
$aFilteringRules = "";
if (isset($input["search"]["value"]) && $input["search"]["value"] != "") {
    $aFilteringRules = "`UID` LIKE  '%" . $db->real_escape_string($input["search"]["value"]) . "%' OR `TimeStamp` LIKE  '%" . $db->real_escape_string($input["search"]["value"]) . "%' OR  `IP` LIKE  '%" . $db->real_escape_string($input["search"]["value"]) . "%'  OR  `User` LIKE  '%" . $db->real_escape_string($input["search"]["value"]) . "%' OR  `Message` LIKE  '%" . $db->real_escape_string($input["search"]["value"]) . "%'";
} //isset($input["search"]["value"]) && $input["search"]["value"] != ""
for ($i = 0; $i < $iColumnCount; $i++) {
    if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
        $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch_' . $i]) . "%'";
    } //isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != ''
} //$i = 0; $i < $iColumnCount; $i++
if (!empty($aFilteringRules)) {
    $sWhere = " WHERE " . implode(" AND ", $aFilteringRules);
} //!empty($aFilteringRules)
else {
    $sWhere = "";
}
$aQueryColumns = array();
foreach ($aColumns as $col) {
    if ($col != ' ') {
        $aQueryColumns[] = $col;
    } //$col != ' '
} //$aColumns as $col
$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", $aQueryColumns) . "`
    FROM `" . $sTable . "`" . $sWhere . $aFilteringRules . $sOrder . "LIMIT " . $input["start"] . "," . $input["length"];
$rResult = $db->query($sQuery) or die($db->error);
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $db->query($sQuery) or die($db->error);
list($iFilteredTotal) = $rResultFilterTotal->fetch_row();
$sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
$rResultTotal = $db->query($sQuery) or die($db->error);
list($iTotal) = $rResultTotal->fetch_row();
$output = array(
    "sEcho" => intval($input['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    'pageLength' => '100',
    "aaData" => array()
);
while ($aRow = $rResult->fetch_assoc()) {
    $row = array();
    for ($i = 0; $i < $iColumnCount; $i++) {
        if ($aColumns[$i] == 'TimeStamp') {
            $row[] = date("g:i a F j, Y ", $aRow[$aColumns[$i]]);
        } //$aColumns[$i] == 'TimeStamp'
        elseif ($aColumns[$i] != ' ') {
            $row[] = $aRow[$aColumns[$i]];
        } //$aColumns[$i] != ' '
    } //$i = 0; $i < $iColumnCount; $i++
    $output['aaData'][] = $row;
} //$aRow = $rResult->fetch_assoc()
echo json_encode($output);