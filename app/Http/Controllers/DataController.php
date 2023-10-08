<?php
// app/Http/Controllers/DataController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use mysqli;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;

// require "vendor/autoload.php";
class DataController extends Controller
{

    public function saveData(Request $request)
    {
        try {
            $data = $request->all();

            // random chuỗi string để tạo password
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $newPassword = '';
            $length = 10; // Độ dài của chuỗi bạn muốn tạo

            for ($i = 0; $i < $length; $i++) {
                $newPassword .= $characters[random_int(0, strlen($characters) - 1)];
            }
            // mã hóa password
            $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $nowInVietnam = Carbon::now('Asia/Ho_Chi_Minh');


            // Check connection
            if (!Session::get('user')) {
                $originalEmail = $data['email'];
                $newEmail = $originalEmail;
                $emailExists = true;
                $userid = 0;
                $user = User::where('email', $newEmail)->first();
                if ($user) {
                    $userid = $user->Usersid;
                } else {
                    DB::insert("INSERT INTO `webbanhang`.`users` (`fullname`, `username`, `password`, `isAdmin`, `address`, `phonenumber`, `email`) VALUES (?,?,?,?,?,?,?) ", [$data['name'], $newEmail, $encryptedPassword, 0, $data['address'], $data['number'], $data['email']]);
                    $row = User::select('Usersid')
                        ->where('username', $newEmail)
                        ->where('password', $encryptedPassword)
                        ->first();
                    $userid = $row->Usersid;
                    Mail::send('message', ['account' => $newEmail, 'password' => $newPassword], function ($email) use ($data) {
                        $email->subject('Tài khoản và mật khẩu mới sử dụng cho trang web');
                        $email->to("{$data['email']}", "{$data['name']}");
                    });
                }

                DB::insert("INSERT INTO `webbanhang`.`orders` (`name`, `address`, `number`, `email`, `payment`, `note`, `status`, `total`, `userid`) 
        VALUES(?,?,?,?,?,?,?,?,?)", [$data['name'], $data['address'], $data['number'], $data['email'], 1, $data['note'], 1, 0, $userid]);
                $orderid = DB::getPdo()->lastInsertId();
                foreach ($data['products'] as $item) {
                    $count = OrderDetail::whereDate('created_at', now())->count() + 1;

                    $code = $nowInVietnam->format('dmy') . 'OD' . $count;
                    DB::insert("INSERT INTO `webbanhang`.`orderdetails` (`orderid`, `productid`, `code`, `quantity`, `unitprice`, `created_at`, `created_by`, `modified_at`, `modified_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                        $orderid,
                        $item['productid'],
                        $code,
                        $item['quantity'],
                        $item['price'],
                        $nowInVietnam, $userid, $nowInVietnam, $userid
                    ]);
                }

                $totalAmount = DB::table('orderdetails')
                    ->where('orderid', $orderid)
                    ->sum(DB::raw('quantity * unitprice'));
                DB::table('orders')
                    ->where('orderid', $orderid) // Giả sử trường chứa ID của đơn hàng là 'id', bạn cần điều chỉnh tên trường nếu cần
                    ->update(['total' => $totalAmount]);
            } else {
                $id = Session::get('user')['Usersid'];
                DB::insert("INSERT INTO `webbanhang`.`orders` (`name`, `address`, `number`, `email`, `payment`, `note`, `status`, `total`, `userid`) 
        VALUES(?,?,?,?,?,?,?,?,?)", [$data['name'], $data['address'], $data['number'], $data['email'], 1, $data['note'], 1, $data['totalPrice'], $id]);
                $orderid = DB::getPdo()->lastInsertId();

                for ($i = 0; $i < count($data['products']); $i++) {
                    // Tạo mã code cho đơn hàng dựa trên ngày và số thứ tự trong ngày
                    $count = OrderDetail::whereDate('created_at', now())->count() + 1;
                    $code = $nowInVietnam->format('dmy') . 'OD' . $count;

                    DB::insert("INSERT INTO `webbanhang`.`orderdetails` (`orderid`, `productid`, `code`, `quantity`, `unitprice`, `created_at`, `created_by`, `modified_at`, `modified_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                        $orderid,
                        $data['products'][$i]['productid'],
                        $code,
                        $data['products'][$i]['quantity'],
                        $data['products'][$i]['price'],
                        $nowInVietnam, $id, $nowInVietnam, $id
                    ]);
                }
            }
            Mail::send('orderdetail', ['products' => $data['products'], 'total' => $data['totalPrice']], function ($email) use ($data) {
                $email->subject('Thông tin đơn hàng của bạn');
                $email->to("{$data['email']}", "{$data['name']}");
            });
            return response()->json(['message' => 'Đặt hàng thành công!', 'redirectUrl' => '/']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getProduct(Request $request)
    {
        $productlist = Product::with(['productimage' => function ($query) {
            $query->select('productid', 'image');
        }])->get();

        return response()->json([
            'productlist' => $productlist,
        ]);
    }
}
