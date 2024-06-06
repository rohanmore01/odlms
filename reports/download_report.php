<?php

$decodedDoc = base64_decode($_POST['uploaded_report']);
$file = $_POST['uploaded_report_name'];
file_put_contents($file, $decodedDoc);

if (file_exists($file)) 
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

?>