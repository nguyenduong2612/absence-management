<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
use App\User;
use DB;

class LiveSearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $absences = DB::table('absences')->where('reason', 'LIKE', '%' . $request->search . '%')->get();
            if ($absences) {
                foreach ($absences as $key => $absence) {
                    if ($absence->status == 'pending') {
                        $output .= '<tr>
                        <td>' . User::where(['id' => $absence->user_id])->first()->name . '</td>
                        <td>' . $absence->reason . '</td>
                        <td> Từ ' . \Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') . '<br>Đến ' . \Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') . '</td>
                        <td>' . \Carbon\Carbon::parse($absence->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') . '</td>
                        <td><div class="pending px-3 py-1">Đang chờ</div></td>
                        <td><a href="/absences/' .$absence->id .'" class="btn btn-info btn-sm">Xem chi tiết</a></td>
                        </tr>';
                    }
                    elseif ($absence->status == 'accepted') {
                        $output .= '<tr>
                        <td>' . User::where(['id' => $absence->user_id])->first()->name . '</td>
                        <td>' . $absence->reason . '</td>
                        <td> Từ ' . \Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') . '<br>Đến ' . \Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') . '</td>
                        <td>' . \Carbon\Carbon::parse($absence->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') . '</td>
                        <td><div class="accepted px-3 py-1">Đã duyệt</div></td>
                        <td><a href="/absences/' .$absence->id .'" class="btn btn-info btn-sm">Xem chi tiết</a></td>
                        </tr>';
                    }
                    else {
                        $output .= '<tr>
                        <td>' . User::where(['id' => $absence->user_id])->first()->name . '</td>
                        <td>' . $absence->reason . '</td>
                        <td> Từ ' . \Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') . '<br>Đến ' . \Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') . '</td>
                        <td>' . \Carbon\Carbon::parse($absence->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') . '</td>
                        <td><div class="rejected px-3 py-1">Từ chối</div></td>
                        <td><a href="/absences/' .$absence->id .'" class="btn btn-info btn-sm">Xem chi tiết</a></td>
                        </tr>';
                    }
                }
            }
            
            return Response($output);
        }
    }
}
