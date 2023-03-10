<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Alert;
use App\Models\OfflineMessage;
class Helper
{
    public static function instance()
    {
        return new Helper();
    }

    public static function progress_points($value=null){
        $value=$value?$value:auth()->id();
        $row=User::find($value);
        $points=25;
        if(!empty($row->profile_image)){$points=$points+20;}
        if(!empty($row->first_name)){$points=$points+5;}
        if(!empty($row->last_name)){$points=$points+5;}
        if((!empty($row->sex)) && $row['sex']!="not mentioned"){$points=$points+2;}
        if(!empty($row->facebook)){$points=$points+10;}
        if(!empty($row->twitter))	{$points=$points+10;}
        if(!empty($row->googleplus)){$points=$points+10;}
        if(($row->userlog->verified=='yes')){$points=$points+5;}
        if(($row->userlog->hash_method=='2')){$points=$points+5;}
        return $points;
    }
    public static function total($table=null,$column=null,$placeholder=null,$value=null,$join=array(),$attr=array())
	{
        $query = DB::table($table);
        $compare='=';
        $placeholder=self::check_array($placeholder);
		$value=self::check_array($value);
		if($join)
        foreach($join as $key=> $joinattribute)
        {
            $query->leftjoin($joinattribute[0],$joinattribute[1],$joinattribute[2]);
        }
        if($placeholder)
        foreach($placeholder as $key=> $columnname)
        {
            if($key==='raw')
                $query->whereRaw("$columnname".(is_array($compare)?$compare[$key]:$compare)."'".$value[$key] ."'".(isset($attr['interval'])?$attr['interval']:' '));
            else
                $query->where($columnname, is_array($compare)?$compare[$key]:$compare, $value[$key]);
        }
        if(isset($attr['selectraw']))
            $query->selectRaw($attr['selectraw']);
        if(isset($attr['select']))
            foreach($attr['select'] as $key=> $columnname){
                $query->addselect($columnname);
            }
		if(isset($attr['groupby']))
            $query->groupby($attr['groupby']);
		if(isset($attr['groupby']))
            return $query->get();
        if(isset($attr['rawsum']))
            return $query->first();
		return $query->sum($column);
	}

    private static function check_array($value){
		if (is_array($value))
			return $value;
		return array($value);
	}
    public static function CountTable($table,$condition=null,$value=null,$compare='=',$attr=array()){
        $query = DB::table($table);
        $condition=self::check_array($condition);
        $value=self::check_array($value);
        if($condition)
        foreach($condition as $key=> $column)
        {
            if($key==='raw')
                $query->whereRaw("$column".(is_array($compare)?$compare[$key]:$compare)."'".$value[$key] ."'".(isset($attr['interval'])?$attr['interval']:' '));
            else
                $query->where($column, is_array($compare)?$compare[$key]:$compare, $value[$key]);
        }
       //return $query->toSql();
        return $query->count();
    }

    static function slug(String $string,$symbol='-')
	{
		$string = strtolower($string);
		$slug = preg_replace('/[^A-Za-z0-9-]+/', $symbol, $string);
		return $slug;
    }

    function compressImage($source, $storepath=USER_IMAGES_DIR, $quality=75){
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/bmp')
		$image = imagecreatefrombmp($source);
		elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($source);
		else
			return  false;
		if ($info['mime'] == 'image/png')
		$result=imagepng($image, $storepath, 9);
		else
		$result=imagejpeg($image, $storepath, $quality);
		imagedestroy($image);
		return $result;
    }
    static function activitylogs($user_id, $text,$type=null,$object=null,$parent_id=null,$parent_text=null,$child_text=null){

		$keys=array('user_id', 'text','type','activity_object','parent_activity_id',
        'parent_activity_text','child_activity_text');
        $values=array($user_id, $text,$type,$object,$parent_id,$parent_text,$child_text);
        $data=array_combine($keys, $values);
        ActivityLog::create($data);
	}

    static function get_datetime()
	{
		return date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
    }

