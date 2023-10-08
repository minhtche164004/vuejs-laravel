<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Productimage;


class Product extends Model
{
    protected $fillable = [
        'productid',
        'code',
        'name',
        'shortdescript',
        'description',
        'rating_star',
        'price',
        'out_of_stock',
    ];
    public function productimage(): HasOne
    {
        return $this->hasOne(Productimage::class, 'productid', 'productid');
    }
}
