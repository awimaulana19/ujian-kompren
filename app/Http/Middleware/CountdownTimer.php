<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Countdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountdownTimer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->tingkatan_lomba == 'sd') {
            $countdown = Countdown::where('tingkat', 'sd')->first();
            if (!$countdown) {
                return redirect('/test');
            }
        }elseif ($user->tingkatan_lomba == 'smp') {
            $countdown = Countdown::where('tingkat', 'smp')->first();
            if (!$countdown) {
                return redirect('/test');
            }
        }elseif ($user->tingkatan_lomba == 'sma') {
            $countdown = Countdown::where('tingkat', 'sma')->first();
            if (!$countdown) {
                return redirect('/test');
            }
        }else{
            return redirect('/test');
        }

        $countdownDateTime = Carbon::parse($countdown->countdown_date)->setTimeFromTimeString($countdown->countdown_time);
        $now = Carbon::now();

        if ($now <= $countdownDateTime) {
            return redirect('/test');
        }

        return $next($request);
    }
}
