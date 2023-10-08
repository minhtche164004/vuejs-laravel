<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $fillable = [
        'orderid', 'productid', 'code', 'quantity', 'unitprice', 'created_at', 'created_by', 'modified_at', 'modified_by',
    ];
    public static function generateOrderCode()
    {
        // Lấy ngày hiện tại dưới định dạng YYMMDD
        $date = now()->format('ymd');

        // Lấy số thứ tự đơn hàng trong ngày
        $count = OrderDetail::whereDate('created_at', now())->count() + 1;

        // Tạo mã code dựa trên ngày và số thứ tự
        $code = $date . 'OD' . $count;

        return $code;
    }

    // ...

    // Ghi đè phương thức saving để tự động tạo mã code trước khi lưu đơn hàng
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderDetail) {
            // Kiểm tra xem đã có mã code hay chưa
            if (!$orderDetail->code) {
                // Nếu chưa có, tạo mã code và gán vào trường code
                $orderDetail->code = static::generateOrderCode();
            }
        });
    }
    use HasFactory;
}
