<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Kiểm tra thông tin đăng nhập tại đây (ví dụ: kiểm tra username và password)
        $email = $request->input('email');
        $password = $request->input('password');
        $conn = mysqli_connect("localhost", "root", "adebayor9");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_select_db($conn, "webbanhang");
        $user = mysqli_query($conn, "SELECT Usersid, fullname, username, `password` , isadmin, `address`, phonenumber
        FROM `webbanhang`.`users` WHERE `username`= '{$email}'");
        // Kiểm tra thông tin đăng nhập (thay thế bằng cách thực hiện kiểm tra thực tế)
        if ($user && $user->num_rows == 1) {
            $userfetch = $user->fetch_assoc();
            // Lưu thông tin người dùng vào session
            if (password_verify($password, $userfetch['password'])) {
                Session::put('user', ['fullname' => $user['fullname']]);
                $conn->close();
                // Chuyển hướng đến trang sau khi đăng nhập thành công (ví dụ: trang chính)
                return response()->json(['message' => 'Đăng nhập thành công'], 200);
            }
        }

        // Nếu đăng nhập thất bại, quay lại trang đăng nhập với thông báo lỗi
        $conn->close();
        return response()->json(['error' => 'Email hoặc mật khẩu không đúng'], 401);
    }
}
