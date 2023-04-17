<?php

namespace App\Http\Controllers;


use App\Models\OfflineMessage;
use App\Models\Alert;
use App\Models\AlertLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function index(Request $request)
    {

        $id=auth()->id();
        //if request is sending id then use it otherwise use the default authenticated user id
        $alertid=$request->id?$request->id:auth()->id();
        $info=$page='alerts';
        $view='admin.alerts';

        //if request url is user.alerts it is coming from the users section
        if($request->route()->named('user.alerts')){
            $view=$page;
            $info=WebsiteInfo::first();
            $alertid=$id;
        }
        $logged_alerts=$log_username='';
        //if request is sending id then use it otherwise use the default authenticated user id
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


    public function store(Request $request)
    {
        Alert::create($request->all());
    }


    public function show()
    {
        // count alert that are read or seen by user
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

    

    /**
     * Deletes an alert object from the database based on the given request parameters.
     * If the request action is 'delete_similar', all alerts with matching type and user_id are deleted.
     * Otherwise, the alert with the given ID is deleted.
     * Returns the count of remaining alerts in the database as a JSON response.
     *
     * @param Request $request The HTTP request object containing the action and ID parameters.
     * @return JsonResponse The JSON response containing the count of remaining alerts.
     */
    public function destroy(Request $request)
    {
        // Check if the action is 'delete_similar'
        if($request->action=='delete_similar') {
            // If so, delete all alerts with matching type and user_id
            Alert::type($request->type)->user_id($request->id)->delete();
        } else {
            // Otherwise, delete the alert with the specified ID
            Alert::destroy($request->id);
        }

        // Get the count of remaining alerts
        $count = $this->show();

        // Return the count as a JSON response
        return response()->json(array('response'=>$count));
    }




}
