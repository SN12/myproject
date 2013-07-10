<?php
    $cr = "\n";
    $csvdata = "First Name" . ',' . "Last Name"  . $cr;
    $csvdata .= "da" . ',' . "dsdsa" . $cr;

    $thisfile = 'attacment.csv';

    $encoded = chunk_split(base64_encode($csvdata));

    // create the email and send it off
$email = 'sn.nazinyan@gmail.com';
    $subject = "File you requested from RRWH.com";
    $from = "scripts@rrwh.com";
    $headers = 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-Type: multipart/mixed;
        boundary="----=_NextPart_001_0011_1234ABCD.4321FDAC"' . "\n";

    $message = '

    This is a multi-part message in MIME format.

    ------=_NextPart_001_0011_1234ABCD.4321FDAC
    Content-Type: text/plain;
            charset="us-ascii"
    Content-Transfer-Encoding: 7bit

    Hello

    We have attached for you the PHP script that you requested from http://rrwh.com/scripts.php
    as a zip file.

    Regards

    ------=_NextPart_001_0011_1234ABCD.4321FDAC
    Content-Type: application/octet-stream;  name="';

    $message .= "$thisfile";
    $message .= '"
    Content-Transfer-Encoding: base64
    Content-Disposition: attachment; filename="';
    $message .= "$thisfile";
    $message .= '"

    ';
    $message .= "$encoded";
    $message .= '

    ------=_NextPart_001_0011_1234ABCD.4321FDAC--

    ';

    // now send the email
    mail($email, $subject, $message, $headers, "-f$from");
   ?>