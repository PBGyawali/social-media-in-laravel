<?php

namespace App\Http\Controllers;

use App\Models\OfflineMessage;
use App\Models\Alert;
use App\Models\WebsiteInfo;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helper\Helper;
use Illuminate\Support\Str;
use App\Models\Topic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;


class DashboardController extends Controller
{
    protected $id;
    public function __construct(){
        if (!request()->ajax()){
            $this->id=auth()->id();
        }
    }

    public function index(Request $request)
    {
        $info=WebsiteInfo::first();
        // all month names of past 12 month
        $fullmonth=$this->fullmonth();
        $fullmonthvalue=$this->fullmonthvalue();
        // limited month names since start of the year
        $month=$this->month();        
        $monthvalue=$this->monthvalue();
        Helper::AllVisitCount(true);
        $progresspoints=Helper::progress_points();
        $follow_requests=$this->follow_requests();
        $UserPublishedPosts=$this->UserPublishedPosts();
        $UserUnpublishedPosts=$this->UserUnPublishedPosts();
        $totalpostviews=$this->totalpostviews();
        $topics=Topic::all();
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        $page='dashboard';
        return view('dashboard',compact('info','page',
        'progresspoints',
        'fullmonthvalue','fullmonth','month','monthvalue','follow_requests',
        'UserPublishedPosts','UserUnPublishedPosts','totalpostviews','topics'
        ,'messages','messagecount','alertcount','alerts'
        )
        );
    }

    public function create(Request $request)
    {
        $fullmonth=$this->fullmonth();
        $month=$this->month();
        $fullmonthvalue=$this->fullmonthvalue();
        $monthvalue=$this->monthvalue();
        $progresspoints=Helper::progress_points();
        $follow_requests=$this->follow_requests();
        $UserPublishedPosts=$this->UserPublishedPosts();
        $UserUnpublishedPosts=$this->UserUnPublishedPosts();
        $totalpostviews=$this->totalpostviews();
        $AllUsers=Helper::format_number(User::count());
        $AllPublishedPosts= $this->AllPublishedPosts();
        $AllUnpublishedPosts=$this->AllUnPublishedPosts();
        $UnverifiedEmail=$this->UnverifiedEmail();
        $UnverifiedProfile= $this->UnverifiedProfile();
        $AllUnresolvedTickets= $this->AllUnResolvedTickets();
        $AllVisitCount= Helper::AllVisitCount();
        $target=$this->usertarget();
        $visitor_sources=$this->visitor_sources();
        $id=auth()->id();
        $visitor_sources_count=$this->visitor_sources_count();        
        $page='dashboard';
        return view('admin.index',compact('page',
            'progresspoints',
            'fullmonthvalue','fullmonth','month','monthvalue','follow_requests',
            'UserPublishedPosts','UserUnPublishedPosts','totalpostviews',   'AllUsers',
            'AllPublishedPosts','AllUnPublishedPosts','UnverifiedEmail','UnverifiedProfile',
            'AllUnResolvedTickets','AllVisitCount','target','visitor_sources','visitor_sources_count'
            )
        );
    }

    public function show()
    {
        $info=WebsiteInfo::first();
        $topics=Topic::all();
        //if(!session()->has('guest'))
          //  abort(404);
        $page='welcome';
        $posts=Post::withuserdata()->latest('posts.created_at')->take(9)->get();
        Helper::AllVisitCount(true);
        return view('welcome',compact('page','posts','topics','info' )
        );
    }

     public function edit(Request $request)
     {	$labels=$this->fullmonthhtml();
		$data=$this->fullmonthvaluehtml();
        return response()->json(compact('labels','data'));
     }

	function AllPublishedPosts(){
		return $this->CountTable('posts','post_status','active');
	}

	function AllUnPublishedPosts(){
		return $this->CountTable('posts','post_status','inactive');
	}

	function UnverifiedEmail(){
		return $this->CountTable('userlogs','email_status','inactive');
	}

	function UnverifiedProfile(){
		return $this->CountTable('userlogs','verified','no');
	}

	function AllUnResolvedTickets(){
        return  Ticket::whereIn('status',['open','pending','on-hold'])->count();
	}

	function follow_requests(){
		return $this->CountTable('followers','receiver_id',$this->id);
	}

	function UserPublishedPosts(){
		return $this->countPosts('active');
	}

	function UserUnPublishedPosts(){
		return $this->countPosts('inactive');
	}

	function countPosts($value){
			return $this->CountTable('posts',array('post_status','user_id'),array($value,$this->id));
	}


    // limited month names
	function month()	{
		return $this->loopmonth('&quot;');
	}

