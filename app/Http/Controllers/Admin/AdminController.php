<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account\Expense;
use App\Models\Hrm\Attendance;
use App\Models\Timezone;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;  

class AdminController extends Controller
{ 
 
    public function index()
    {
        $data = [
            'total_purchase'    => Transaction::where('type', 'purchase')->sum('final_total'),
            'total_sell'        => Transaction::where('type', 'sell')->sum('final_total'),
            'total_due'         => Transaction::where('type', 'sell')->where('status', 'due')->sum("final_total"),
            'total_expense'           => Expense::sum('amount'),

            'act_sell'          => Transaction::where('type', 'sell')->orderBy('id', 'desc')->limit(10)->get(),
            'act_purchase'      => Transaction::where('type', 'purchase')->orderBy('id', 'desc')->limit(10)->get(),
            'act_stransfer'     => Transaction::where('type', 'stock_transfer')->orderBy('id', 'desc')->limit(10)->get(),
            'act_sadjustment'   => Transaction::where('type', 'stock_adjustment')->orderBy('id', 'desc')->limit(10)->get(),
            'act_return'        => Transaction::where('type', 'purchase_return')->orderBy('id', 'desc')->limit(10)->get(),
            'act_returnsell'    => Transaction::where("type","sales_return")->orderBy("id","desc")->limit(10)->get(),
            'attendance'        => Attendance::where('date', date('Y-m-d'))->where('user_id', Auth()->user()->id)->first()
        ];
        //dd($data);
        return view('admin.index', ['page' => __('admin') . ' ' . __('dashboard')], compact('data'));
    }

    public function incomeAndExpense()
    {
        $jumlah = DB::table("transactions as t")
            ->join('sells as s', 't.id', '=', 's.transaction_id')
            ->join('sell_purchases as sp', 's.id', '=', 'sp.sell_id')
            ->join('purchases as pp', 'sp.purchase_id', '=', 'pp.id')
            ->selectRaw("SUM((s.qty * s.unit_price) - (s.qty * pp.purchase_price)) AS jumlah")
            ->get();
        $data['expense']    = Expense::selectRaw("sum(amount) as jumlah")->get();
        $data['income']     = $jumlah;
        return response()->json($data);
    }

    public function transactionData()
    {
        $data['sell']               = Transaction::selectRaw("sum(final_total) as jumlah")->where("type","sell")->where("payment_status","paid")->get();
        $data['purchase']           = Transaction::selectRaw("sum(final_total) as jumlah")->where("type","purchase")->where("payment_status","paid")->get();
        $data['purchase_return']    = Transaction::selectRaw("sum(final_total) as jumlah")->where("type","purchase_return")->get();
        $data['adjustment']         = Transaction::selectRaw("sum(final_total) as jumlah")->where("type","stock_adjustment")->get();
        $data['transfer']           = Transaction::selectRaw("sum(final_total) as jumlah")->where("type","stock_transfer")->get();
        return response()->json($data);
    }

    public function sellmonth()
    {
        $data['selling'] = array();
        $selling = Transaction::selectRaw('LEFT(created_at,10) as date, sum(final_total) as total')->where('type', 'sell')->whereYear('created_at', date('Y'))->groupBy('date')->limit(30)->get();
        foreach ($selling as $sell) { 
            $list = [
                'date'  => Carbon::parse($sell->date, "UTC")->setTimezone(auth()->user()->timezone)->format("d, M Y"),
                'total' => $sell->total
            ];
            array_push($data['selling'], $list);
        }

        return response()->json($data);
    }

    public function myProfile()
    {
        $timezone = Timezone::ZONETIME;
        return view('admin.profile', ['page' => 'My Profile'],compact('timezone'));
    }

    public function changeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|unique:users,email,' . Auth::user()->id,
            'photo' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }
        }

        $data = User::findOrFail(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->timezone = $request->timezone;
        $request->photo ? $data->photo = $this->uploadImage($request, 'photo', 'users') : null;
        return $this->saveData($data);
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password'  => 'required',
            'confirm' => 'required',
        ]);

        if ($request->password != $request->confirm) {
            return back()->with(['gagal' => __('auth.password_must_same')]);
        }

        $data = User::findOrFail(Auth::user()->id);
        $data->password = Hash::make($request->password);
        return $this->saveData($data);
    }
}
