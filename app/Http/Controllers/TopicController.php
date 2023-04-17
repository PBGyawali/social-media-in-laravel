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
                $actionBtn='<button type="button"  data-prefix="Topic" title="edit"class="fa fa-edit btn btn-success update"  data-id="'.$data->id .'"> <span class="d-none d-sm-inline-block">EDIT</span> </button>
                &nbsp;
                <button type="button" title="delete" class="fa fa-trash btn btn-danger delete" data-id="'.$data->id .'" > <span class="d-none d-sm-inline-block"> DELETE</span></button>';
                    return $actionBtn;
                })
                ->make(true);
        }
      $page='topics';
      $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
      return view ('admin.topics',compact('page','messages','messagecount','alertcount','alerts'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required','max:255','unique:topics']
         ]);
        $this->fields['slug']=Helper::slug($request->name);
        Topic::create(array_merge(array_filter($request->all()), $this->fields));
        return response()->json(array('response'=>'<div class="alert alert-success">The data was stored!</div>'));
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

        $messages=$messagecount=$alertcount=$alerts='';

        if(auth()->user()){

            $id=auth()->id();

            $messages=Helper::messages($id);

            $messagecount=OfflineMessage::user_id($id)->read()->count();

            $alertcount=Alert::user_id($id)->read()->count();

           $alerts=Helper::alerts($id);
        }

        return view('filtered_posts',
                                compact(
                                    'page','topic_name','posts','pasts','info','topics','messages',
                                    'messagecount','alertcount','alerts'
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

        return response()->json(array('response'=>'<div class="alert alert-success">The data was updated!</div>'));

    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->json(array('response'=>'<div class="alert alert-success">The data was deleted!</div>'));

    }
}
