<?php

namespace App\Http\Controllers;

use App\Absence;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Http\Requests\Absences\CreateAbsencesRequest;

class AbsencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $absences = (new Absence)->newQuery();
        $absences->join('users', 'absences.user_id', '=', 'users.id')
                 ->select('*', 'absences.id as absence_id');

        if ($request->has('status')) {
            if ($request->status == "all") {
                $absences;
            }
            else {
                $absences->where('absences.status', $request->status);
            }
        } 

        if ($request->has('department')) {
            if ($request->department == "all") {
                $absences;
            }
            else {
                $absences->where('users.department_id', $request->department);
            }
        } 
        
        return view('search.search')->with('absences', $absences->orderBy('absences.created_at', 'desc')->paginate(8));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('absences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAbsencesRequest $request)
    {

        Absence::create([
            'user_id' => $request->user_id,
            'reason' => $request->reason,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'note' => $request->note
        ]);


        // flash message
        session()->flash('success', 'Đơn của bạn đã được tạo. Vui lòng chờ quản trị viên phê duyệt.');

        // redirect user
        return redirect(route('absences.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        return view('absences.show')->with('absence', $absence);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(Absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        //
    }

    public function accept(Request $request, Absence $absence)
    {
        $request->validate([
            'user_id' => 'required',
            'description' => 'nullable'
        ]);
        if ($request->description == NULL) $request->description = '';

        $absence->status = 'accepted';
        $absence->save();

        $data['title'] = 'Cập nhật trạng thái';
        $data['content'] = 'Đơn xin nghỉ của bạn đã được chấp nhận.';
        $data['description'] = $request->description;
        $data['user_id'] = $request->user_id;

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            '2fdd4bc794d49256edb0',
            'c72bac4a2f44e76d5af4',
            '914360',
            $options
        );

        $pusher->trigger('Notify', 'send-message', $data);

        session()->flash('success', 'Đã chấp nhận đơn xin nghỉ.');
        return redirect()->back();
    }

    public function reject(Request $request, Absence $absence)
    {
        $request->validate([
            'user_id' => 'required',
            'description' => 'nullable'
        ]);
        if ($request->description == NULL) $request->description = '';

        $absence->status = 'rejected';
        $absence->save();

        $data['title'] = 'Cập nhật trạng thái';
        $data['content'] = 'Đơn xin nghỉ của bạn đã bị từ chối.';
        $data['description'] = $request->description;
        $data['user_id'] = $request->user_id;

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            '2fdd4bc794d49256edb0',
            'c72bac4a2f44e76d5af4',
            '914360',
            $options
        );

        $pusher->trigger('Notify', 'send-message', $data);

        session()->flash('success', 'Đã từ chối đơn xin nghỉ.');
        return redirect()->back();
    }

    public function undo(Absence $absence)
    {
        $absence->status = 'pending';
        $absence->save();
        session()->flash('success', 'Hoàn tác thành công.');
        return redirect()->back();
    }

    public function calender()
    {
        $absences = Absence::get();

        $events = [];
        foreach($absences as $key => $absence)
        {
            if ($absence->status == 'accepted') {
                $events[] = \Calendar::event(
                    \App\User::where(['id' => $absence->user_id])->first()->name.': '.$absence->reason,
                    true,
                    new \DateTime($absence->start_at),
                    new \DateTime($absence->end_at.' +1 day'),
                    $absence->id,
                    [
                        'color' => '#800',
                        'description' => '<div id="'.$absence->id.'" class="notes" style="display: none">Ghi chú: '.$absence->note.'</div>',
                    ]
                );
            }
        }
       
        $calendar = \Calendar::addEvents($events)->setCallbacks([
            'eventRender' => 'function(event, element) { 
                element.children().last().append(event.description);
            }',
            'eventMouseover' => 'function(event) { 
                $("#"+event.id).show();
            }',
            'eventMouseout' => 'function(event) { 
                $("#"+event.id).hide();
            }'
            ]);

        return view('absences.calender', compact('calendar'));
    }
}
