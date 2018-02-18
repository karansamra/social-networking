<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Notification;

class NotificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the notification for this user.

        $notif = Notification::leftJoin('posts', function($join) {
            $join->on('posts.id', '=', 'notifications.post_id');
                })
            ->leftJoin('users', function($join) {
                   $join->on('posts.user_id', '=', 'users.id');
                })
            ->where('notifications.to_user', Auth::id())
            ->orderBy('notifications.created_at', 'desc')
            ->take(50)
            ->get(['notifications.id as notificationsId',
                'notifications.type as notificationsType',
                'notifications.to_user as notificationsToUser',
                'notifications.post_id as notificationsPostId',
                'notifications.read as notificationsRead',
                'notifications.created_at as notificationsDatetime',
                'posts.id as postId',
                'posts.txt as postTxt',
                'users.name as userName',
                'users.email as userEmail']);

        $data = [];
        if($notif->count()) {
            foreach ($notif as $key=>$nt) {
                switch ($nt->notificationsType) {
                    case 1:
                        $data[$key]['txt'] = $nt->userName." has posted a Post";
                        $data[$key]['notificationsId'] = $nt->notificationsId;
                        $data[$key]['notificationsPostId'] = $nt->notificationsPostId;
                        $data[$key]['notificationsRead'] = $nt->notificationsRead;
                        $data[$key]['notificationsDatetime'] = $nt->notificationsDatetime;
                        if ($nt->postTxt) {
                            $data[$key]['postTxt'] = self::getCroppedText($nt->postTxt, 100);
                        }
                        break;
                }
            }
        }
        return view('notif-list')->with('data', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notif = Notification::find($id);
        $notif->read = 1;
        $notif->save();
        return response()->json(1);
    }

    /**
     * Returns broken string with symbol (...),
     * if length exceeds.
     *
     * @param string $str
     * @param integer $len
     * @param boolean $tail [optional]
     * @param string $tail_str [optional](by default it is "...")
     * @author Jaskaran Singh
     * @version 1.0
     */
    public static function getCroppedText($str, $len, $tail = true, $tail_str = "...")
    {
        if ($tail):
            $dot_dot_dot = $tail_str;
        else:
            $dot_dot_dot = "";
        endif;
        if (strlen(trim($str)) > $len + 1):return utf8_decode(substr($str, 0, $len)) . $dot_dot_dot;
        else:return utf8_decode($str);
        endif;
    }

}
