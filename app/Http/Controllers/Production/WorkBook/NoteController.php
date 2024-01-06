<?php

namespace App\Http\Controllers\Production\WorkBook;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Folio;
use App\Models\LocationProjectUser;
use App\Http\Requests\Production\Workbook\StoreNoteRequest;
use App\Http\Requests\Production\Workbook\UpdateNoteRequest;
use Illuminate\Support\Facades\DB;
use App\Mail\NoteCreated;
use App\Http\Controllers\Controller;
use App\Models\LocationTurn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Exception;

class NoteController extends Controller
{
    public function index($id)
    {
        $folio = Folio::with('location')
                ->where('id',$id)
                ->first();
        $turns = LocationTurn::select(DB::raw("turns.id as id, CONCAT(turns.name, ' [', turns.start, '-', turns.finish, ']') as name"))
                ->join('turns','location_turns.turn_id','=','turns.id')
                ->where('location_id',$folio->location_id)
                ->get();
        $notes = Note::select('notes.*')
                ->with('comments')
                ->with('turn')
                ->with('projectUser')
                ->where('folio_id',$folio->id)
                ->get();
        return Inertia::render('Production/WorkBook/Notes/Index', [
            'notes' => $notes,
            'turns' => $turns,
            'folio' => $folio,
            'projectUserId' => session('current_project_user')->id,
        ]);

    }

    public function store(StoreNoteRequest $request)
    {
        try{
            $folio=Folio::find($request->folio_id);
            if (is_valid_date_for_create_note($folio->date, $folio->location)){
                $note = Note::create($request ->validated());
                if ($request->status==1){
                    $locationProjectUsersReceiveNotification = LocationProjectUser::where('location_id',$note->folio->location_id)->where('receive_notification',1)->get();
                        foreach ($locationProjectUsersReceiveNotification as $locationProjectUser){
                            Mail::to($locationProjectUser->projectUser->user->email)->queue(new NoteCreated($note));
                        }
                }
                return redirect()->back();
            }else{
                return back()->withErrors(__('messages.timeexpiredtocreate').' '.__('content.note'));
            }
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Note $note, UpdateNoteRequest $request)
    {
        try{
            $note->update($request->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
        
    }
}
