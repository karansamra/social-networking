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
        $posts = Post::leftJoin('images', function($join) {
                $join->on('posts.id', '=', 'images.post_id');
            })
            ->where('user_id', 2)
            ->orderBy('posts.created_at', 'desc')
            ->take(20)
            ->get(['posts.id as postId',
                'posts.txt as postTxt',
                'posts.user_id as postsUserId',
                'posts.created_at as postsCreatedAt',
                'images.name as imagePath']);

        $resultantArray = [];
        if ($posts) {
            foreach ($posts as $key=>$post) {
                $resultantArray[$key]['postId'] = $post->postId;
                $resultantArray[$key]['postTxt'] = $post->postTxt;
                $resultantArray[$key]['postsUserId'] = $post->postsUserId;
                $resultantArray[$key]['postsCreatedAt'] = $post->postsCreatedAt;
                if ($post->imagePath) {
                    $resultantArray[$key]['imagePath'] = Storage::url($post->imagePath);
                } else {
                    $resultantArray[$key]['imagePath'] = null;
                }

            }
        }

        return response()->json(
            ["message" => "List of Posts", "status" => 1, "data" => $resultantArray]
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
                ["message" => "Post has been created.", "status" => 1]
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
        //
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
}
