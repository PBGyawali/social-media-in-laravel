<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use App\Models\OfflineMessage;
use App\Models\Alert;
use Faker\Factory as Faker;
class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Support::orderBy('created_at','desc');
        // Get the search value from the request
        $search = $request->search;
        // Get the search value from the request
        $search = $request->search;
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%$search%")
                    ->orWhere('subject', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('message', 'LIKE', "%$search%")
                    ->orWhere('created_at', 'LIKE', "%$search%");
            });
        }       

        $page = 'inbox';
        if ($request->route()->named('trash')) {
            $query->onlyTrashed();
            $page = 'trash';
        }

        $emails = $query->paginate();                     
        $faker = Faker::create();
        $names = [];        
        $total=10;//$emails->count();
        for ($i = 0; $i < $total; $i++) {
            $names[] = $faker->name();
        }
        if($request->ajax()){
           $email_content=view('emails-table',compact('emails','names','search'))->render();
            return response()->json(compact('email_content'));           
        }
        
        $total_inbox=Support::unread()->count();
        $trash_count=Support::onlyTrashed()->count();  
        return view('admin.inbox',compact('emails','page','names','total','total_inbox','search','trash_count'));
    }

    
    public function create(Request $request)
    {
        $page='compose'; 
        $support_active='inactive_class';
        $total_inbox=Support::unread()->count();
        $trash_count=Support::onlyTrashed()->count();   
        return view('admin.compose',compact('page','support_active','total_inbox','trash_count'));
    }

    public function show(Request $request,Support $id)
    {
        
        $email=$id; 
        $email->update(['read_by_user'=>'yes']);       
        $page='mail view';
        $total_inbox=Support::unread()->count();
        $trash_count=Support::onlyTrashed()->count();
        $support_active='inactive_class';    
        return view('admin.mail-view',compact('email','page','total_inbox','support_active','trash_count'));
    }

    public function update(Request $request)
    {
        
        $messageIds = $request->message_ids;
        Support::withTrashed()->whereIn('id', $messageIds)->update($request->except('message_ids'));
        $email_count=Support::unread()->count();
        return response()->json(compact('email_count'));
    }

    public function store(Request $request)
    {
        Support::create($request->all());
        if($request->ajax()){
            return response()->json(array('response'=>__('message.sent')));
        }
        $email=$request->email;
        $fullname=$request->full_name;
        $info=WebsiteInfo::first();
        $page='thank you';
        return view('confirmation.message_confirmation',compact('email','fullname','info','page'));
    }

    public function destroy(Request $request)
    {
        $messageIds = $request->message_ids;
        $email_count='';
        if($request->soft_delete){
            Support::destroy($messageIds);
            $email_count=Support::unread()->count();
        }        
        if($request->restore){
            Support::onlyTrashed()
            ->whereIn('id', $messageIds)
            ->restore();
            $email_count=Support::unread()->count();
        }
        if($request->force_delete){
            Support::onlyTrashed()
            ->whereIn('id', $messageIds)
            ->forceDelete();
        }
        $trash_count=Support::onlyTrashed()->count();
        return response()->json(compact('trash_count','email_count'));
    }
}
