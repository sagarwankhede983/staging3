<?php
namespace App\Http\Controllers;

use MYSQLI;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailOnUserRegistration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use PhpParser\Node\Const_;
use Psy\Exception\FatalErrorException;
use SebastianBergmann\Environment\Console;

class UserManagmentController extends Controller
{
    //
    public function addNewUserPage()
    {
        $this->validateUser();
        // dd($response);
        $todayDate = date('m-d-Y');
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * from ROLES";
        $role = $conn->query($sql);
        $roles[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $roles[$i] = $row;
                $i = $i + 1;
            }
            $conn->close();
            $email_error = "";
            $namef = "";
            $emailf = "";
            return view('admin.users.create', compact('roles', 'email_error', 'namef', 'emailf', 'todayDate'));
        } else {
        }
        $conn->close();
    }
    public function addNewUser(Request $request)
    {
        $this->validateUser();
        $alertmeassage = "";
        $todayDate = date('m-d-Y');
        $namef = $request['name'];
        $emailf = $request['email'];
        $passwordf = encrypt($request['password']);
        $rolef = $request['role'];
        $subrolef = $request['subrole'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql_check_mail = "SELECT * FROM USERS WHERE EMAIL='$emailf';";
        $role_check_mail = $conn->query($sql_check_mail);
        if ($role_check_mail->num_rows > 0) {
            $email_error = "Email already exists";
            $sql = "SELECT * from ROLES";
            $role = $conn->query($sql);
            $roles[] = "";
            if ($role->num_rows > 0) {
                $i = 0;
                while ($row = $role->fetch_assoc()) {
                    $roles[$i] = $row;
                    $i = $i + 1;
                }
            }
            $conn->close();
            return view('admin.users.create', compact('roles', 'email_error', 'namef', 'emailf', 'todayDate'));
        } else {
            if (!empty($request['toggle'])) {
                $sql = "INSERT INTO USERS (NAME, EMAIL, PASSWORD,ROLE,FIRST_TIME_FLAG,SUBROLE) VALUES ('$namef', '$emailf', '$passwordf','$rolef','N','$subrolef');";
            } else {
                $sql = "INSERT INTO USERS (NAME, EMAIL, PASSWORD,ROLE,FIRST_TIME_FLAG,SUBROLE) VALUES ('$namef', '$emailf', '$passwordf','$rolef','Y','$subrolef');";
            }

            $role = $conn->query($sql);
            //dd("hi");
            if (!empty($role)) {
                $sql = "SELECT * from ROLES";
                $role = $conn->query($sql);
                $roles[] = "";
                if ($role->num_rows > 0) {
                    $i = 0;
                    while ($row = $role->fetch_assoc()) {
                        $roles[$i] = $row;
                        $i = $i + 1;
                    }
                    //code to send email with link
                    $password_decrypt = decrypt($passwordf);
                    //   $data=array(
                    //     'name'=>'$namef','email'=>$emailf,'password'=>$password_decrypt,'role'=>$rolef);

                    //      Mail::to($emailf)->send(new SendMailOnUserRegistration($data));


                    $mail = new PHPMailer();
                    $link = 'http://rsdashboard.king-ranch.com/login';
                    $nameA= strtok($namef, " ");
                    $msg = "<p>Hi ".$nameA.",</p>
                    <p>Welcome to Resort Suite Dashboard</p>
<p>Here is the login details for your account.</p>
<p>Username :" . $emailf . " </p>
<p>Password :" . $password_decrypt . "</p>
<p>To access the dashboard<a href=" . $link . "> please click here</a></p>
<p style='color: red'>Note:Please use Google Chrome, Firefox or Microsoft Edge for best experience</p>
<p style='color: red'>Note: Please do not reply to this message. This is a unmonitored Mailbox.</p>";

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
                    $mail->Subject = "Welcome to King-Ranch Resort Suite";
                    $mail->MsgHTML($msg);
                    $mail->addAddress($emailf);

                    if (!$mail->send()) {
                        //   echo "error";
                        // Change on 16-05-2023

                        $sql = "SELECT ID FROM USERS WHERE EMAIL='$emailf'";
                        $id = $conn->query($sql);
                        $row = $id->fetch_assoc();
                        $uid = $row['ID'];
                        $sql = "DELETE FROM USERS WHERE ID='$uid';";
                        $role = $conn->query($sql);
                        $alertmeassage = "Sorry! Something Went wrong! please try again!";
                    } else {
                        $alertmeassage = "Email has been sent successfully.";
                    }

                    //
                    //return view('admin.users.create',compact('roles'));
                    $sql = "SELECT * from USERS";
                    $role = $conn->query($sql);
                    $users[] = "";
                    if ($role->num_rows > 0) {
                        $i = 0;
                        while ($row = $role->fetch_assoc()) {
                            $users[$i] = $row;
                            $i = $i + 1;
                        }
                        $conn->close();
                        return view('admin.users.index2', compact('users', 'alertmeassage', 'todayDate'));
                    } else {
                    }
                    $conn->close();
                } else {
                }
            } else {
                $conn->close();
            }
        }
    }
    public function editUserPage()
    {
        $this->validateUser();
        $todayDate = date('m-d-Y');
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * from USERS";
        $role = $conn->query($sql);
        $users[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $users[$i] = $row;
                $i = $i + 1;
            }
            $conn->close();
            $alertmeassage="";
            return view('admin.users.index', compact('users','alertmeassage','todayDate'));
        } else {
        }
        $conn->close();
    }
    public function editUserById(Request $request)
    {
        $this->validateUser();
        $todayDate = date('m-d-Y');
        $uid = base64_decode($request['user_id']);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * from ROLES";
        $role = $conn->query($sql);
        $roles[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $roles[$i] = $row;
                $i = $i + 1;
            }
            $sql2 = "SELECT * from USERS WHERE ID='$uid'";
            $user2 = $conn->query($sql2);
            $usersarray[] = "";
            if ($user2->num_rows > 0) {
                $row2 = $user2->fetch_assoc();

                $row2['PASSWORD'] = decrypt($row2['PASSWORD']);
                $usersarray[0] = $row2;
                $conn->close();
                $subroles= array('Catering','Hunting-Reservation');
                // dd($usersarray);
                return view('admin.users.edit', compact('roles', 'subroles','usersarray', 'uid', 'todayDate'));
            } else {
            }
            $conn->close();
        }
    }
    public function updateUserInfo(Request $request)
    {
        $todayDate = date('m-d-Y');
        $uid = $request['uid'];
        $name = $request['name'];
        $email = $request['email'];
        $passwordchange = encrypt($request['passwordchange']);
        $role = $request['role'];
        $sub_role = $request['subrole'];
        $roletochange = $request['roletochange'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        ////
        $password_decrypt = decrypt($passwordchange);
        $mail = new PHPMailer();
        $link = 'http://rsdashboard.king-ranch.com/login';
        $namef=strtok($name, " ");
                $msg = "<p>Hi ".$namef.",</p>
        <p>There is some changes made by Admin with your RS-Dashboard profile.
        Below are the updated credentials:</p>
        <p>Username :" . $email . " </p>
        <p>Password :" . $password_decrypt. "</p>
        <p>If you have any query, Please contact to your RS-Dashboard Admin.</p>
        <p>To access the dashboard<a href=" . $link . "> please click here</a></p>
        <p style='color: red'>Note:Please use Google Chrome, Firefox or Microsoft Edge for best experience</p>
        <p style='color: red'>Note: Please do not reply to this message. This is a unmonitored Mailbox.</p>";

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
        $mail->Subject = "Welcome to King-Ranch Resort Suite";
        $mail->MsgHTML($msg);
        $mail->addAddress($email);

        if (!$mail->send()) {
            //   echo "error";
            // Change on 16-05-2023
            $sql = "SELECT ID FROM USERS WHERE EMAIL='$email'";
            $id = $conn->query($sql);
            $row = $id->fetch_assoc();
            $uid = $row['ID'];
            $sql = "DELETE FROM USERS WHERE ID='$uid';";
            $role = $conn->query($sql);
            $alertmeassage = "Sorry! Something Went wrong! please try again!";
        } else {
            $alertmeassage = "Email has been sent successfully.";
        }
        ////

        if ($roletochange == 'Super Admin') {
            if (!empty($request['toggle'])) {
                $sql = "UPDATE USERS SET NAME = '$name', EMAIL= '$email',PASSWORD = '$passwordchange', ROLE= '$role',FIRST_TIME_FLAG='N', SUBROLE='$sub_role' WHERE ID = $uid;";
            } else {
                $sql = "UPDATE USERS SET NAME = '$name', EMAIL= '$email',PASSWORD = '$passwordchange', ROLE= '$role',SUBROLE='$sub_role' WHERE ID = $uid;";
            }
        } else {
            $sql = "UPDATE USERS SET NAME = '$name', EMAIL= '$email',ROLE= '$role' WHERE ID = $uid;";
        }
        $update = $conn->query($sql);
        $sql = "SELECT * from USERS";
        $role = $conn->query($sql);
        $users[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $users[$i] = $row;
                $i = $i + 1;
            }
            $conn->close();
            return view('admin.users.index', compact('users','alertmeassage','todayDate'));
        } else {
        }

        $conn->close();
    }
    public function deleteUserInfo(Request $request)
    {
        $this->validateUser();
        $todayDate = date('m-d-Y');
        $uid = base64_decode($request['uid']);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM USERS WHERE ID='$uid';";
        $delete = $conn->query($sql);
        $sql = "SELECT * from USERS";
        $role = $conn->query($sql);
        $users[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $users[$i] = $row;
                $i = $i + 1;
            }
            $conn->close();
            $alertmeassage="";
            return view('admin.users.index', compact('users','alertmeassage','todayDate'));
        } else {
        }

        $conn->close();
    }
    public function viewAllUserList()
    {
        $this->validateUser();
        $todayDate = date('m-d-Y');
        $alertmeassage = "";
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * from USERS";
        $role = $conn->query($sql);
        $users[] = "";
        if ($role->num_rows > 0) {
            $i = 0;
            while ($row = $role->fetch_assoc()) {
                $users[$i] = $row;
                $i = $i + 1;
            }
            $conn->close();
            return view('admin.users.index2', compact('users', 'alertmeassage', 'todayDate'));
        } else {
        }
        $conn->close();
    } //01/09/2021
    public function getCustomersComparedResult()
    {
        $todayDate = date('m-d-Y');
        $resort_suit_customers = DB::Select("Select vc.customer_id, vc.first_name,vc.last_name,vc.name,vc.customer_code from dev.vr_customers vc where vc.customer_code is null");
        ///ccccccc
        $i = 0;
        $resort_suit_customers_ar = json_decode(json_encode($resort_suit_customers), true);

        $curl = curl_init();
        foreach ($resort_suit_customers_ar as $id => $data) {
            $cust_id_rs = $resort_suit_customers_ar[$i]['customer_code'];
            if (empty($cust_id_rs)) {
                $resort_suit_customers_ar[$i]['customer_code'] = "Not Available";
            }
            /*
				This is JDE REST call from php using curl() Working fine
				All about to get AN8 and Alph from F0101 in JDE
				$cust_id_rs=$resort_suit_customers_ar[$i]['customer_code'];
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://aisdv.king-ranch.com/jderest/v2/dataservice/table/F0101?$field=F0101.AN8&%24field=F0101.ALPH&%24filter=F0101.AN8%20EQ%20'.$cust_id_rs,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
				'Authorization: Basic U0hSRVlBU1k6UGFzc3dvcmQx',
				),
				));
				$response = curl_exec($curl);
				$ar = json_decode($response,true);
				//dd($ar["fs_DATABROWSE_F0101"]["data"]["gridData"]["rowset"]);
				if(empty($ar["fs_DATABROWSE_F0101"]["data"]["gridData"]["rowset"])){
				$resort_suit_customers_ar[$i]['jde_cust_id_an8']="NA";
				$resort_suit_customers_ar[$i]['jde_cust_name_alph']="NA";
				}else{
				$resort_suit_customers_ar[$i]['jde_cust_id_an8']=$ar["fs_DATABROWSE_F0101"]["data"]["gridData"]["rowset"][0]["F0101_AN8"];
				$resort_suit_customers_ar[$i]['jde_cust_name_alph']=$ar["fs_DATABROWSE_F0101"]["data"]["gridData"]["rowset"][0]["F0101_ALPH"];
				}
				*/
            $i = $i + 1;
        }
        curl_close($curl);
        return view('onRequestCustomerDetails.customerMissmatchJDE', compact('todayDate', 'resort_suit_customers_ar'));
    }

    public function getNoNightsInPMSSalesBlankPage()
    {
        $todayDate = date('m-d-Y');
        $toDatefromController = "";
        $fromDatefromController = "";
        $customerIdFilter = 0;
        $rateTypeFilter = "All";
        $resort_suit_customers_pms_no_nights_ar = "";
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);
        $rate_type_list = DB::Select("Select distinct(rate_type) as rate_type from dev.VR_PMS_RATE");
        $rate_type_list_ar = json_decode(json_encode($rate_type_list), true);
        return view('onRequestCustomerDetails.pmsRoomsReservationNoNights', compact('todayDate', 'resort_suit_customers_pms_no_nights_ar', 'toDatefromController', 'fromDatefromController', 'listOutCustomers_ar', 'rate_type_list_ar', 'customerIdFilter', 'rateTypeFilter'));
    }
    public function getNoNightsInPMSSalesonSubmit(Request $request)
    {
        $todayDate = date('m-d-Y');
        $toDatefromController = $request['todate'];
        $fromDatefromController = $request['fromdate'];
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_todate = explode('-', $request['todate']);
        $convertedToDate = $parts_todate[1] . '-' . $parts_todate[0] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', $request['fromdate']);
        $convertedFromDate = $parts_fromDate[1] . '-' . $parts_fromDate[0] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // DB::enableQueryLog();
        $rateTypeFilter = $request['selected_rate_type_from_select'];
        $customerIdFilter = $request['selected_customer_id_from_select'];
        $join_rateTyoeFilter = " ";
        if ($rateTypeFilter == "All") {
            $join_rateTyoeFilter = " where ";
        } else {
            $join_rateTyoeFilter = "inner join dev.vr_pms_rate p on p.pms_rate_id=vps.pms_rate_id where p.rate_type='$rateTypeFilter' and";
        }
        $join_customerIdFilter = " ";
        if ($customerIdFilter == "0") {
            $join_customerIdFilter = " ";
        } else {
            $join_customerIdFilter = " vc.customer_id='$customerIdFilter' and ";
        }
        $final_query = "Select vc.customer_id,vps.folio_customer_id,vc.name,sum(vps.num_nights) as no_night from DEV.vr_customers vc inner join dev.VR_PMS_SALES vps on vc.Customer_id=vps.folio_customer_id " . $join_rateTyoeFilter . $join_customerIdFilter . " vps.num_nights>0 and (vps.arrival_date>='$tempFrom' and vps.arrival_date<='$tempTo' or vps.departure_date>='$tempFrom' and vps.departure_date<='$tempTo') group by vc.customer_id,vc.name,vps.folio_customer_id order by vc.customer_id";
        $resort_suit_customers_pms_no_nights = DB::Select($final_query);

        $resort_suit_customers_pms_no_nights_ar = json_decode(json_encode($resort_suit_customers_pms_no_nights), true);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);

        $rate_type_list = DB::Select("Select distinct(rate_type) as rate_type from dev.VR_PMS_RATE");
        $rate_type_list_ar = json_decode(json_encode($rate_type_list), true);
        return view('onRequestCustomerDetails.pmsRoomsReservationNoNights', compact('todayDate', 'resort_suit_customers_pms_no_nights_ar', 'toDatefromController', 'fromDatefromController', 'listOutCustomers_ar', 'rate_type_list_ar', 'customerIdFilter', 'rateTypeFilter'));
    }
    public function getPMSRoomBookingDetails(Request $request)
    {
        $todayDate = date('m-d-Y');
        $rateTypeFilter = base64_decode($request['rateTypeFilter']);
        $folio_customer_id = base64_decode($request['folio_customer_id']);
        $fromDateFromPMSCustPage = base64_decode($request['fromDateFromPMSCustPage']);
        $toDateFromPMSCustPage = base64_decode($request['toDateFromPMSCustPage']);
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_todate = explode('-', base64_decode($request['toDateFromPMSCustPage']));
        $convertedToDate = $parts_todate[1] . '-' . $parts_todate[0] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', base64_decode($request['fromDateFromPMSCustPage']));
        $convertedFromDate = $parts_fromDate[1] . '-' . $parts_fromDate[0] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));

        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END
        $join_rateTyoeFilter = " ";
        if ($rateTypeFilter == "All") {
            $join_rateTyoeFilter = " where ";
        } else {
            $join_rateTyoeFilter = "inner join dev.vr_pms_rate p on p.pms_rate_id=vps.pms_rate_id where p.rate_type='$rateTypeFilter' and";
        }
        $finalQuery = "Select TO_CHAR(vps.checkin_date,'MM-DD-YYYY') as checkin_date,TO_CHAR(vps.checkout_date,'MM-DD-YYYY') as checkout_date,TO_CHAR(vps.arrival_date,'MM-DD-YYYY') as arrival_date,TO_CHAR(vps.departure_date,'MM-DD-YYYY') as departure_date,vps.num_nights,vps.room_number,vps.room_type,vps.folio_id,vps.folio_status from dev.VR_PMS_SALES vps " . $join_rateTyoeFilter . " vps.folio_customer_id='$folio_customer_id' and  vps.num_nights>0 and (vps.arrival_date>='$tempFrom' and vps.arrival_date<='$tempTo' or vps.departure_date>='$tempFrom' and vps.departure_date<='$tempTo')";
        $pms_room_reservation_against_customer = DB::Select($finalQuery);
        $pms_room_reservation_against_customer_ar = json_decode(json_encode($pms_room_reservation_against_customer), true);
        $index_app_first_item = 0;
        foreach ($pms_room_reservation_against_customer_ar as $id => $data) {
            $folio_id_temp = $pms_room_reservation_against_customer_ar[$index_app_first_item]['folio_id'];
            $rate_type_result = DB::Select("Select distinct(pfdr.pms_folio_id),pr.rate_type from dev.vr_pms_rate pr inner join dev.vr_pms_folio_day_rate pfdr on pr.pms_rate_id=pfdr.pms_rate_id where pfdr.pms_folio_id='$folio_id_temp'");
            $rate_type_result_ar = json_decode(json_encode($rate_type_result), true);
            if (empty($rate_type_result_ar)) {
                $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = 'NA';
            } else {
                if ($rate_type_result_ar[0]['rate_type'] == "") {
                    $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = 'NA';
                } else {
                    $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = $rate_type_result_ar[0]['rate_type'];
                }
            }
            $index_app_first_item = $index_app_first_item + 1;
        }

        return view('onRequestCustomerDetails.pmsRoomReservationDetailByCstomer', compact('todayDate', 'pms_room_reservation_against_customer_ar'));
    }
    public function pmsRoomReservationOnCalendar()
    {
        $todayDate = date('m-d-Y');
        $customerIdFilter = "0";
        $rateTypeFilter = "All";
        $cust_id = 0;

        $data = DB::Select("select TO_CHAR(ps.arrival_date,'DD-MM-YYYY') as arrival_date, TO_CHAR(ps.departure_date,'DD-MM-YYYY') as departure_date, sum(ps.num_nights) as no_night from dev.vr_pms_sales ps where ps.num_nights>0 and ps.folio_customer_id='$cust_id' and (ps.arrival_date is not null and ps.departure_date is not null) group by arrival_date,departure_date");
        $data_ar = json_decode(json_encode($data), true);
        $i = 0;
        $events = [];
        $color = '';
        foreach ($data_ar as $id => $eventcount) {
            $item_count = $data_ar[$i]['no_night'];
            $start_datetime = $data_ar[$i]['arrival_date'];
            $end_datetime = $data_ar[$i]['departure_date'];
            switch ($item_count) {
                case "1":
                    $color = '#FFA500';
                    break;
                case "3":
                    $color = '#FFCC66';
                    break;
                case "5":
                    $color = '#FF0000';
                    break;
                case "43":
                    $color = '#F0FFFF';
                    break;
                case "7":
                    $color = '#660099';
                    break;
                case "8":
                    $color = '#FFFF00';
                    break;
                case "11":
                    $color = '#FFFFFF';
                    break;
                case "45":
                    $color = '#48D1CC';
                    break;
                case "13":
                    $color = '#00FFFF';
                    break;
                case "15":
                    $color = '#FFB6C1';
                    break;
                case "17":
                    $color = '#FF7F50';
                    break;
                case "19":
                    $color = '#FFA500';
                    break;
                case "21":
                    $color = '#33CCFF';
                    break;
                case "23":
                    $color = '#32CD32';
                    break;
                case "25":
                    $color = '#CCFFFF';
                    break;
                case "27":
                    $color = '#00FA99';
                    break;
                case "29":
                    $color = '#0000FF';
                    break;
                case "31":
                    $color = '#00FA9A';
                    break;
                case "33":
                    $color = '#F0E68C';
                    break;
                case "35":
                    $color = '#FF8C00';
                    break;
                case "37":
                    $color = '#FFFF00';
                    break;
                case "39":
                    $color = '#9370DB';
                    break;
                case "41":
                    $color = '#B0E0E6';
                    break;
                default:
                    $color = '#48D1CC';
            }
            $itemc = $item_count;
            if (empty($itemc)) {
                $itemc = 0;
            }
            $events[] = Calendar::event(
                "Night:$itemc",

                true,
                new \DateTime($start_datetime),
                new \DateTime($end_datetime . '+0 day'),
                null,
                // Add color
                [
                    'color' => "$color",
                    'textColor' => '#0e0f0e',
                    'url' => "/pmsRoomReservationFromCalendar/".base64_encode($start_datetime)."/".base64_encode($end_datetime)."/".base64_encode($cust_id)."/".base64_encode($rateTypeFilter),
                ]
            );
            $i++;
        }
        $calendar = Calendar::addEvents($events);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);

        $rate_type_list = DB::Select("Select distinct(rate_type) as rate_type from dev.VR_PMS_RATE");
        $rate_type_list_ar = json_decode(json_encode($rate_type_list), true);

        return view('onRequestCustomerDetails.pmsRoomsServationOnCalendar', compact('calendar', 'todayDate', 'listOutCustomers_ar', 'cust_id', 'rate_type_list_ar', 'customerIdFilter', 'rateTypeFilter'));
    }
    public function pmsRoomReservationOnCalendarByCustomerOption(Request $request)
    {

        $todayDate = date('m-d-Y');

        $customerIdFilter = "";
        $rateTypeFilter = "";
        $cust_id = base64_encode($request['customerIdFilter']);
        $customerIdFilter = base64_encode($request['customerIdFilter']);
        $rateTypeFilter = base64_encode($request['rateTypeFilter']);
        $join_rateTyoeFilter = " ";
        if ($rateTypeFilter == "All") {
            $join_rateTyoeFilter = " where ";
        } else {
            $join_rateTyoeFilter = " inner join dev.vr_pms_rate p on p.pms_rate_id=ps.pms_rate_id where p.rate_type='$rateTypeFilter' and ";
        }
        $final_query = "select TO_CHAR(ps.arrival_date,'DD-MM-YYYY') as arrival_date, TO_CHAR(ps.departure_date,'DD-MM-YYYY') as departure_date, sum(ps.num_nights) as no_night from dev.vr_pms_sales ps " . $join_rateTyoeFilter . " ps.num_nights>0 and ps.folio_customer_id='$cust_id' and (ps.arrival_date is not null and ps.departure_date is not null) group by arrival_date,departure_date";
        $data = DB::Select($final_query);
        $data_ar = json_decode(json_encode($data), true);
        $i = 0;
        $events = [];
        $color = '';
        foreach ($data_ar as $id => $eventcount) {
            $item_count = $data_ar[$i]['no_night'];
            $start_datetime = $data_ar[$i]['arrival_date'];
            $end_datetime = $data_ar[$i]['departure_date'];
            switch ($item_count) {
                case "1":
                    $color = '#FFA500';
                    break;
                case "3":
                    $color = '#FFCC66';
                    break;
                case "5":
                    $color = '#FF0000';
                    break;
                case "43":
                    $color = '#F0FFFF';
                    break;
                case "7":
                    $color = '#660099';
                    break;
                case "8":
                    $color = '#FFFF00';
                    break;
                case "11":
                    $color = '#FFFFFF';
                    break;
                case "45":
                    $color = '#48D1CC';
                    break;
                case "13":
                    $color = '#00FFFF';
                    break;
                case "15":
                    $color = '#FFB6C1';
                    break;
                case "17":
                    $color = '#FF7F50';
                    break;
                case "19":
                    $color = '#FFA500';
                    break;
                case "21":
                    $color = '#33CCFF';
                    break;
                case "23":
                    $color = '#32CD32';
                    break;
                case "25":
                    $color = '#CCFFFF';
                    break;
                case "27":
                    $color = '#00FA99';
                    break;
                case "29":
                    $color = '#0000FF';
                    break;
                case "31":
                    $color = '#00FA9A';
                    break;
                case "33":
                    $color = '#F0E68C';
                    break;
                case "35":
                    $color = '#FF8C00';
                    break;
                case "37":
                    $color = '#FFFF00';
                    break;
                case "39":
                    $color = '#9370DB';
                    break;
                case "41":
                    $color = '#B0E0E6';
                    break;
                default:
                    $color = '#48D1CC';
            }
            $itemc = $item_count;
            if (empty($itemc)) {
                $itemc = 0;
            }
            $events[] = Calendar::event(
                "Night:$itemc",

                true,
                new \DateTime($start_datetime),
                new \DateTime($end_datetime . '+0 day'),
                null,
                // Add color
                [
                    'color' => "$color",
                    'textColor' => '#0e0f0e',
                    'url' => "/pmsRoomReservationFromCalendar/".base64_encode($start_datetime)."/".base64_encode($end_datetime)."/".base64_encode($cust_id)."/".base64_encode($rateTypeFilter),
                ]
            );
            $i++;
        }
        $calendar = Calendar::addEvents($events);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);

        $rate_type_list = DB::Select("Select distinct(rate_type) as rate_type from dev.VR_PMS_RATE");
        $rate_type_list_ar = json_decode(json_encode($rate_type_list), true);

        return view('onRequestCustomerDetails.pmsRoomsServationOnCalendar', compact('calendar', 'todayDate', 'listOutCustomers_ar', 'cust_id', 'rate_type_list_ar', 'customerIdFilter', 'rateTypeFilter'));
    }
    public function pmsRoomReservationDetailOnCalendarClick(Request $request)
    {

        $todayDate = date('m-d-Y');
        $cust_id = base64_decode($request['cust_id']);
        $from_date = base64_decode($request['from_date']);
        $to_date = base64_decode($request['to_date']);
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_todate = explode('-', base64_decode($request['to_date']));
        $convertedToDate = $parts_todate[0] . '-' . $parts_todate[1] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', base64_decode($request['from_date']));
        $convertedFromDate = $parts_fromDate[0] . '-' . $parts_fromDate[1] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END

        $rateTypeFilter = base64_decode($request['rateTypeFilter']);
        $join_rateTyoeFilter = " ";
        if ($rateTypeFilter == "All") {
            $join_rateTyoeFilter = " where ";
        } else {
            $join_rateTyoeFilter = " inner join dev.vr_pms_rate p on p.pms_rate_id=ps.pms_rate_id where p.rate_type='$rateTypeFilter' and ";
        }
        $final_query = "Select TO_CHAR(ps.checkin_date,'MM-DD-YYYY') as checkin_date,TO_CHAR(checkout_date,'MM-DD-YYYY') as checkout_date,TO_CHAR(arrival_date,'MM-DD-YYYY') as arrival_date,TO_CHAR(ps.departure_date,'MM-DD-YYYY') as departure_date,ps.num_nights,ps.room_number,ps.room_type,ps.folio_id,ps.folio_status from dev.VR_PMS_SALES ps " . $join_rateTyoeFilter . " ps.folio_customer_id='$cust_id' and  ps.num_nights>0 and ps.arrival_date='$tempFrom' and ps.departure_date='$tempTo'";

        $pms_room_reservation_against_customer = DB::Select($final_query);
        $pms_room_reservation_against_customer_ar = json_decode(json_encode($pms_room_reservation_against_customer), true);
        $index_app_first_item = 0;
        foreach ($pms_room_reservation_against_customer_ar as $id => $data) {
            $folio_id_temp = $pms_room_reservation_against_customer_ar[$index_app_first_item]['folio_id'];
            $rate_type_result = DB::Select("Select distinct(pfdr.pms_folio_id),pr.rate_type from dev.vr_pms_rate pr inner join dev.vr_pms_folio_day_rate pfdr on pr.pms_rate_id=pfdr.pms_rate_id where pfdr.pms_folio_id='$folio_id_temp'");
            $rate_type_result_ar = json_decode(json_encode($rate_type_result), true);
            if (empty($rate_type_result_ar)) {
                $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = 'NA';
            } else {
                if ($rate_type_result_ar[0]['rate_type'] == "") {
                    $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = 'NA';
                } else {
                    $pms_room_reservation_against_customer_ar[$index_app_first_item]['rate_type'] = $rate_type_result_ar[0]['rate_type'];
                }
            }
            $index_app_first_item = $index_app_first_item + 1;
        }

        return view('onRequestCustomerDetails.pmsRoomReservationDetailByCstomer', compact('todayDate', 'pms_room_reservation_against_customer_ar'));
    }
    public function getNoNightsInCateringSalesBlankPage()
    {
        //111111111
        $todayDate = date('m-d-Y');
        $toDatefromController = "";
        $fromDatefromController = "";
        $customerIdFilter = 0;
        $eventTypeFilter = "All";
        $marketCodeFilter = "All";
        $resort_suit_customers_cat_no_nights_ar = "";
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);
        $event_type_list = DB::Select("select distinct(cat_event_type) from dev.vr_cat_event where cat_event_type!=' ' order by cat_event_type ASC");
        $event_type_list_ar = json_decode(json_encode($event_type_list), true);
        $market_code = DB::Select("Select distinct(vip_level) from dev.vr_customers where vip_level!=' ' order by vip_level ASC");
        $market_code_ar = json_decode(json_encode($market_code), true);

        return view('onRequestCustomerDetails.cateringRoomReservationNoNights', compact('todayDate', 'resort_suit_customers_cat_no_nights_ar', 'toDatefromController', 'fromDatefromController', 'listOutCustomers_ar', 'event_type_list_ar', 'market_code_ar', 'customerIdFilter', 'eventTypeFilter', 'marketCodeFilter'));
    }
    public function getNoNightsCateringSalesOnSubmit(Request $request)
    {
        $todayDate = date('m-d-Y');
        $toDatefromController = $request['todate'];
        $fromDatefromController = $request['fromdate'];
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_todate = explode('-', $request['todate']);
        $convertedToDate = $parts_todate[1] . '-' . $parts_todate[0] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', $request['fromdate']);
        $convertedFromDate = $parts_fromDate[1] . '-' . $parts_fromDate[0] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));
        //dd($tempFrom);
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // DB::enableQueryLog();
        $eventTypeFilter = $request['selected_event_type'];
        $customerIdFilter = $request['selected_customer_id_from_select'];
        $marketCodeFilter = $request['selected_market_code'];
        $joinCustomerIdFilter = "";
        $joinMarketCodeFilter = "";
        $joinEventTypeFilter = "";
        if ($customerIdFilter == "0") {
        } else {
            $joinCustomerIdFilter = "cust.customer_id='$customerIdFilter' and ";
        }
        if ($marketCodeFilter == "All") {
        } else {
            $joinMarketCodeFilter = "cust.vip_level='$marketCodeFilter' and ";
        }
        if ($eventTypeFilter == "All") {
        } else {
            $joinEventTypeFilter = " event.cat_event_type='$eventTypeFilter' and ";
        }
        $final_query = "select cust.customer_id,cust.name,cust.vip_level,floor(sum(floor(event.end_datetime-event.start_datetime))) as diff from dev.vr_customers cust  inner join dev.vr_cat_sales sales on cust.customer_id=sales.folio_customer_id inner join dev.vr_cat_event event on event.event_id=sales.folio_id where " . $joinCustomerIdFilter . $joinMarketCodeFilter . $joinEventTypeFilter . "event.room!=' ' and ((event.start_datetime>='$tempFrom' and event.start_datetime<='$tempTo') or (event.end_datetime>='$tempFrom' and event.end_datetime<='$tempTo')) group by cust.customer_id,cust.name,cust.vip_level";

        $resort_suit_customers_cat_no_nights = DB::Select($final_query);

        $resort_suit_customers_cat_no_nights_ar = json_decode(json_encode($resort_suit_customers_cat_no_nights), true);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);
        $event_type_list = DB::Select("select distinct(cat_event_type) from dev.vr_cat_event where cat_event_type!=' ' order by cat_event_type ASC");
        $event_type_list_ar = json_decode(json_encode($event_type_list), true);
        $market_code = DB::Select("Select distinct(vip_level) from dev.vr_customers where vip_level!=' ' order by vip_level ASC");
        $market_code_ar = json_decode(json_encode($market_code), true);

        //dd($final_query);
        return view('onRequestCustomerDetails.cateringRoomReservationNoNights', compact('todayDate', 'resort_suit_customers_cat_no_nights_ar', 'toDatefromController', 'fromDatefromController', 'listOutCustomers_ar', 'event_type_list_ar', 'market_code_ar', 'customerIdFilter', 'eventTypeFilter', 'marketCodeFilter'));
    }
    public function getNoNightsCateringSalesOnViewDetail(Request $request)
    {
        $todayDate = date('m-d-Y');
        $customer_id = base64_decode($request['customer_id']);
        $market_code = base64_decode($request['market_code']);
        $event_type = base64_decode($request['event_type']);
        $from_date = base64_decode($request['from_date']);
        $to_date = base64_decode($request['to_date']);
        $parts_todate = explode('-', base64_decode($request['to_date']));
        $convertedToDate = $parts_todate[1] . '-' . $parts_todate[0] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', base64_decode($request['from_date']));
        $convertedFromDate = $parts_fromDate[1] . '-' . $parts_fromDate[0] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));
        //dd($tempFrom);
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // DB::enableQueryLog();
        $joinMarketCodeFilter = "";
        $joinEventTypeFilter = "";
        if ($market_code == "All") {
        } else {
            $joinMarketCodeFilter = " and cust.vip_level='$market_code' ";
        }
        if ($event_type == "All") {
        } else {
            $joinEventTypeFilter = " and event.cat_event_type='$event_type' ";
        }
        // Miltary date format change start 26/09/2023
        $final_query = "select cust.customer_id,cust.name,cust.vip_level,event.event_id,event.cat_event_type,event.room,TO_CHAR(event.start_datetime,'MM-DD-YYYY HH:MM AM') as start_datetime,TO_CHAR(event.end_datetime,'MM-DD-YYYY HH:MM AM') as end_datetime,floor(sum(floor(event.end_datetime-event.start_datetime)))  as datediff from dev.vr_customers cust  inner join dev.vr_cat_sales sales on cust.customer_id=sales.folio_customer_id  inner join dev.vr_cat_event event on event.event_id=sales.folio_id where event.room!=' ' and cust.customer_id='$customer_id' " . $joinMarketCodeFilter . $joinEventTypeFilter . " and ((event.start_datetime>='$tempFrom' and event.start_datetime<='$tempTo') or (event.end_datetime>='$tempFrom' and event.end_datetime<='$tempTo')) group by cust.customer_id,cust.name,cust.vip_level,event.event_id,event.cat_event_type,event.room,event.start_datetime,event.end_datetime";
        // Miltary date format change end 26/09/2023
        $resort_suit_customers_cat_no_nights = DB::Select($final_query);

        $resort_suit_customers_cat_no_nights_ar = json_decode(json_encode($resort_suit_customers_cat_no_nights), true);
        return view('onRequestCustomerDetails.cateringRoomReservationViewDetailPage', compact('todayDate', 'resort_suit_customers_cat_no_nights_ar'));
    }
    public function catRoomReservationOnCalendar()
    {
        $todayDate = date('m-d-Y');
        $customerIdFilter = "0";
        $marketCodeFilter = "All";
        $eventTypeFilter = "All";
        $cust_id = 0;
        $data = DB::Select("select cust.customer_id,event.start_datetime,event.end_datetime,floor(sum(floor(event.end_datetime-event.start_datetime))) as diff from dev.vr_customers cust  inner join dev.vr_cat_sales sales on cust.customer_id=sales.folio_customer_id inner join dev.vr_cat_event event on event.event_id=sales.folio_id where event.room!=' ' and cust.customer_id='$cust_id' and TO_CHAR(event.start_datetime,'MM-DD-YYYY')!=TO_CHAR(event.end_datetime,'MM-DD-YYYY') group by cust.customer_id,event.start_datetime,event.end_datetime");
        $data_ar = json_decode(json_encode($data), true);
        $i = 0;
        $events = [];
        $color = '';
        foreach ($data_ar as $id => $eventcount) {
            $item_count = $data_ar[$i]['diff'];
            $start_datetime = $data_ar[$i]['start_datetime'];
            $end_datetime = $data_ar[$i]['end_datetime'];
            $start = date_format(date_create($start_datetime), "m-d-Y");
            $end = date_format(date_create($end_datetime), "m-d-Y");
            switch ($item_count) {
                case "1":
                    $color = '#FFA500';
                    break;
                case "3":
                    $color = '#FFCC66';
                    break;
                case "5":
                    $color = '#FF0000';
                    break;
                case "43":
                    $color = '#F0FFFF';
                    break;
                case "7":
                    $color = '#660099';
                    break;
                case "8":
                    $color = '#FFFF00';
                    break;
                case "11":
                    $color = '#FFFFFF';
                    break;
                case "45":
                    $color = '#48D1CC';
                    break;
                case "13":
                    $color = '#00FFFF';
                    break;
                case "15":
                    $color = '#FFB6C1';
                    break;
                case "17":
                    $color = '#FF7F50';
                    break;
                case "19":
                    $color = '#FFA500';
                    break;
                case "21":
                    $color = '#33CCFF';
                    break;
                case "23":
                    $color = '#32CD32';
                    break;
                case "25":
                    $color = '#CCFFFF';
                    break;
                case "27":
                    $color = '#00FA99';
                    break;
                case "29":
                    $color = '#0000FF';
                    break;
                case "31":
                    $color = '#00FA9A';
                    break;
                case "33":
                    $color = '#F0E68C';
                    break;
                case "35":
                    $color = '#FF8C00';
                    break;
                case "37":
                    $color = '#FFFF00';
                    break;
                case "39":
                    $color = '#9370DB';
                    break;
                case "41":
                    $color = '#B0E0E6';
                    break;
                default:
                    $color = '#48D1CC';
            }
            $itemc = $item_count;
            if (empty($itemc)) {
                $itemc = 0;
            }
            $events[] = Calendar::event(
                "Night:$itemc",

                true,
                new \DateTime($start_datetime),
                new \DateTime($end_datetime . '+1 day'),
                null,
                // Add color
                [

                    'color' => "$color",
                    'textColor' => '#0e0f0e',
                    'url' => "/getCatCustomerNoNightsDataOnViewDetails/".base64_encode($cust_id)."/".base64_encode($marketCodeFilter)."/".base64_encode($eventTypeFilter)."/".base64_encode($start)."/".base64_encode($end),
                ]
            );
            $i++;
        }
        $calendar = Calendar::addEvents($events);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);

        $event_type_list = DB::Select("select distinct(cat_event_type) from dev.vr_cat_event where cat_event_type!=' ' order by cat_event_type ASC");
        $event_type_list_ar = json_decode(json_encode($event_type_list), true);
        $market_code = DB::Select("Select distinct(vip_level) from dev.vr_customers where vip_level!=' ' order by vip_level ASC");
        $market_code_ar = json_decode(json_encode($market_code), true);

        return view('onRequestCustomerDetails.catRoomsReservationOnCalendar', compact('calendar', 'todayDate', 'listOutCustomers_ar', 'cust_id', 'market_code_ar', 'customerIdFilter', 'marketCodeFilter', 'event_type_list_ar', 'eventTypeFilter'));
    }
    public function catRoomReservationOnCalendarByFilter(Request $request)
    {
        $todayDate = date('m-d-Y');
        $customerIdFilter = base64_decode($request['cust_id']);
        $marketCodeFilter = base64_decode($request['market_code']);
        if ($marketCodeFilter == "null") {
            $marketCodeFilter = "";
        }
        $eventTypeFilter = base64_decode($request['event_type']);
        if ($customerIdFilter == "All") {
            $cust_id = 0;
        } else {
            $cust_id = $customerIdFilter;
        }
        $joinMarketCodeFilter = "";
        $joinEventTypeFilter = "";
        if ($marketCodeFilter == "All") {
        } else {
            $joinMarketCodeFilter = " and cust.vip_level='$marketCodeFilter' ";
        }
        if ($eventTypeFilter == "All") {
        } else {
            $joinEventTypeFilter = " and event.cat_event_type='$eventTypeFilter' ";
        }
        $final_query = "select cust.customer_id,event.start_datetime,event.end_datetime,floor(sum(floor(event.end_datetime-event.start_datetime))) as diff from dev.vr_customers cust  inner join dev.vr_cat_sales sales on cust.customer_id=sales.folio_customer_id inner join dev.vr_cat_event event on event.event_id=sales.folio_id where event.room!=' ' and cust.customer_id='$cust_id' and TO_CHAR(event.start_datetime,'MM-DD-YYYY')!=TO_CHAR(event.end_datetime,'MM-DD-YYYY')" . $joinMarketCodeFilter . $joinEventTypeFilter . " group by cust.customer_id,event.start_datetime,event.end_datetime";
        $data = DB::Select($final_query);
        $data_ar = json_decode(json_encode($data), true);
        $i = 0;
        $events = [];
        $color = '';
        foreach ($data_ar as $id => $eventcount) {
            $item_count = $data_ar[$i]['diff'];
            $start_datetime = $data_ar[$i]['start_datetime'];
            $end_datetime = $data_ar[$i]['end_datetime'];
            $start = date_format(date_create($start_datetime), "m-d-Y");
            $end = date_format(date_create($end_datetime), "m-d-Y");
            switch ($item_count) {
                case "1":
                    $color = '#FFA500';
                    break;
                case "3":
                    $color = '#FFCC66';
                    break;
                case "5":
                    $color = '#FF0000';
                    break;
                case "43":
                    $color = '#F0FFFF';
                    break;
                case "7":
                    $color = '#660099';
                    break;
                case "8":
                    $color = '#FFFF00';
                    break;
                case "11":
                    $color = '#FFFFFF';
                    break;
                case "45":
                    $color = '#48D1CC';
                    break;
                case "13":
                    $color = '#00FFFF';
                    break;
                case "15":
                    $color = '#FFB6C1';
                    break;
                case "17":
                    $color = '#FF7F50';
                    break;
                case "19":
                    $color = '#FFA500';
                    break;
                case "21":
                    $color = '#33CCFF';
                    break;
                case "23":
                    $color = '#32CD32';
                    break;
                case "25":
                    $color = '#CCFFFF';
                    break;
                case "27":
                    $color = '#00FA99';
                    break;
                case "29":
                    $color = '#0000FF';
                    break;
                case "31":
                    $color = '#00FA9A';
                    break;
                case "33":
                    $color = '#F0E68C';
                    break;
                case "35":
                    $color = '#FF8C00';
                    break;
                case "37":
                    $color = '#FFFF00';
                    break;
                case "39":
                    $color = '#9370DB';
                    break;
                case "41":
                    $color = '#B0E0E6';
                    break;
                default:
                    $color = '#48D1CC';
            }
            $itemc = $item_count;
            if (empty($itemc)) {
                $itemc = 0;
            }
            $events[] = Calendar::event(
                "Night:$itemc",

                true,
                new \DateTime($start_datetime),
                new \DateTime($end_datetime . '+1 day'),
                null,
                // Add color
                [

                    'color' => "$color",
                    'textColor' => '#0e0f0e',
                    'url' => "/getCatCustomerNoNightsDataOnViewDetails/".base64_encode($cust_id)."/".base64_encode($marketCodeFilter)."/".base64_encode($eventTypeFilter)."/".base64_encode($start)."/".base64_encode($end),
                ]
            );
            $i++;
        }
        $calendar = Calendar::addEvents($events);
        $listOutCustomers = DB::Select("select customer_id,concat(concat(first_name,' '),last_name) as name from dev.vr_customers order by name ASC");
        $listOutCustomers_ar = json_decode(json_encode($listOutCustomers), true);

        $event_type_list = DB::Select("select distinct(cat_event_type) from dev.vr_cat_event where cat_event_type!=' ' order by cat_event_type ASC");
        $event_type_list_ar = json_decode(json_encode($event_type_list), true);
        $market_code = DB::Select("Select distinct(vip_level) from dev.vr_customers where vip_level!=' ' order by vip_level ASC");
        $market_code_ar = json_decode(json_encode($market_code), true);

        return view('onRequestCustomerDetails.catRoomsReservationOnCalendar', compact('calendar', 'todayDate', 'listOutCustomers_ar', 'cust_id', 'market_code_ar', 'customerIdFilter', 'marketCodeFilter', 'event_type_list_ar', 'eventTypeFilter'));
    }
    public function folioPMSChargedByCode(Request $request)
    {
        $todayDate = date('m-d-Y');
        $toDatefromController = "";
        $fromDatefromController = "";
        $pmsChargeCodeFilter = "All";
        $pms_charge_by_code_detail_info_ar = "";
        $pms_charge_code_list = DB::Select("select distinct charge_code from dev.vr_pms_items");
        $pms_charge_code_list_ar = json_decode(json_encode($pms_charge_code_list), true);
        return view('onRequestCustomerDetails.pmsChargedByCodeFirstPage', compact('todayDate', 'toDatefromController', 'fromDatefromController', 'pmsChargeCodeFilter', 'pms_charge_code_list_ar', 'pms_charge_by_code_detail_info_ar'));
    }
    public function folioPMSChargeByCodeOnSubmit(Request $request)
    {
        $todayDate = date('m-d-Y');
        $toDatefromController = $request['todate'];
        $fromDatefromController = $request['fromdate'];
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_todate = explode('-', $request['todate']);
        $convertedToDate = $parts_todate[1] . '-' . $parts_todate[0] . '-' . $parts_todate[2];
        $tempTo = date("Y-m-d", strtotime($convertedToDate));
        // todate m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - START
        $parts_fromDate = explode('-', $request['fromdate']);
        $convertedFromDate = $parts_fromDate[1] . '-' . $parts_fromDate[0] . '-' . $parts_fromDate[2];
        $tempFrom = date("Y-m-d", strtotime($convertedFromDate));
        //dd($toDatefromController);
        // from m-d-y to d-m-y & then d-m-y to d-M-Y - END
        // DB::enableQueryLog();
        $pmsChargeCodeFilter = $request['pms_charge_code_filter'];
        $joinChargeByCodeFilter = " ";
        if ($pmsChargeCodeFilter == "All") {
            $pmsChargeCodeFilter = " ";
        } else {
            $joinChargeByCodeFilter = " and pmsSales.detail_charge_code='$pmsChargeCodeFilter'";
        }
        // $final_query1="Select distinct pmsSales.FOLIO_ID,TO_CHAR(pmsSales.FOLIO_OPERATING_DAY,'DD-MM-YYYY') as FOLIO_OPERATING_DAY,pmsSales.FOLIO_STAFF_ID,pmsSales.FOLIO_CUSTOMER_ID,vc.name ,pmsSales.detail_charge_code,pmsSales.APP_FOLIO_ID,Sum(pmssales.charge_code_amount) Ammount ,pmsSales.item_name,pmsSales.all_reservation_id,vc.customer_code from dev.vr_pms_sales pmsSales inner join dev.vr_customers vc on  vc.customer_id=pmsSales.folio_customer_id  where TO_CHAR(pmsSales.FOLIO_OPERATING_DAY,'MM-DD-YYYY') between '$fromDatefromController' and '$toDatefromController' ".$joinChargeByCodeFilter." group by  pmsSales.FOLIO_ID,pmsSales.FOLIO_OPERATING_DAY ,pmsSales.FOLIO_STAFF_ID,pmsSales.FOLIO_CUSTOMER_ID,vc.name,pmsSales.detail_charge_code,pmsSales.APP_FOLIO_ID,pmsSales.item_name,pmsSales.all_reservation_id,vc.customer_code";
        $final_query1 = "Select distinct pmsSales.FOLIO_ID,TO_CHAR(pmsSales.FOLIO_OPERATING_DAY,'MM-DD-YYYY')
        as FOLIO_OPERATING_DAY,pmsSales.FOLIO_STAFF_ID,pmsSales.FOLIO_CUSTOMER_ID,vc.name ,
        pmsSales.detail_charge_code,pmsSales.APP_FOLIO_ID,Sum(pmssales.charge_code_amount) Ammount ,
        pmsSales.item_name,pmsSales.all_reservation_id,vc.customer_code
        from dev.vr_pms_sales pmsSales inner join dev.vr_customers vc on
        vc.customer_id=pmsSales.folio_customer_id  where
        ((pmsSales.FOLIO_OPERATING_DAY>='$tempFrom' and pmsSales.FOLIO_OPERATING_DAY<='$tempTo')) "
         . $joinChargeByCodeFilter . " group by  pmsSales.FOLIO_ID,pmsSales.FOLIO_OPERATING_DAY
         ,pmsSales.FOLIO_STAFF_ID,pmsSales.FOLIO_CUSTOMER_ID,vc.name,pmsSales.detail_charge_code,
         pmsSales.APP_FOLIO_ID,pmsSales.item_name,pmsSales.all_reservation_id,vc.customer_code";
        $pms_charge_by_code_detail_info = DB::Select($final_query1);
        $pms_charge_by_code_detail_info_ar_temp = json_decode(json_encode($pms_charge_by_code_detail_info), true);
        // dd($pms_charge_by_code_detail_info_ar_temp);
        $i = 0;
        $previous_staff_id = "";
        // dd(count($pms_charge_by_code_detail_info_ar_temp));

        try{
            set_time_limit(300);
        foreach ($pms_charge_by_code_detail_info_ar_temp as $id => $eventcount) {
            $stn = "";
            $current_staff_id = $pms_charge_by_code_detail_info_ar_temp[$i]['folio_staff_id'];
            if ($current_staff_id != $previous_staff_id) {
                try{
                $staff_name_result = DB::Select("select distinct(name) from dev.vr_staff where staff_id=$current_staff_id");
                }catch(\Illuminate\Database\QueryException $e){
                    $pms_charge_by_code_detail_info_ar_temp[$i]['staff_name']=$stn;
                }
                $staff_name_result_ar = json_decode(json_encode($staff_name_result), true);
                $stn = $staff_name_result_ar[0]['name'];
                $pms_charge_by_code_detail_info_ar_temp[$i]['staff_name'] = $stn;
            } else {
                $pms_charge_by_code_detail_info_ar_temp[$i]['staff_name'] = $stn;
            }
            // Log::info($pms_charge_by_code_detail_info_ar_temp[$i]);
            $previous_staff_id = $pms_charge_by_code_detail_info_ar_temp[$i]['folio_staff_id'];
            $app_folio_id_temp = $pms_charge_by_code_detail_info_ar_temp[$i]['app_folio_id'];
            if ($app_folio_id_temp != null) {
                $transfer_folio_id_info = DB::Select("Select distinct pmsSales.FOLIO_ID,pmsSales.FOLIO_CUSTOMER_ID,vc.name from dev.vr_pms_sales pmsSales inner join dev.vr_customers vc on  vc.customer_id=pmsSales.folio_customer_id where pmsSales.FOLIO_ID=$app_folio_id_temp");
                $transfer_folio_id_info_ar = json_decode(json_encode($transfer_folio_id_info), true);
                if ($transfer_folio_id_info_ar != null) {
                    $pms_charge_by_code_detail_info_ar_temp[$i]['customer_id_paid'] = $transfer_folio_id_info_ar[0]['folio_customer_id'];
                    $pms_charge_by_code_detail_info_ar_temp[$i]['customer_name_paid'] = $transfer_folio_id_info_ar[0]['name'];
                } else {
                    $pms_charge_by_code_detail_info_ar_temp[$i]['customer_id_paid'] = "NA";
                    $pms_charge_by_code_detail_info_ar_temp[$i]['customer_name_paid'] = "NA";
                }
            } else {
                $pms_charge_by_code_detail_info_ar_temp[$i]['customer_id_paid'] = "NA";
                $pms_charge_by_code_detail_info_ar_temp[$i]['customer_name_paid'] = "NA";
            }
            $i = $i + 1;
        }
    }catch(\Throwable $th){
        echo 'Error: '.$th->getMessage();
    }
        $pms_charge_by_code_detail_info_ar = json_decode(json_encode($pms_charge_by_code_detail_info_ar_temp), true);;

        $pms_charge_code_list = DB::Select("select distinct charge_code from dev.vr_pms_items");
        $pms_charge_code_list_ar = json_decode(json_encode($pms_charge_code_list), true);
        // dd($pms_charge_by_code_detail_info_ar);
        return view('onRequestCustomerDetails.pmsChargedByCodeFirstPage', compact('todayDate', 'toDatefromController', 'fromDatefromController', 'pmsChargeCodeFilter', 'pms_charge_code_list_ar', 'pms_charge_by_code_detail_info_ar'));
    }

    public function validateUser(){
        $user_role_session = session()->get('userrole');
        if ($user_role_session != "Super Admin") {
            abort(403, 'Unauthorized action.');
        }
    }
}
