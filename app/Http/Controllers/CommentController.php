<?php

namespace App\Http\Controllers;

use App\Story;
use App\comment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();

        return view("HackerNews.comments.home", compact('comments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $story_comments = Story::all()->pluck('kids');

        $client = new Client(array());

        foreach($story_comments as $comment)
        {
            $comment_data = json_decode($comment);

            foreach($comment_data as $value)
            {

                $comment_response = $client->get("https://hacker-news.firebaseio.com/v0/item/" . $value . '.json?print=pretty&orderBy="$priority"&limitToFirst=500');

                $comments_data = json_decode($comment_response->getBody(), true);

                if(!empty($comments_data))
                {

                    $comments = array(

                        'story_id'      => $value,
                        'username'      => isset($comments_data['by']) ? $comments_data['by']:" ",
                        'comments'      => isset($comments_data['text']) ? $comments_data['text'] : " ",
                        'item_type'     => isset($comments_data['type']) ? $comments_data['type']: " ",
                        'time_stamp'    => isset($comments_data['time']) ? $comments_data['time']: " ",
                        'parent'        => isset($comments_data['parent']) ? $comments_data['parent']: " ",
                    );

                    $db_comments = DB::table('comments')->where('id', '=', $value)->first();

                    if(empty($db_comments)){

                        DB::table('comments')->insert($comments);

                    }else{

                        DB::table('comments')->where('id', $value)->update($comments);
                    }
                }
            }

        }


        return "Comments Saved";
    }


}
