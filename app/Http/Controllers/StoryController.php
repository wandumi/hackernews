<?php

namespace App\Http\Controllers;

use App\Story;
use App\comments;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StoryController extends Controller
{

    public function index()
    {

        $stories = Story::all();

        return view("HackerNews.stories.home", compact('stories'));
    }


    public function store()
    {
        $client = new Client();

        $endpoint = 'https://hacker-news.firebaseio.com/v0/beststories.json?print=pretty&orderBy="$priority"&limitToFirst=50';

        $response = $client->get($endpoint);

        $result = $response->getBody();

        $items = json_decode($result, true);

        foreach($items as $id)
        {

            $item_res = $client->get("https://hacker-news.firebaseio.com/v0/item/" . $id . ".json");

            $item_data = json_decode($item_res->getBody(), true);



            if(!empty($item_data))
            {
                $item = array(
                    'id' => $id,
                    'title' => $item_data['title'],
                    'item_type' => $item_data['type'],
                    'username' => $item_data['by'],
                    'score' => $item_data['score'],
                    'time_stamp' => $item_data['time'],
                );


                $item['is_top'] = true;

                // dd($item_data['kids']);

                $item['kids'] = json_encode($item_data['kids'], true);

                $item['description'] = isset($item_data['text']) ? $item_data['text'] : " ";

                $item['url'] = isset($item_data['url']) ? $item_data['url'] : " ";

                $db_item = DB::table('stories')
                    ->where('id', '=', $id)
                    ->first();

                if(empty($db_item)){

                    DB::table('stories')->insert($item);

                }else{

                    DB::table('stories')->where('id', $id)->update($item);
                }
            }

        }



        return "Stories Saved, then Generate the comments or go back to homepage";

    }

    public function show($id)
    {
        $story = Story::findOrFail($id);

        $comments = comments::where('story_id', $story->id)->get();

        return view('HackerNews.stories.show', compact('story', 'comments'));
    }


}
