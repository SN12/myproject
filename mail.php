<?php
require_once 'conf/vars.php';
$memberid = 234;
$code = "6f7f9432d35dea629c8384dab312259a";

/*  $result=mysql_query("select text from email_templates where name='welcome_email'");
  $row=mysql_fetch_array($result);

  $template_text=addslashes($row['text']);

  eval("\$body=\"$template_text\";"); */
$random_hash = md5(date('r', time()));

//$header = "MIME-Version: 1.0\r\n";
//$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";;
//
//$header.="From: postmaster@localhost";
//$subject = 'Test email with attachment';
//$attachment = chunk_split(base64_encode(file_get_contents("my.zip")));
//$body=$attachment;
$HTMLMessage = "<p style='font-size:12px;'>Dear <span style='font-style:italic;'>Syuzi</span></p>
        <p>
You have received this email because your account has been added to the contacts list in http://monitis.com. 
Please, click on the following link to activate your account.</p>
<p>http://minikk.vd</p>";
$filename="attacment.pdf";    
//$filename= "/".ROOTFOLDER . "/files/pdf/attacment.pdf";
$file = fopen($filename, "r");
$size = filesize($filename);
$content = fread($file, $size);
fclose($file);
//$filename="attacment.pdf";  
# encode the data for safe transit
# and insert \r\n after every 76 chars.
//$encoded_content = chunk_split(base64_encode(file_get_contents($filename)));

$encoded_content = chunk_split(base64_encode($content));
$FromName = 'postmaster@localhost';
$FromEmail = 'postmaster@localhost';


$boundary1 = rand(0, 9) . "-"
        . rand(10000000000, 9999999999) . "-"
        . rand(10000000000, 9999999999) . "=:"
        . rand(10000, 99999);
$boundary2 = rand(0, 9) . "-" . rand(10000000000, 9999999999) . "-"
        . rand(10000000000, 9999999999) . "=:"
        . rand(10000, 99999);

$TextMessage='ola';

$Headers = <<<AKAM
From: $FromName <$FromEmail>
Reply-To: $FromEmail
MIME-Version: 1.0
Content-Type: multipart/mixed;
    boundary="$boundary1"
AKAM;
$attachments.=<<<ATTA
--$boundary1
Content-Type: application/pdf; name="attacment.pdf"
Content-Transfer-Encoding: base64         
Content-Disposition: attachment; filename="attacment.pdf";    
        
$encoded_content

ATTA;
#---->BODY Part
$Body = <<<AKAM
This is a multi-part message in MIME format.

--$boundary1
Content-Type: multipart/alternative;
    boundary="$boundary2"

--$boundary2
Content-Type: text/plain;
    charset="utf8"
Content-Transfer-Encoding: quoted-printable

$TextMessage
        
--$boundary2
Content-Type: text/html;
    charset="windows-1256"
Content-Transfer-Encoding: quoted-printable

$HTMLMessage

--$boundary2--

$attachments
--$boundary1--
AKAM;

if (mail("sn.nazinyan@gmail.com", "Monitis task activation email", $Body, $Headers))
    echo "send";
else
    echo "no";
?>
