<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Topic;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Post;
use App\Models\OfflineMessage;
use App\Models\WebsiteInfo;
use Illuminate\Validation\Rule;
use App\Helper\Helper;

class TopicController extends Controller
{
    public array $fields = [];

    public function  index(Request $request)
    {
        if ($request->ajax()) {
            $data = Topic::all();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    // primary key of the row
                    $id=$data->id;
                    // data to display on modal, tables
                    $prefix="topic";
                    // optional button to display
                    $buttons=['update','delete'];
                    $actionBtn = view('control-buttons',compact('buttons','id','prefix'))->render();
                     return $actionBtn;
                })
                ->make(true);
        }
      $page='topics';
      return view ('admin.topics',compact('page'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required','max:255','unique:topics']
         ]);
        $this->fields['slug']=Helper::slug($request->name);
        Topic::create(array_merge(array_filter($request->all()), $this->fields));
        if ($request->ajax()){
            return response()->json(['response'=>__('message.create',['name'=>'topic'])]);
        }

    }


    public function show(Topic $topic)
    {
        $page="filtered posts";
        $info=WebsiteInfo::first();
        $posts=Post::join('post_topic','post_id','posts.id')
        ->withuserdata()
        //->published()
        ->where('post_topic.topic_id',$topic->id)
        ->latest('posts.created_at')->get();
        $pasts =Post::join('post_topic','post_id','posts.id')
        ->withuserdata()
        //->published()
        ->where('post_topic.topic_id',$topic->id)
        ->mostviewed()->get();

        $topic_name=$topic->name;

        $topics = Topic::all();
        $side='user.';
        $username='username';
        $messages=$messagecount=$alertcount=$alerts='';
                $check=auth()->user()??'';
                $username=$check->username??'newuser';
                $profileimage=$check->profile_image??'no_image';
                $side='user.';
                if(!session()->has('website_name')||session()->missing('website_name')||!session()->has('website_logo')||session()->missing('website_logo')){
                    session(['website_name'=>$info->website_name]);
                    session(['website_logo'=>$info->website_logo]);
                    session(['website_icon'=>$info->website_logo]);
                }
                $website_name=session()->has('website_name')?session('website_name'):'';
                $website_logo=session()->has('website_logo')?session('website_logo'):'';

        if(auth()->user()){

            $id=auth()->id();

            $messages=Helper::messages($id);

            $messagecount=OfflineMessage::user_id($id)->read()->count();

            $alertcount=Alert::user_id($id)->read()->count();

           $alerts=Helper::alerts($id);
        }
        return view('filtered_posts',
                                compact(
                                    'page','topic_name','posts','pasts','info','topics','website_name','website_logo','alertcount','alerts','side',
                                    'messagecount','messages','username','profileimage'
                                    )
                                );
    }


    public function edit(Topic $topic)
    {
         return response()->json($topic);
    }

    public function update(Request $request, Topic $topic)
    {
        $this->validate($request, [
            'name' => ['required','max:255',Rule::unique('topics')->ignore($topic)]
         ]);

         $this->fields['slug']=Helper::slug($request->name);

        $topic->update(array_merge(array_filter($request->all()), $this->fields));
        if ($request->ajax()){
            return response()->json(['response'=>__('message.update',['name'=>'topic'])]);
        }


    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        if ($request->ajax()){
            return response()->json(['response'=>__('message.delete',['name'=>'topic'])]);
        }

    }
}
