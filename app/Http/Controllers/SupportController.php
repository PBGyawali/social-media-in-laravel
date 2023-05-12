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
        $emails=Support::orderBy('created_at','desc')->get();
        $total=$emails->count();
        $faker = Faker::create();
        $names = [];
        for ($i = 0; $i < $total; $i++) {
            $names[] = $faker->name();
        }
        $page='inbox';
        $total_inbox=Support::count();  
        return view('admin.inbox',compact('emails','page','names','total_inbox'));
    }


    public function create(Request $request)
    {
        // $emails=Support::orderBy('created_at','desc')->get();
        // $total=$emails->count();
        // $faker = Faker::create();
        // $names = [];
        // for ($i = 0; $i < $total; $i++) {
        //     $names[] = $faker->name();
        // }
        $page='compose'; 
        $support_active='inactive_class';
        $total_inbox=Support::count();   
        return view('admin.compose',compact('page','support_active','total_inbox'));
    }

    public function show(Request $request,Support $id)
    {
        $email=$id;        
        $page='mail view';
        $total_inbox=Support::count();
        $support_active='inactive_class';    
        return view('admin.mail-view',compact('email','page','total_inbox','support_active'));
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

    public function destroy(support $support)
    {
        $support->delete();
    }
}