    // limited month names for javascript or ajax
	function monthhtml()	{
		return $this->loopmonth();
	}

    // all month names
	function fullmonth(){
		return $this->loopfullmonth("&quot;");
	}

    // all month names for javascript or ajax
	function fullmonthhtml(){
		return $this->loopfullmonth();
    }

    function loopfullmonth($quote=null)
	{	
        $value=array();
		$startpos = date('n');
		for($i=1;$i<=12;$i++)
			array_push($value,$quote .substr(date('F', mktime(0, 0, 0, ($i), 2, date('Y'))),0,3).$quote);
		$output = array_merge(array_slice($value,$startpos), array_slice($value, 0, $startpos));
		if ($quote)
			return implode(',',$output);
		return $output;
    }

	function loopmonth($quote=null,$start=1){
		$months=array();
        $startpos = date('n');
		for($i=$start;$i<=$startpos;$i++)
			array_push($months,$quote.substr(date('F', mktime(0, 0, 0, ($i), 2, date('Y'))),0,3).$quote);
		if ($quote)
			return  implode(',',$months);
		return  $months;
	}

    /**
    * Returns the current month value as an array, wrapped in a given quote if specified.
    * @return array|string - The month value as an array, or as a comma-separated string if a quote is specified.
    */
    function monthvalue(){
        return $this->loopmonthvalue('&quot;');
    }

    /**
    * Returns the current month value as an HTML-encoded array.
    * @return array - The month value as an HTML-encoded array.
    *mainly for ajax response as it does not understand escaped html
    */
    function monthvaluehtml(){
        return $this->loopmonthvalue();
    }

    /**
    * Loops through the month values and returns them as an array, wrapped in a given quote if specified.
    * @param string|null $quote - The quote to wrap the month values in.
    * @return array|string - The month values as an array, or as a comma-separated string if a quote is specified.
    */
    function loopmonthvalue($quote=null){
        $value=$this->loopvalue(date('n'),$quote);
        if ($quote)
            return  implode(',',$value);
        return  $value;
    }

    /**
    * Returns the full name of the current month as an array, wrapped in a given quote if specified.
    * @return array|string - The full name of the current month as an array, or as a comma-separated string if a quote is specified.
    */
    function fullmonthvalue(){
        return $this->loopfullmonthvalue("&quot;");
    }

    /**
    * Returns the full name of the current month as an HTML-encoded array.
    * @return array - The full name of the current month as an HTML-encoded array.
    *mainly for ajax response as it does not understand escaped html
    */
    function fullmonthvaluehtml(){
        return $this->loopfullmonthvalue();
    }



        function loopfullmonthvalue($quote=null){
            $value=$this->loopvalue(12,$quote);
            $startpos = date('n');
            $output = array_merge(array_slice($value,$startpos), array_slice($value, 0, $startpos));
            if ($quote)
                return implode(',',$output);
            return $output;
        }

	function loopvalue($maxvalue,$quote=null){
		$value=array();
		for($i=1;$i<=$maxvalue;$i++)
			array_push($value,$quote .$this->countPostsPerMonth($i).$quote);
		return  $value;
	}

	function countPostsPerMonth($value){
        $condition['raw']= 'MONTH(created_at)';
        $val['raw']=$value;
			return Helper::CountTable('posts', $condition,$val);
	}

    function totalpostviews(){
        return $this->total('posts','views','user_id',$this->id);
    }

    function usertarget(){
        $users=User::count();
        $target=WebsiteInfo::first()->user_target;
        if($target==0)return 0;
        return number_format(($users/$target)*100);
    }

    function visitor_sources_count($quote="&quot;"){
        $sources=$this->visitor_sources('',false);
        $value=array();
        foreach ($sources as $source)
            array_push($value,$quote .$this->total("visitor_log",$source).$quote);
        return  implode(',',$value);
    }

    function visitor_sources($quote="&quot;",$count=true){
        $columns= Schema::getColumnListing('visitor_log');
        $ignoredColumns = ['log_id', 'post_id', 'owner_id'];
        $sources = array_diff($columns, $ignoredColumns);
        if (!$count)
            return $sources;
        $value=array();
        foreach ($sources as $source)
            array_push($value,$quote .$source.$quote);
        return  implode(',',$value);
    }

    function CountTable($table,$condition=null,$value=null,$compare='=',$attr=array()){
        $value= Helper::CountTable($table,$condition,$value,$compare,$attr);
        return Helper::format_number($value);
     }
     
    function total($table=null,$column=null,$placeholder=null,$value=null,$join=array(),$attr=array()){
            $value=Helper::total($table,$column,$placeholder,$value,$join,$attr);
            return Helper::format_number($value);
    }

    }

