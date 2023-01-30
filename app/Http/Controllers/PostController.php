<?php

namespace App\Http\Controllers;

use App\Models\OfflineMessage;
use App\Models\Alert;
use App\Models\Post;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Validation\Rule;
use App\Models\RatingInfo;
use App\Helper\Helper;
use App\Models\PostTopic;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use App\Models\Follower;
use Yajra\DataTables\Facades\DataTables;
class PostController extends Controller
{
    public $websiteInfo=array();
    public $fields=array();

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Post::leftjoin('users','users.id','posts.user_id')
            ->select('*','posts.id as id','posts.updated_at as updated_at');
            if($request->from_date!=''&& $request->to_date!='')
                $query->whereBetween('posts.created_at',[$request->from_date, $request->to_date]);
            if(!auth()->user()->is_editor() ||!$request->is('admin/*') )
                $query->where('posts.user_id',auth()->id());
             $data=$query->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                $actionBtn = '<button type="button"  title="edit"class="fa fa-edit btn btn-primary btn-sm update" data-prefix="Post" data-id="'. $data->id .'"></button>';
                if(url()->current()==route('article'))
                    $actionBtn = '<form  action="'.route('article.edit',$data->id).'" class="userlistform" target="_blank" method="post" >
                    '.csrf_field().'
                    <input type="hidden" name="id" value="'.$data->id.'">
                <button type="submit" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button"  data-id="'.$data->id.'"></button>
                </form>';
                $actionBtn .='
                <button type="button"  title="delete" class="fa fa-trash btn btn-danger btn-sm delete" data-action="delete" data-id="'. $data->id .'"></button>';
                if(auth()->user()->is_admin()){
                    if ($data->is_published())
                        $actionBtn .= '<button type="button"  title="unpublish" class="fa fa-times btn btn-warning btn-sm toggle status" data-prefix="publish" data-status="inactive" data-id="'. $data->id .'"></button>';
                     else
                        $actionBtn .= '<button type="button" title="publish" class="fa fa-eye btn btn-success btn-sm toggle status" data-prefix="publish" data-status="active" data-id="'. $data->id .'"></button>';
                }
                    return $actionBtn;
                })
                ->editColumn('publish_status', function ($data) {
                    $status = '<i class="fa fa-times btn btn-danger"></i>';
                    if($data->is_published())
                        $status = '<i class="fa fa-check btn btn-success"></i>';
                    return $status;
                     })
            ->editColumn('title', function ($data) {
                return '<a 	target="_blank"
								href="'.route('single_post',$data->slug).'">'
									 .$data->title.'
								</a>';
                }) ->editColumn('anonymous', function ($data) {
                        return (!auth()->user()->is_admin())?:($data->is_anonymous()?'<i class="fa fa-check btn btn-success"></i>':'<i class="fa fa-times btn btn-danger"></i>');
                    })
                ->make(true);
        }
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
        $page='posts';
        $topics=Topic::all();
        $info=WebsiteInfo::first();
        $view='admin.posts';
        if($request->route()->named('article')){
            $view=$page;
        }
        return view($view,compact('info','page','topics','messages','messagecount','alertcount','alerts'));
    }
    public function create(Request $request)
    {
        $page='post';
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
        $topics=Topic::all();
        $info=WebsiteInfo::first();
        return view( $page,compact('info','page','topics','messages','messagecount','alertcount','alerts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255',Rule::unique('posts')],
            'body' => ['required'],
            'topic_id' => ['required'],
            'featured_image'=>['required','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
             ]);
        if($request->hasFile('featured_image')){
            $this->fields['image']=basename($request->file('featured_image')->store('public/images/post_images/'));
        }
        $this->fields['slug']=Helper::slug($request->title);
        $post=Post::create(array_merge($request->all(),$this->fields));
        $this->fields['post_id']=$post->id;
        PostTopic::create(array_merge($request->only('topic_id'),$this->fields));
        Helper::activitylogs(auth()->id(), 'You create a','create','post',$post->id,$post->title);
        if ($request->ajax()) {
            return response()->json(array('response'=>'<div class="alert alert-success">The data was stored!</div>'));
        }
        return back()->with('success', '<div class="alert alert-success">The data was stored!</div>');
    }

    public function show(Request $request,$slug=null)
    {
        $page='home';
        Helper::AllVisitCount(true);
        $messages=$messagecount=$alertcount=$alerts=$count=$user=$check=$topics=$info=$id='';
        $replies=$comments= $commentscount=$userdisliked=$userfollowed=
        $Dislikes=$userLiked=$Likes=$userdata=array();
        if(!$request->ajax()){
            $topics=Topic::all();
            $info=WebsiteInfo::first();
        }
        $query=Post::withuserdata();
        if(auth()->user()){
            $check=$user=auth()->user();
            $id=$user->id;
        }
        if(auth()->user() && !$request->ajax()){
            $messages= Helper::messages($id);
            $messagecount=OfflineMessage::user_id($id)->read()->count();
            $alertcount=Alert::user_id($id)->read()->count();
           $alerts=Helper::alerts($id);
            $userdata=User::all();
        }
        if($request->route()->named('single_post')){
            $query->where('posts.slug',$slug);
            $page='single_post';
        }
        else{
            $query->published();
            $count=Post::published()->count();
        }
        $posts=$query->latest('posts.created_at')->paginate(5);
        foreach($posts as $key=> $post) {
            $comments[$key]=Comment::posts($post->id)->withuserdata()->latest('comments.created_at')->get();
            foreach( $comments[$key] as $index=> $comment) {
                $replies[$index]=Reply::comments($comment->id)->withuserdata()->latest('replies.created_at')->get();
            }
            $commentscount[$key]=Comment::posts($post->id)->count();
            if(auth()->user()){
                $userdisliked[$key]=RatingInfo::posts($post->id)
                ->rated('dislike')->user_id($id)->count();
                $userfollowed[$key]=Follower::receiver($post->user_id)->sender($id)->count();
                $userLiked[$key]=RatingInfo::posts($post->id)
                ->rated('like')->user_id($id)->count();
            }
            $Dislikes[$key]=RatingInfo::posts($post->id)->rated('dislike')->count();
            $Likes[$key]=RatingInfo::posts($post->id)->rated('like')->count();
        }
        if($request->ajax())
            $page='moredata';
        return view($page,compact( 'info','page','topics','messages','messagecount',
                                    'alertcount','alerts','count','posts','comments',
                                    'commentscount','userdisliked','userfollowed',
                                    'userLiked','Dislikes','Likes','replies','user','userdata','check','id'
                                   )
                    );
    }

    public function edit(Request $request,Post $post)
    {
        if ($request->ajax()) {
            $data['response']=$post;
            $data['topic']=$post->topic->id;
            return response()->json($data);
        }
        $page='post';
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
        $topics=Topic::all();
        $info=WebsiteInfo::first();
        return view( $page,compact('info','page','topics','messages',
        'messagecount','alertcount','alerts','post'));
    }

    public function update(Request $request, Post $post)
    {
       if($request->hasAny('title','body')){
            $this->validate($request, [
                'title' => ['required','max:255',Rule::unique('posts')->ignore($post)],
                'body' => ['required'],
                'topic_id' => ['required','integer'],
                'featured_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
                 ]);
            $this->fields=[
                'publish_status'=> $request->publish_status??'inactive',
                'anonymous' => $request->anonymous??'inactive',
                ];
        }
        if($request->has('title')){
            $this->fields['slug']=Helper::slug($request->title);
        }
        if($request->hasFile('featured_image')){
            $this->fields['image']=basename($request->file('featured_image')->store('public/images/post_images/'));
        }
        $fields['post_id']=$post->id;
        $post->update(array_merge($request->all(),$this->fields));
        $post->posttopic()->update(array_merge($request->only('topic_id'),$fields));
        Helper::activitylogs(auth()->id(), 'You updated a','update','post',$post->id,$post->title);
        if ($request->ajax()) {
            return response()->json(array('response'=>'<div class="alert alert-success">The data was updated!</div>'));
        }
        return back()->with('success', 'The data was updated!');
    }

    public function destroy(Request $request,Post $post)
    {
       $post->replies->each->delete();
        $post->comments->each->delete();
        if($post->posttopic)
            $post->posttopic->delete();
        $post->delete();
        $postname=$post->title;
        Helper::activitylogs(auth()->id(), 'You deleted a','delete','post',$post->id,$postname);
        if ($request->ajax())
            return response()->json(array('response'=>'<div class="alert alert-success">The data was deleted!</div>'));

        return back()->with('success', '<div class="alert alert-success">The data was deleted!</div>');
    }
}
