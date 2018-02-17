<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Image;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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
        // Get Posts by user id.
        return response()->json(
            ["message" => "List of Posts", "status" => 1,
                "data" => self::getPostsData(['user_id', Auth::id()], 20)]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get Posted parameters
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Input $input)
    {

        $requestData = Input::all();

        $data = $this->validate($request, [
            'postImage' => 'mimes:jpeg,png,bmp,jpg,gif,tiff |max:10240',
        ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'mimes' => 'Only JPEG, PNG, BMP, JPG, GIF, TIFF are allowed.'
            ]
        );

        // If image and txt both are missing then return error.
        if (!$request->hasFile('postImage') && !trim($requestData['postText'])) {
            return response()->json(
                ["message" => "Either Text or Image is required to create a Post.", "status" => 3]
            );
        }

        try {
            // Save post details into DB.
            $postObj = new Post();
            $postObj->txt = $requestData['postText'];
            $postObj->user_id = Auth::id();
            $postObj->save();

            // Save image if image has been posted along with post.
            if ($request->hasFile('postImage')) {

                // Moving image into the directory.
                $path = $request->postImage->store('images', 'public');

                // Saving the data of the image.
                $imageObj = new Image();
                $imageObj->post_id = $postObj->id;
                $imageObj->name = $path;
                $imageObj->save();
            }
            return response()->json(
                ["message" => "Post has been created.", "status" => 1, "postId" => $postObj->id]
            );
        } catch (Exception $e) {
            return response()->json(
                ["message" => "An error has occurred!", "status" => 3]
            );
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Posts by post id.
        return response()->json(
            ["message" => "Post Detail.", "status" => 1, "data" => self::getPostsData(['posts.id', $id], 1)]
        );
    }

    public function detail($id) {

        // Get Posts by post id.
        return view('post-detail')->with('data',
            self::getPostsData(['posts.id', $id], 1));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * A time difference function that outputs
     * the time passed in facebook's
     * style: 1 day ago, or 4 months ago.
     * if date passed is between 24 hours, then return string such as "12:54 pm"
     *
     * @author Jaskaran Singh [actual author : yasmary at gmail dot com]
     * @param datetime $date [format : "2009-03-04 17:45"]
     * @return string
     * @see http://php.net/manual/en/function.time.php
     */
    public static function nicetime_2($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = \Datetime::createfromformat("Y-m-d H:i:s", $date)->getTimestamp();

        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }

        //if date passed is between 24 hours, then return string such as "12:54 pm"
        $today_max_obj = \Datetime::createfromformat('H:i:s', '23:59:59');
        $today_min_obj = \Datetime::createfromformat('H:i:s', '00:00:00');
        $dateTime_obj = \Datetime::createfromformat('Y-m-d H:i', $date);

        if ($today_max_obj > $dateTime_obj && $dateTime_obj > $today_min_obj) {
            return $dateTime_obj->format("h:i A");
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";

        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

    /**
     * Return posts data.
     * @param $whereColValue
     * @param $limit
     * @return array
     * @version 1.0
     * @author Jaskaran Singh
     */
    private static function getPostsData($whereColValue, $limit) {
        $posts = Post::leftJoin('images', function($join) {
                $join->on('posts.id', '=', 'images.post_id');
            })
            ->leftJoin('users', function($join) {
                $join->on('posts.user_id', '=', 'users.id');
            })
            ->where($whereColValue[0], $whereColValue[1])
            ->orderBy('posts.created_at', 'desc')
            ->take($limit)
            ->get(['posts.id as postId',
                'posts.txt as postTxt',
                'posts.user_id as postsUserId',
                'posts.created_at as postsCreatedAt',
                'users.name as nameOfUser',
                'images.name as imagePath']);

        $resultantArray = [];
        if ($posts->count()) {
            foreach ($posts as $key=>$post) {
                $resultantArray[$key]['postId'] = $post->postId;
                $resultantArray[$key]['postTxt'] = $post->postTxt;
                $resultantArray[$key]['postsUserId'] = $post->postsUserId;
                $resultantArray[$key]['postsCreatedAt'] = self::nicetime_2($post->postsCreatedAt);
                $resultantArray[$key]['nameOfUser'] = $post->nameOfUser;
                if ($post->imagePath) {
                    $resultantArray[$key]['imagePath'] = Storage::url($post->imagePath);
                } else {
                    $resultantArray[$key]['imagePath'] = null;
                }

            }
        }
        return $resultantArray;
    }
}
