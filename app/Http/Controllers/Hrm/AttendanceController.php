<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use App\Models\Admin\SettingsHrm;
use App\Models\Hrm\Attendance;
use App\Models\Hrm\Designation;
use App\Models\Hrm\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    public function checkint()
    {
        $userID = Auth()->user();
        $hrm    = SettingsHrm::first();
        if ($userID->employee != null) {
            if ($hrm->attendance_in_late == 'no') {
                if ($hrm->max_check_int <= date('H:i')) {
                    return response()->json([
                        'errors' => __('attendance.late_notif'),
                        'message' => 'late'
                    ]);
                } else {
                    if ($hrm->min_check_int >= date('H:i')) {
                        return response()->json([
                            'errors' => __('attendance.entry_notif') . " " . $hrm->min_check_int,
                            'message' => 'min-check-int'
                        ]);
                    } else {

                        $data = new Attendance();
                        $data->date = date('Y-m-d');
                        $data->employee_id = $userID->employee->id;
                        $data->user_id = $userID->id;
                        $data->store_id = Session::get('mystore');
                        $data->check_int = date('H:i');
                        $data->late = '00:00';
                        $data->save();
                        return response()->json([
                            'success' => __('attendance.success_notif') . " " . $data->late,
                            'message' => 'success'
                        ]);
                    }
                }
            } else {
                if ($hrm->min_check_int >= date('H:i')) {
                    return response()->json([
                        'errors' =>  __("attendance.entry_notif") . " " . $hrm->min_check_int,
                        'message' => 'min-check-int'
                    ]);
                } else {
                    $max    = strtotime(date('Y-m-d') . " " . $hrm->max_check_int . ":00");
                    $int    = strtotime(date('Y-m-d H:i:s'));
                    $diff   = $int - $max;
                    $hour   = floor($diff / (60 * 60));
                    $munites = $diff - ($hour * (60 * 60));

                    $hasil = $hour . ":" . floor($munites / 60);

                    $data = new Attendance();
                    $data->date = date('Y-m-d');
                    $data->employee_id = $userID->employee->id;
                    $data->user_id = $userID->id;
                    $data->store_id = Session::get('mystore');
                    $data->check_int = date('H:i');
                    $hrm->max_check_int <= date('H:i') ? $data->late = $hasil : $data->late = '00:00';

                    $data->save();
                    return response()->json([
                        'success' => __('attendance.success_notif') . " " . $data->late,
                        'message' => 'success'
                    ]);
                }
            }
        } else {
            return response()->json([
                'errors' => __('attendance.error_notif'),
                'message' => 'employee-not-found'
            ]);
        }
    }

    public function checkout()
    {
        $userID = Auth()->user();
        $hrm    = SettingsHrm::first();
        $getCheck = Attendance::where('date', date('Y-m-d'))->where('user_id', $userID->id)->first();
        if ($getCheck == null) {
            return response()->json([
                'errors' => __('attendance.error_out'),
                'message' => 'not-found'
            ]);
        } else {
            if ($hrm->min_check_out >= date('H:i')) {
                return response()->json([
                    'errors' => "Maaf, Belum saatnya anda checkout",
                    'message' => 'min'
                ]);
            } else {

                $int    = strtotime(date('Y-m-d') . " " . $getCheck->check_int . ":00");
                $out    = strtotime(date('Y-m-d H:i:s'));
                $diff   = $out - $int;
                $hour   = floor($diff / (60 * 60));
                $munites = $diff - ($hour * (60 * 60));
                $hasil = $hour . ":" . floor($munites / 60);

                $getCheck->check_out = date('H:i');
                $getCheck->total_work = $hasil;
                $getCheck->save();
                return response()->json([
                    'success' => __('attendance.success'),
                    'message' => 'success'
                ]);
            }
        }
    }

    public function today()
    {
        $data = Attendance::where('date', date('Y-m-d'))->where('store_id', Session::get('mystore'))->get();
        return view('admin.attendance.today', ['page' => __('sidebar.today_attendance')], compact('data'));
    }

    public function report_today(Request $request)
    {
        $data = Employee::all();
        $designation = Designation::all();
        $date = date('Y-m-d');
        if ($request->date) {
            $date = $request->date;
        }

        if ($request->designation) {
            $data = Employee::where('designation_id', $request->designation)->get();
        }

        return view('admin.reports.attendance.today', ['page' => 'Laporan Absensi Harian'], compact('data', 'designation', 'date'));
    }

    public function report_month(Request $request)
    {
        $data = Employee::all();
        $designation = Designation::all();
        $month = [
            '01'    => 'Januari',
            '02'    => 'Februari',
            '03'    => 'Maret',
            '04'    => 'April',
            '05'    => 'Mei',
            '06'    => 'Juni',
            '07'    => 'Juli',
            '08'    => 'Agustus',
            '09'    => 'September',
            '10'    => 'Oktober',
            '11'    => 'November',
            '12'    => 'Desember'
        ];

        $year = [
            '2021'  => '2021',
            '2022'  => '2022',
            '2023'  => '2023',
            '2024'  => '2024',
            '2025'  => '2025',
            '2026'  => '2026',
            '2027'  => '2027',
            '2028'  => '2028',
            '2029'  => '2029',
            '2030'  => '2030',
        ];
        $date = date('Y-m-d');
        if ($request->date) {
            $date = $request->date;
        }

        if ($request->designation) {
            $data = Employee::where('designation_id', $request->designation)->get();
        }

        $calendar   = CAL_GREGORIAN;
        $month_      = date('m');
        $year_      = date('Y');


        if ($request->year) {
            $year_      = $request->year;
        }

        if ($request->month) {
            $month_      = $request->month;
        }

        $day_       = cal_days_in_month($calendar, $month_, $year_);
        return view('admin.reports.attendance.month', ['page' => __('sidebar.month_attendance')], compact('data', 'designation', 'date', 'month', 'year', 'month_', 'year_', 'day_'));
    }

    public function report_total(Request $request)
    {
        $data = Employee::all();
        $designation = Designation::all();
        $start = null;
        $end    = null;

        if ($request->start && $request->end) {
            $start = $request->start;
            $end    = $request->end;
        }

        if ($request->designation) {
            $data = Employee::where('designation_id', $request->designation)->get();
        }

        return view('admin.reports.attendance.total', ['page' => __('sidebar.attendance_total')], compact('data', 'designation', 'start', 'end'));
    }
}
