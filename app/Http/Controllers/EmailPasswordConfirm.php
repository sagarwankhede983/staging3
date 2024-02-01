<?php

namespace App\Http\Controllers;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use MYSQLI;
use Illuminate\Http\Request;

class EmailPasswordConfirm extends Controller
{
    //
    public function verifyPassword(Request $request)
    {
        $id=$request['uid'];
        $pass=$request['confirm_password'];
        $password2=encrypt($pass);
        $servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "kingranchum";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}
		$sql = "UPDATE USERS SET PASSWORD = '$password2' WHERE ID = '$id';";
		$role = $conn->query($sql);
		$conn->close();
			 return view('auth/login');
		 
    }
    
}
