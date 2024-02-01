<?php

namespace App\Console\Commands;
use DB;
use PDF;
use MYSQLI;
use Session;
use Illuminate\Http\Request;
require 'C:\wamp64\www\sbadminex\vendor\autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Console\Command;

class SendItemEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:itememail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $spreadsheet = new Spreadsheet();
              $sheet = $spreadsheet->getActiveSheet();
              $cat_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_CAT_ITEMS order by item_id");
              $cat_item_list_ar=json_decode(json_encode($cat_item_list), true);
              $sheet->setCellValue('A1', "SR.NO.");
              $sheet->setCellValue('B1',"Item ID");
              $sheet->setCellValue('C1',"Item Name");
              $sheet->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($cat_item_list_ar as $id => $itemList)  {
              $item_id=$cat_item_list_ar[$i]['item_id'];
              $item_name=$cat_item_list_ar[$i]['item_name'];
              $item_charge_code=$cat_item_list_ar[$i]['charge_code'];
              $sheet->setCellValue('A' . $j, $i+1);
              $sheet->setCellValue('B' . $j, $item_id);
              $sheet->setCellValue('C' . $j, $item_name);
              $sheet->setCellValue('D' . $j, $item_charge_code);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet);
              $cat_item_excel_path="C:\wamp64\www\sbadminex\public\Item_List_Excel\Catering_Items_".date('d-M-Y-H-i-s').".xlsx";
              $writer->save($cat_item_excel_path);

              $spreadsheet_pms = new Spreadsheet();
              $sheet_pms = $spreadsheet_pms->getActiveSheet();
              $pms_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_PMS_ITEMS order by item_id");
              $pms_item_list_ar=json_decode(json_encode($pms_item_list), true);
              $sheet_pms->setCellValue('A1', "SR.NO.");
              $sheet_pms->setCellValue('B1',"Item ID");
              $sheet_pms->setCellValue('C1',"Item Name");
              $sheet_pms->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($pms_item_list_ar as $id => $itemList)  {
              $item_id_pms=$pms_item_list_ar[$i]['item_id'];
              $item_name_pms=$pms_item_list_ar[$i]['item_name'];
              $item_charge_code_pms=$pms_item_list_ar[$i]['charge_code'];
              $sheet_pms->setCellValue('A' . $j, $i+1);
              $sheet_pms->setCellValue('B' . $j, $item_id_pms);
              $sheet_pms->setCellValue('C' . $j, $item_name_pms);
              $sheet_pms->setCellValue('D' . $j, $item_charge_code_pms);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet_pms);
              $pms_item_excel_path="C:\wamp64\www\sbadminex\public\Item_List_Excel\PMS_Items_".date('d-M-Y-H-i-s').".xlsx";
              $writer->save($pms_item_excel_path);

              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "kingranchum";
              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
              $sql1 = "SELECT * from emailsetup";
              $verifyResult = $conn->query($sql1);

              $mail = new PHPMailer();


              $mail->IsSMTP();
             // $mail->SMTPDebug=1;
              $mail->Mailer = "smtp";
              $mail->SMTPAuth = true;
              $mail->SMTPSecure = "tls";
              $mail->Port = 587;
              $mail->Host = "smtp.office365.com";
              $mail->Username = "rsdashboard@king-ranch.com";
              $mail->Password = "kptnrgwfnwmxzkhs";
              $mail->IsHTML(true);
              $mail->From = "rsdashboard@king-ranch.com";
              $mail->FromName = "King-Ranch (Resort Suite)";
              $mail->Subject = "Catering & PMS Items";
              $mail->addAttachment($pms_item_excel_path);
              $mail->addAttachment($cat_item_excel_path);
              $msg="<p>Hello,</p>
              Please find the attached sheet of Catering Items and PMS Items.<br>
              <p style='color: red'>Note: Please do not reply to this message. This is a unmonitored Mailbox.</p>";
              $mail->MsgHTML($msg);
              if ($verifyResult->num_rows > 0) {
             while($fetched_row = $verifyResult->fetch_assoc()){
              $to_email_id_variable=$fetched_row['UserEmail'];

            //   0.echo $fetched_row['UserEmail'];
              $mail->addAddress($to_email_id_variable);

             }
            }

             if (!$mail->send()) {
              echo "error";
              }
    }
}
