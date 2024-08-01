<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Ensure all required session variables are set
$required_session_keys = ['booking_id', 'room_type', 'cost', 'total_cost','room_count','no_of_days','payment_method', 'username'];
foreach ($required_session_keys as $key) {
    if (!isset($_SESSION[$key])) {
        header("Location: payment.php");
        exit();
    }
}

$bookingId = $_SESSION['booking_id'];
$room = $_SESSION['room_type'];
$amt = $_SESSION['cost'];
$amount = $_SESSION['total_cost'];
$paymentMethod = $_SESSION['payment_method'];
$username = $_SESSION['username'];
$roomCount = $_SESSION['room_count'];
$noOfDays = $_SESSION['no_of_days'];


require_once(__DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php');


class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, 'INVOICE', 0, true, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aranya Soukhya');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Payment Invoice');
$pdf->SetKeywords('TCPDF, PDF, invoice, test, guide');

// set default header data
$pdf->SetHeaderData('', '', '', '');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('helvetica', '', 12);

// Add first page (Invoice Header and Info)
$pdf->AddPage();

$html = <<<EOD
<style>
    .invoice-box {
        max-width: 800px;
        margin: 30px auto;
        padding: 30px;
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        color: #333;
    }
    .invoice-box h1, .invoice-box h2, .invoice-box h3, .invoice-box p {
        margin: 0;
    }
    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .invoice-header h1 {
        font-size: 36px;
        color: #333;
    }
    .invoice-info {
        margin-bottom: 40px;
    }
    .invoice-info div {
        margin-bottom: 10px;
    }
    .invoice-info div span {
        display: inline-block;
        min-width: 150px;
        font-weight: bold;
    }
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    .invoice-table th, .invoice-table td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    .invoice-table th {
        background-color: #f7f7f7;
        font-weight: bold;
    }
    .invoice-footer {
        text-align: center;
        font-size: 12px;
        color: #777;
        margin-top: 30px;
    }
    .invoice-footer .signature {
        display: inline-block;
        margin-top: 30px;
        width: 200px;
        border-top: 1px solid #ddd;
    }
    .invoice-footer p {
        margin: 5px 0;
    }
</style>
<div class="invoice-box">
    <div class="invoice-header">
        <img src="images/snowpal.png" style="width:100px;height:100px;">
    </div>
    <div class="invoice-info">
        <div>
            <span>BILL TO:</span> {$username}
        </div>
        <div>
            <span>Booking ID:</span> {$bookingId}
        </div>
        <div>
            <span>FROM:</span> Aranya Soukhya<br>
        </div>
        <div>
            <span>Invoice No:</span> {$bookingId}
        </div>
    </div>
</div>
<table class="invoice-table">
    <tr>
        <th>Rooms</th>
        <th>Room Count</th>
        <th>Days</th>
        <th>Cost Per Night</th>
        <th>Payment Method</th>
    </tr>
    <tr>
        <td>{$room}</td>
        <td>{$roomCount}</td>
        <td>{$noOfDays}</td>
        <td>RS.{$amt}</td>
        <td>{$paymentMethod}</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:right;">Total amount</td>
        <td>RS.{$amount}</td>
    </tr>
</table>
<div class="invoice-footer">
    <div class="signature"></div>
    <p>Signature</p>
    <p>Thank you!</p>
    <p>www.aranyasoukhya.com</p>
</div>
EOD;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('invoice.pdf', 'D'); // Force download
?>