    static function format_number($number) {


        if ($number < 900) {
            // 0 - 900
            $precision=1;
            $number_format = number_format($number, $precision);
            $suffix = '';
        } else if ($number < 900000) {
            // 0.9k-850k
            $precision=2;
            $number_format = number_format($number / 1000, $precision);
            $suffix = 'K';
        } else if ($number < 900000000) {
            // 0.9m-850m
            $precision=3;
            $number_format = number_format($number / 1000000, $precision);
            $suffix = 'M';
        } else if ($number < 900000000000) {
            // 0.9b-850b
            $precision=3;
            $number_format = number_format($number / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $precision=3;
            $number_format = number_format($number / 1000000000000, $precision);
            $suffix = 'T';
        }
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $number_format = str_replace( $dotzero, '', $number_format );
        }
        return $number_format . $suffix;
    }
	function make_avatar($character,$storepath=USER_IMAGES_DIR,$extension='png')
	{
		$image_name=time() . '.'.$extension;
		$path = $storepath. $image_name;
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
		imagecolorallocate($image, $red, $green, $blue);
		$textcolor = imagecolorallocate($image, 255,255,255);
		imagettftext($image, 100, 0, 55, 150, $textcolor,FONTS_DIR.'arial.ttf', $character);
		imagepng($image, $path);
		imagedestroy($image);
		return $image_name;
    }

    static function all_chat_data($message_user_id=null,$id=null){
            $userid=$message_user_id;
            $messages=  OfflineMessage::leftjoin('users','users.id','offline_messages.user_id')
            ->where('offline_messages.user_id',$id)
            ->where('offline_messages.sender_id',$userid)
            ->orWhere(function($query)
            use($userid,$id)
            {
                $query->where('offline_messages.user_id',$userid)
                        ->where('offline_messages.sender_id',$id);
            })
            ->orderBy('sent_on','asc')
            //->latest('sent_on','asc')
            ->select('*','offline_messages.id as id')
            ->get();
        return $messages;
    }

    static function get_conversation($id){
        return OfflineMessage::join(OfflineMessage::raw('(SELECT user_id,sender_id,MAX(sent_on)
            AS recent_date FROM offline_messages WHERE offline_messages.user_id='.$id.' OR
            offline_messages.sender_id='.$id.' GROUP BY user_id,sender_id) AS Latest'),
            function($join) {
        $join->on('offline_messages.sent_on','=','Latest.recent_date')
        ->on('offline_messages.user_id','=','Latest.user_id')
        ->on('offline_messages.sender_id','=','Latest.sender_id'); })
        ->leftJoin('message_log',function($join) {
            $join->on('Latest.user_id','=','message_log.user_id')
        ->on('Latest.sender_id','=','message_log.sender_id'); })
        ->leftJoin('users',function($join) {
            $join->on('Latest.sender_id','=','users.id'); })
        ->select("*","offline_messages.id as id,users.username as username,users.profile_image as profile_image")
        ->orderBy('offline_messages.sent_on','DESC')
        ->limit(5)
        ->get();

    }
        static function messages($id){
            //$id=999;
            return OfflineMessage::user_id($id)
            ->leftjoin('users','users.id','offline_messages.sender_id')
            ->limit(5)
            ->latest('offline_messages.sent_on')
            ->paginate();
        }

        static function alerts($id){
           // $id=999;
            return Alert::user_id($id)->limit(5)->latest()->paginate();
        }


        static function AllVisitCount($return=null,$filename="counter.txt"){
            if($return && session()->has('hasVisited'))
                return;
            $counter_file_path = storage_path().'/'.$filename;
            if(!is_dir($counter_file_path) && !file_exists($counter_file_path)) {
            $file = fopen($counter_file_path, "w");
            fwrite($file,"0");
            fclose($file);
            }
            $file = fopen($counter_file_path,"r");
            $counterValue = fread($file, filesize($counter_file_path));
            fclose($file);
            if(!session()->has('hasVisited')){
            session(['hasVisited' => 'yes']);
            $counterValue++;
            $file = fopen($counter_file_path, "w");
            fwrite($file, $counterValue);
            fclose($file);
            }
            return self::format_number($counterValue);
        }


}
