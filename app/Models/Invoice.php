<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($invoice) {
            $invoice->invoice_nr = $invoice->generateInvoiceNumber($invoice->id);
            $invoice->save();
        });
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product');
    }
    public function generateInvoiceNumber(int $id): string
    {
        $numbers = ($id % 999 === 0) ? 999 : $id % 999;

        return 'F/' . sprintf('%03d', $numbers);
    }
}
