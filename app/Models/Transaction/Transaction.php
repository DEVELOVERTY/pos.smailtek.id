<?php

namespace App\Models\Transaction;

use App\Models\Admin\Customer;
use App\Models\Admin\Store;
use App\Models\Product\Supplier;
use App\Models\Stock\StockAdjusmentDetail;
use App\Models\Stock\StockTransferDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
  
    public function status_payment($id)
    {
        $dt = Transaction::where('type', 'purchase_return')->where('id', $id)->first();
        if ($dt->payment_status == 'due') {
            if ($dt->type != 'purchase_return') {
                return 'Tunggakan';
            } else {
                return 'Piutang';
            }
        } else {
            return 'Lunas';
        }

        if ($dt->payment_status == 'due') {
            return 'Piutang';
        } else {
            return 'Lunas';
        }
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->withTrashed();
    }

    public function payment()
    {
        return $this->hasMany(TransactionPayment::class, 'transaction_id');
    }

    public function paycredit()
    {
        return $this->hasMany(TransactionPayment::class, 'transaction_id');
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'transaction_id');
    }

    public function purchase_return()
    {
        return $this->hasMany(Transaction::class, 'return_parent');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'return_parent');
    }

    public function returndetail()
    {
        return $this->hasMany(ReturnDetail::class, 'transaction_id');
    }

    public function sellreturn()
    {
        return $this->hasMany(SalesReturn::class,'transaction_id');
    }

    public function transfer()
    {
        return $this->hasOne(StockTransferDetail::class, 'transaction_id');
    }

    public function adjustment()
    {
        return $this->hasMany(StockAdjusmentDetail::class, 'transaction_id');
    }

    public function manytransfer()
    {
        return $this->hasMany(StockTransferDetail::class, 'transaction_id');
    }

    public function sell()
    {
        return $this->hasMany(Sell::class, 'transaction_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function createdby()
    {
        return $this->belongsTo(User::class,'created_by')->withTrashed();
    }

    public function getDueTotalAttribute()
    {
        $payment = $this->payment()->first();
        $pay = $this->payment()->get()->sum('amount');
        if ($payment != null) {
            $due = $payment->transaction->final_total;
            $pay > $due ? $dueIs = 0 : $dueIs = $due - $pay;
            return $dueIs;
        }
        return null;
    }

    public function getTransferQtyAttribute()
    {
        $transfer = $this->manytransfer()->sum('transfer_qty');
        if ($transfer != null) {
            return $transfer;
        }
        return 0;
    }

    public function getAdjustmentQtyAttribute()
    {
        $adjustment = $this->adjustment()->sum('qty_adjustment');
        if ($adjustment != null) {
            return $adjustment;
        }

        return 0;
    }

    public function getPayTotalAttribute()
    {
        $payment = $this->payment()->get()->sum('amount');
        if ($payment != null) {
            return number_format($payment);
        }

        return 0;
    }

    public function getQtySellAttribute()
    {
        $sell = $this->sell()->get()->sum('qty');
        if ($sell != null) {
            return $sell;
        }

        return 0;
    }

    public function getQtyPurchaseAttribute()
    {
        $purchase = $this->purchase()->get()->sum('quantity');
        if ($purchase != null) {
            return $purchase;
        }

        return 0;
    }

    public function getQtyReturnAttribute()
    {
        $return = $this->returndetail()->get()->sum('return_qty');
        if ($return != null) {
            return $return;
        }

        return 0;
    }

    public function getReturnAttribute()
    {
        $itereturn = $this->purchase()->get()->sum('qty_return');
        if ($itereturn != 0) {
            echo '<span class=" badge bg-danger text-white">(' . $itereturn . ') Item Qty Returned</span>';
        }
        echo '';
    }

    public function getReturnSellAttribute()
    {
        $returnsell = $this->sell()->get()->sum('qty_return');
        if ($returnsell != 0) {
            echo '<span class=" badge bg-danger text-white">(' . $returnsell . ') Item Qty Returned</span>';
        }
        echo '';
    }

    public function getProfitAttribute()
    {
        $jumlah = DB::table("transactions as t")
            ->join('sells as s', 't.id', '=', 's.transaction_id')
            ->join('sell_purchases as sp', 's.id', '=', 'sp.sell_id')
            ->join('purchases as pp', 'sp.purchase_id', '=', 'pp.id')
            ->selectRaw("SUM(((s.qty - s.qty_return) * s.unit_price_before_disc) - ((s.qty - s.qty_return) * pp.purchase_price)) AS jumlah, SUM(s.qty * pp.purchase_price) AS modal, SUM(s.qty * s.unit_price) AS harga_jual")
            ->where("t.ref_no",$this->ref_no)
            ->first();
        return $jumlah->jumlah;
    }
}
