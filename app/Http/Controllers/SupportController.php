<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use App\Models\OfflineMessage;
use App\Models\Alert;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        $query=Support::orderBy('id');
        if($request->from_date!=''&& $request->to_date!='')
            $query->whereBetween('created_at',[$request->from_date, $request->to_date]);
        $data=$query->get();
        return DataTables::of($data)
        ->addColumn('action', function($data){
        $actionBtn = '<button type="button"  title="edit"class="fa fa-edit btn btn-primary btn-sm update" data-prefix="Post" data-id="'. $data->id .'"></button>';
        $actionBtn .='
        <button type="button"  title="delete" class="fa fa-trash btn btn-danger btn-sm delete" data-action="delete" data-id="'. $data->id .'"></button>';
        })
        ->editColumn('status', function ($data) {
            $status = '<i class="fa fa-times btn btn-danger"></i>';
            if($data->is_active())
                $status = '<i class="fa fa-check btn btn-success"></i>';
            return $status;
             })
        ->make(true);
        }
        $info=WebsiteInfo::first();
        $page='support';
        return view('admin.support',compact('info','page'));
    }


    public function store(Request $request)
    {
        Support::create($request->all());
        if($request->ajax()){
            return response()->json(array('response'=>
            '<div class="alert alert-success">The message was sucessfuly
            sent. We will reply you as soon as possible</div>'));
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
