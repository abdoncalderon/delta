<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Http\Requests\Production\Workbook\StoreCommentNoteRequest;
use App\Models\CommentNote;
use App\Models\LocationProjectUser;
use App\Models\Note;
use App\Mail\CommentNoteCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class CommentNoteController extends Controller
{
    public function store(StoreCommentNoteRequest $request){
        try{
            $note = Note::find($request->note_id);
            $date = strtotime($note->folio->date);
            $today = strtotime(Carbon::today()->toDateString());
            $differenceInHours = abs(round(($date - $today)/60/60,0));
            if (($differenceInHours <= $note->folio->location->max_time_create_comment)){
                $comment = CommentNote::create($request ->validated());
                $locationProjectUsersReceiveNotification = LocationProjectUser::where('location_id',$note->folio->location_id)->where('receive_notification',1)->get();
                /* foreach ($locationProjectUsersReceiveNotification as $locationProjectUser){
                    Mail::to($locationProjectUser->projectUser->user->email)->queue(new CommentNoteCreated($comment));
                } */
                return redirect()->back();
            }else{
                return back()->withErrors(__('messages.timeexpiredtocreate').' '.__('content.comment'));
            }
          
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(CommentNote $commentNote)
    {
        try{
            $commentNote->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
        
    }

    public function getCommentsNote(Request $request, $id) {
        if($request->ajax())
        {
            $commentsNote = CommentNote::select('comment_notes.id as id', 
                                                'comment_notes.date as date',
                                                'people.fullName as fullName',
                                                'comment_notes.comment as comment', 
                                                'comment_notes.project_user_id as project_user_id')
                    ->join('project_users','comment_notes.project_user_id','=','project_users.id')
                    ->join('users','project_users.user_id','=','users.id')
                    ->join('people','users.person_id','=','people.id')
                    ->where('note_id', $id)
                    ->get();
            return response()->json($commentsNote);
        }
    } 
}
