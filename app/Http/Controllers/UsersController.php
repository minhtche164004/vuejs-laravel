<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Kiểm tra thông tin đăng nhập tại đây (ví dụ: kiểm tra username và password)
            $email = $request->input('email');
            $password = $request->input('password');
            if (strlen($email) == 0 || strlen($password) == 0) {
                return response()->json(['error' => 'Vui lòng nhập đầy đủ email và mật khẩu'], 401);
            }
            $conn = mysqli_connect("localhost", "root", "adebayor9");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            mysqli_select_db($conn, "webbanhang");
            $user = mysqli_query($conn, "SELECT Usersid, fullname, username, `password` , isadmin, `address`, phonenumber, email 
        FROM `webbanhang`.`users` WHERE `username`= '{$email}'");
            // Kiểm tra thông tin đăng nhập (thay thế bằng cách thực hiện kiểm tra thực tế)
            if ($user && $user->num_rows == 1) {
                $userfetch = $user->fetch_assoc();
                // Lưu thông tin người dùng vào session
                if (password_verify($password, $userfetch['password'])) {
                    unset($userfetch['password']);
                    Session::put('user', $userfetch);
                    $conn->close();
                    // Chuyển hướng đến trang sau khi đăng nhập thành công (ví dụ: trang chính)
                    // return redirect('/');
                    return response()->json(['user' => $userfetch]);
                    // return view('/');
                }
            }

            // Nếu đăng nhập thất bại, quay lại trang đăng nhập với thông báo lỗi
            $conn->close();
            return response()->json(['error' => 'Email hoặc mật khẩu không đúng'], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getUser(Request $request)
    {
        $user = Session::get('user');

        if ($user) {
            return response()->json(['user' => $user]);
        }

        return response()->json(['error' => 'User not found']);
    }
    public function logout(Request $request)
    {
        Session::forget('user');
        return redirect('/');
    }
}
