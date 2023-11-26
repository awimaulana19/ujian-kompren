<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Matkul;
use Illuminate\Http\Request;

class StartUjian
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
        $id = $request->route('id');
        
        $matkul = Matkul::where('id', $id)->first();
        $finish_date = $matkul->finish_date;
        $finish_time = $matkul->finish_time;

        if ($finish_date && $finish_time) {
            return $next($request);
        }

        return redirect('/mahasiswa/matkul/'.$id);
    }
}
