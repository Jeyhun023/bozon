<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'orderno', 'total',
        'discount', 'payed', 'order_type',
        'payment_type', 'type', 'address',
    ];

    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public const ORDER_KURYER_STATUSES = [
        '1' => 'Yolda',
        '2' => "Təxirə Salındı"
    ];

    public const ORDER_CANCEL_STATUSES = [ // Legv edildi
        '1' => 'Sifariş təsdiqlənmədi',
        '2' => "Sifariş stokda yoxdur",
        "3" => "Stokdaki məhsul zədələndiyinə görə göndərilə bilmir"
    ];

    public const ORDER_REFUND_STATUSES = [ // Geri Qaytarildi
        '1' => 'Məhsul ölçüsü olmadı',
        '2' => "Dəyişdirmək istəyi",
        "3" => "Məhsul defektlidi",
        "4" => "Ümumi"
    ];

    public const ORDER_REJECT_STATUSES = [ // Imtina edildi
        '1' => 'Sifariş verdi ama təsdiqləmədi',
        '2' => "Təsdiqlədikdən sonra ləğv etdi"
    ];

    public const ORDER_SELLER_STATUSES = [
        '1' => 'Gözlənilir',
        '2' => "Təsdiqləndi",
        "3" => "Hazırlanır",
        "4" => "Paketləndi"
    ];

    public function getAddressAttribute($address)
    {
        return json_decode($address, true);
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id');
    }
}
