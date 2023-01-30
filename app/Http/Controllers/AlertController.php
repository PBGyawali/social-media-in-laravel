<?php

namespace App\Http\Controllers;


use App\Models\OfflineMessage;
use App\Models\Alert;
use App\Models\AlertLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WebsiteInfo;
use App\Helper\Helper;

class AlertController extends Controller
{
    public function index(Request $request)
    {

        $id=auth()->id();
        $alertid=$request->id?$request->id:auth()->id();
        $info=$page='alerts';
        $view='admin.alerts';
        if($request->route()->named('user.alerts')){
            $view=$page;
            $info=WebsiteInfo::first();
            $alertid=$id;
        }
        $logged_alerts=$log_username='';
        $alertid=$request->id?$request->id:auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=$this->show();
        $logged_alerts=$alerts=Helper::alerts($id);
        if($alertid!=$id){
            $logged_user=User::find($alertid);
            if($logged_user){
                $log_username= $logged_user->username;
                $logged_alerts=Helper::alerts($alertid);
            }
        }
        return view($view,compact('alerts','page','messages','messagecount',
        'alertcount','alerts','info','log_username','logged_alerts'));
    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        Alert::create($request->all());
    }


    public function show()
    {
        return Alert::user_id(auth()->id())->read()->count();
    }

    public function edit(Alert $alert)
    {
        return response()->json($alert);
    }

    public function update(Request $request)
    {
        Alert::find($request->id)->update(['read_by_user'=>'yes']);
        $count=$this->show();
        return response()->json(array('response'=>$count));
    }

    public function destroy(Request $request)
    {
        if($request->action=='delete_similar')
            Alert::type($request->type)->user_id($request->id)->delete();
        else
            Alert::destroy($request->id);
        $count=$this->show();
        return response()->json(array('response'=>$count));
    }
}
