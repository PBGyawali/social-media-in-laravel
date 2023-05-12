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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public array $fields = [];
    public $websiteInfo = [];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Post::leftjoin('users','users.id','posts.user_id')
            ->select('*','posts.id as id','posts.updated_at as updated_at');
            if($request->from_date!=''&& $request->to_date!='')
                $query->whereBetween('posts.created_at',[$request->from_date, $request->to_date]);
                //modify query if the userytype is not editor or above or request url is not admin/*
            if(!auth()->user()->is_editor() ||!$request->is('admin/*') )
                $query->where('posts.user_id',auth()->id());
             $data=$query->get();
             //use datatables to edit the extracted column data
            return DataTables::of($data)
            //adding your own column data
                ->addColumn('action', function($data){
                    // primary key of the row
                    $id=$data->id;
                    // status of the row
                    $status=$data->post_status;
                    // data to display on modal, tables
                    $prefix="post";
                    $editurl=url()->current()==route('article')?route('article.edit',$data->id):null;
                    // optional button to display
                    $buttons=['edit','delete','status'];
                    $actionBtn = view('control-buttons',compact('buttons','id','status','prefix','editurl'))->render();
                    return $actionBtn;
                })
                //edit extracted column data
                ->editColumn('post_status', function ($data) {
                    $status=$data->post_status;
                    $icon='check';
                    $class='text-danger';                          
                    if($data->is_published()){
                        $class= 'text-success';
                        $icon='check';
                    }                       
                      return view('status_icon',compact('icon','class'))->render();
                })
                ->editColumn('title', function ($data) {
                    $link=route('single_post',$data->slug);
                    $title=$data->title;
                    return view('link',compact('link','title'))->render();                    
                 })
                 ->editColumn('anonymous', function ($data) {
                        if(!auth()->user()->is_admin())
                            return;
                        elseif($data->is_anonymous()){
                            $icon='check';
                            $class='text-success';
                        }                
                        else{
                            $icon='times';
                            $class='text-danger';                   
                        }                  
                     return view('status_icon',compact('icon','class'))->render();
                    })
                ->make(true);
        }
        $page='posts';
        $topics=Topic::all();
        $view='admin.posts';
        //if the name of requesting route url is article then show default post instead of admin posts page
        if($request->route()->named('article')){
            $view=$page;
        }        
        return view($view,compact('topics'));
    }

    public function create(Request $request)
    {
        $page='post';
        $topics=Topic::all();
        return view( $page,compact('page','topics'));
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
        PostTopic::create(array_merge($request->only('topic_id'), ['post_id' => $post->id]));
        Helper::activitylog(auth()->id(),'create','post',$post->id,$post->title);
        if ($request->ajax()){
            return response()->json(['response'=>__('message.create',['name'=>'post'])]);
        }
        return back()->with('success', __('message.create',['name'=>'post']));

    }

    public function show(Request $request,$slug=null)
    {
        $page='home';
        Helper::AllVisitCount(true);
        //defining default values as empty string
        $count=$user=$check=$topics=$id='';
        //defining default values as empty arrays
        $replies=$comments= $commentscount=$userdisliked=$userfollowed=
        $Dislikes=$userLiked=$Likes=$userdata=$user_id=[];
        $alerts=$request->alerts??[];
        $info=$request->info??[];
        $messages=$request->messages??[];
        $messagecount=$request->messagecount??[];
        $alertcount=$request->alertcount??[];
        //if the request is not sent through ajax request
        if(!$request->ajax()){
            $topics=Topic::all();
        }
        // Get the Posts and eager load the related User from the defined Userdata scope in post model
        $query=Post::withuserdata();
        if(auth()->user()){
            $check=$user=auth()->user();
            $user_id=$id=$user->id;
            
        }$info=WebsiteInfo::first();
        //if user is authenticated and request is not made through ajax
        if(auth()->user() && !$request->ajax()){
            $userdata=User::all();
        }
        if($request->route()->named('single_post')){
            $query->where('posts.slug',$slug);
            $page='single_post';
            $info=WebsiteInfo::first();   
            if(auth()->user()){
                $messages=Helper::messages($id);
                $messagecount=OfflineMessage::user_id($id)->read()->count();
                $alerts=Helper::alerts($id);
                $alertcount=Alert::user_id($id)->read()->count();                
            }
                
        }
        else{
            $query->published();
            $count=Post::published()->count();
        }
        $posts=$query->latest('posts.created_at')->paginate(5);
        foreach($posts as $key=> $post) {
            //get the lastest comment from the post together with the user data of the commenter
            $comments[$key]=Comment::posts($post->id)->withuserdata()->latest('comments.created_at')->get();
            foreach( $comments[$key] as $index=> $comment) {
                $replies[$index]=Reply::comments($comment->id)->withuserdata()
                // ->latest('replies.created_at')
                ->get();
            }
            $commentscount[$key]=Comment::posts($post->id)->count();
            if(auth()->user()){
                // check if the user ha disliked the post
                $userdisliked[$key]=RatingInfo::posts($post->id)->rated('dislike')->user_id($id)->count();

                // check if the user has liked the post
                $userLiked[$key]=RatingInfo::posts($post->id)->rated('like')->user_id($id)->count();

                // check if the user has followed the post creator
                $userfollowed[$key]=Follower::receiver($post->user_id)->sender($id)->count();
            }
            // count distinct dislikes of the post
            $Dislikes[$key]=RatingInfo::select('user_id')->distinct()
            ->posts($post->id)->rated('dislike')->count('user_id');

            // count distinct likes of the post
            $Likes[$key]=RatingInfo::select('user_id')->distinct()
            ->posts($post->id)->rated('like')->count('user_id');
        }
        if($request->ajax())
        //if the user is users scrolled down and wants to see more posts
            $page='moredata';
        return view($page,compact( 'page','topics','info',
                                    'alertcount','messagecount','user_id','messages','alerts',
                                    'count','posts','comments',
                                    'commentscount','userdisliked','userfollowed',
                                    'userLiked','Dislikes','Likes','replies','user','userdata','check','id'
                                   )
                    );
    }

    public function edit(Request $request,Post $post)
    {
        if ($request->ajax()) {
            $post->topic_id=$post->topic->id;
            return response()->json($post);
        }
        $page='post';
        $topics=Topic::all();
        return view( $page,compact('page','topics','post'));
    }

    public function update(Request $request, Post $post)
    {
       if($request->hasAny('title','body')){
            $this->validate($request, [
                'title' => ['required','max:255',Rule::unique('posts')->ignore($post)],
                //'body' => ['required'],
                'topic_id' => ['required','integer'],
                'featured_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
                 ]);
            $this->fields=[
                'post_status'=> $request->post_status??'inactive',
                'anonymous' => $request->anonymous??'inactive',
                ];
        }
        if($request->has('title')){
            $this->fields['slug']=Helper::slug($request->title);
        }
        if($request->hasFile('featured_image')){
            $old_image=$post->getRawOriginal('image');
            $this->fields['image']=basename($request->file('featured_image')->store('public/images/post_images/'));
        }
        $fields['post_id']=$post->id;  

         // transaction is needed to rollback any changes if one of the code fails
         DB::beginTransaction();
         try {
            $post->update(array_filter(array_merge($request->all(),$this->fields)));
            $post->posttopic()->update(array_merge($request->only('topic_id'),$fields));
            Helper::activitylog(auth()->id(),'update','post',$post->id,$post->title);

            if($post->wasChanged('image') ){
                if($old_image)
                Storage::delete('public/images/post_images/'.$old_image);
            }
             
             if ($request->ajax()){
                return response()->json(['response'=>__('message.update',['name'=>'post'])]);
            }
            return back()->with('success', __('message.update',['name'=>'post']));
         } catch (\Exception $e) {
             DB::rollBack();
             if($this->fields['image']){
                    Storage::delete('public/images/post_images/'.$this->fields['image']);
             }
             if ($request->ajax()){
                return response()->json(['response'=>__('message.error.update',['reason'=>$e->getMessage()])]);
            }
            return back()->with('error', __('message.error.update',['name'=>'post']));
               //Handle the exception    
         }
    }

    public function destroy(Request $request,Post $post)
    {
       $post->replies->each->delete();
        $post->comments->each->delete();
        //if post has related entry in topic table, delete
        if($post->posttopic)
            $post->posttopic->delete();
        $post->delete();
        $postname=$post->title;
        Helper::activitylog(auth()->id(),'delete','post',$post->id,$postname);
        if ($request->ajax()){
            return response()->json(['response'=>__('message.delete',['name'=>'post'])]);
        }
        return back()->with('success', __('message.delete',['name'=>'post']));
    }
}
