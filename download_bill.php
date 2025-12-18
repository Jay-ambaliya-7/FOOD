<?php
session_start();
if (!isset($_SESSION['last_bill'])) {
    echo "No bill found to download.";
    exit();
}

$bill = $_SESSION['last_bill'];
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=bill_" . time() . ".html");
header("Pragma: no-cache");
header("Expires: 0");
echo $bill;
exit();
?>
