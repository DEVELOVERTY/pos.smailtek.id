<?php

namespace App\Models\Hrm;

use App\Models\Admin\SettingsHrm;
use App\Models\Admin\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function today_attendance($date)
    {
        $attendance = $this->attendance()->where('date', $date)->first();
        if ($attendance == null) {
            return 'no';
        } else {
            return 'yes';
        }
    }

    public function today_checkint($date)
    {
        $attendance = $this->attendance()->where('date', $date)->first();
        if ($attendance == null) {
            return '-';
        } else {
            return $attendance->check_int;
        }
    }

    public function today_checkout($date)
    {
        $attendance = $this->attendance()->where('date', $date)->first();
        if ($attendance == null) {
            return '-';
        } else {
            return $attendance->check_out;
        }
    }

    public function today_late($date)
    {
        $attendance = $this->attendance()->where('date', $date)->first();
        if ($attendance == null) {
            return '-';
        } else {
            return $attendance->late;
        }
    }

    public function today_work($date)
    {
        $attendance = $this->attendance()->where('date', $date)->first();
        if ($attendance == null) {
            return '-';
        } else {
            return $attendance->total_work;
        }
    }

    public function month_attendance($year, $month, $day)
    {
        $attendance = $this->attendance()->whereYear('created_at', $year)->whereMonth('created_at', $month)->whereDay('created_at', $day)->first();
        if ($attendance == null) {
            return 'no';
        } else {
            return 'yes';
        }
    }

    public function month_late($year,$month)
    {
        $settinghrm = SettingsHrm::first();
        $totalMinutes = 0;
        $attendance = $this->attendance()->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
        foreach ($attendance as $a) {
            $s = new Carbon($settinghrm->max_check_int);
            $e = new Carbon($a->check_int);
            $getMunites = $s->diffInMinutes($e);
            $totalMinutes += $getMunites;
        }

        return $this->formatMinutes($totalMinutes);
    }

    public function month_work($year,$month)
    {
        $totalMinutes = 0;
        $attendance = $this->attendance()->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
        foreach ($attendance as $a) {
            $s = new Carbon($a->check_int);
            $e   = new Carbon($a->check_out);
            $minutesToday  = $s->diffInMinutes($e);
            $totalMinutes += $minutesToday;
        }

        return $this->formatMinutes($totalMinutes);
    }

    public function month_total($year,$month)
    {
        $attendance = $this->attendance()->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
        return count($attendance);
    }

    function formatMinutes($minutes)
    {
        $now = \Carbon\Carbon::now();
        $then = $now->copy()->addMinutes($minutes);
        $hours = $now->diffInHours($then);
        $minutes = $now->diffInMinutes($then) - ($hours * 60);

        return \sprintf('%d:%02d', $hours, $minutes);
    }


    public function total_attendance($start, $end)
    {
        if ($start != null) {
            $attendance = $this->attendance()->whereBetween('date', [$start, $end])->count();
        } else {
            $attendance = $this->attendance()->count();
        }

        return $attendance;
    }

    public function total_late($start, $end)
    {
        $totalMinutes = 0;
        $settinghrm = SettingsHrm::first();
        if ($start != null && $end != null) {
            $attendance = $this->attendance()->whereBetween('date', [$start, $end])->get();
        } else {
            $attendance = $this->attendance()->get();
        }

        foreach ($attendance as $a) {
            $s = new Carbon($settinghrm->max_check_int);
            $e = new Carbon($a->check_int);
            $getMunites = $s->diffInMinutes($e);
            $totalMinutes += $getMunites;
        }

        return $this->formatMinutes($totalMinutes);
    }

    public function total_work($start, $end)
    {
        $totalMinutes = 0;
        if ($start != null && $start != null) {
            $attendance = $this->attendance()->whereBetween('date', [$start, $end])->get();
        } else {
            $attendance = $this->attendance()->get();
        }
        foreach ($attendance as $a) {
            $s = new Carbon($a->check_int);
            $e   = new Carbon($a->check_out);
            $minutesToday  = $s->diffInMinutes($e);
            $totalMinutes += $minutesToday;
        }

        return $this->formatMinutes($totalMinutes);
    }
}
