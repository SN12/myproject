<?php

function verification_mail($email, $activation_code, $name) {
    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset: utf8\r\n";
    $header.="From: monitistask@gmail.com";
    $body = "<p style='font-size:12px;'>Dear <span style='font-style:italic;'>{$name}</span></p>
        <p>
You have received this email because your account has been added to the contacts list in " . DOMAIN . " 
Please, click on the following link to activate your account.</p>
<a href='" . DOMAIN . "/activate.php?mail={$email}&key={$activation_code}'>" . DOMAIN . "/activate.php?mail={$email}&key={$activation_code}</a>";

    if (mail($email, "Monitis task activation email", $body, $header))
        return true;
    return false;
}

function create_csv($data, $fields, $subject) {
//    exit('try to create a pdf file');
    $csv_folder = ROOTFOLDER . '/files/csv';
    $filename = "attachment";
    $CSVFilePath = $csv_folder . '/' . $filename . '.csv';
    $FileHandle = fopen($CSVFilePath, 'w') or die("can't open file");
    fclose($FileHandle);
    if (!( $fp = fopen($CSVFilePath, 'w') ))
        return false;
    $csv_fields = array();
    $csv_fields[0]['A'] = $fields[0];
    $csv_fields[0]['B'] = $fields[1];
    $i = 1;
    foreach ($data as $row):
        $csv_fields[$i]['A'] = $row['datetime'];
        $csv_fields[$i]['B'] = $row['event_desc'];
        $i++;
    endforeach;
    foreach ($csv_fields as $fields) {
        if (!( fputcsv($fp, $fields) ))
            return false;
    }
    fclose($fp);
    return true;
}

function create_pdf($array, $fields, $title) {

    require(ROOTFOLDER . '/lib/fpdf/fpdf.php' );
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image(ROOTFOLDER . '/images/logo.png', 5, 5, 33);

    $pdf->SetXY(40, 15);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFont('', 'B', '24');
    $pdf->Cell(40, 10, $title, 15);
    $pdf->Ln();

    $pdf->SetXY(10, 45);

    $pdf->SetFont('', 'B', '10');
    $pdf->SetFillColor(128, 128, 128);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(92, 92, 92);
    $pdf->SetLineWidth(.3);

    $pdf->Cell(70, 7, $fields[0], 1, 0, 'C', true);
    $pdf->Cell(120, 7, $fields[1], 1, 0, 'C', true);
    $pdf->Ln();
    $pdf->SetFillColor(224, 235, 255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');

    $col_widths = array(70, 100);

    foreach ($array as $event) {

        $x = $pdf->GetX();

        $yBeforeCell = $pdf->GetY();
        $h1 = $pdf->GetMultiCellHeight(70, 10, $event['datetime']);
        $h2 = $pdf->GetMultiCellHeight(120, 10, $event['event_desc']);
        $height = ($h1 > $h2) ? $h1 : $h2;
        $pdf->MultiCell(70, $height, $event['datetime'], 'LB', 'C');
        $yCurrent = $pdf->GetY();
        $rowHeight = $yCurrent - $yBeforeCell;
        $pdf->SetXY($x + 70, $yCurrent - $rowHeight);
        $x = $pdf->GetX();
        $pdf->MultiCell(120, 10, $event['event_desc'], 'LBR');
    }
    if ($pdf->Output(ROOTFOLDER . '/files/pdf/attachment.pdf') == '') {
        return $pdf->Output("", "S");
    }
    return false;
}

function sendMailWithAttachment($mails, $data, $subject, $text) {

    $HTMLMessage = "<p style='font-size:12px;'>Dear <span style='font-style:italic;'>partner</span></p>
        <p>{$text}</p>";
    $filename = "attacment.pdf";
//$filename= "/".ROOTFOLDER . "/files/pdf/attacment.pdf";
    $file = fopen($filename, "r");
    $size = filesize($filename);
    $content = fread($file, $size);
    fclose($file);
//$filename="attacment.pdf";  
# encode the data for safe transit
# and insert \r\n after every 76 chars.
//$encoded_content = chunk_split(base64_encode(file_get_contents($filename)));

    $encoded_content = chunk_split(base64_encode($data));
    $FromName = 'Monitis Task';
    $FromEmail = 'monitistask@gmail.com';


    $boundary1 = rand(0, 9) . "-"
            . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);
    $boundary2 = rand(0, 9) . "-" . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);

    $TextMessage = 'ola';

    $Headers = <<<AKAM
From: $FromName <$FromEmail>
Reply-To: $FromEmail
MIME-Version: 1.0
Content-Type: multipart/mixed; boundary="$boundary1"
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
--$boundary1
Content-Type: text/html; charset="windows-1256"
Content-Transfer-Encoding: quoted-printable

$HTMLMessage
        
        
$attachments
--$boundary2--
AKAM;
    if (mail($mails, $subject, $Body, $Headers))
        echo "send";
    else
        echo "no";
}

?>
