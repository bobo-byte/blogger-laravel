<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    function home(){
        //loads list of posts available to everyone, even guests
        $data = Post::paginate(5);
        return view('home', ["data" => $data]);
    }


    //gets view with create functionality
    function create(){
        //for test
        $topic_data = Topic::all();
        return view('user.create_post', ["tag_data" => $topic_data]);
    }

    //gets edit view
    function edit(Post $post){
        $tag_data = []; //everything excluding post tags

        foreach($post->topics as $tag){
            if(!Topic::all()->contains("tag", $tag->tag)){
                //not a tag used for this post therefore, add to list.
                array_push($tag_data, $tag);
            }
        }

        return view('user.edit_post', ["tag_data" => $tag_data, "post" => $post, "post_tags" => $post->topics]);
    }


    //get for viewing specific post
    function show(Post $post){

        return view("blog_post", ["post" => $post]);
    }


    //for creating a post
    function store(){
      request()->validate([
           "title" => ['bail','required', 'max:50'],
           "body" => ['required']
       ]);
        //validates


     //adds post
        $post = new Post([
             "title" => request("title"),
             "body" => request("body")
            ]);

        $tags = is_null(request("tags"))  ?  [] : request("tags");       

       Auth::user()->posts()->save($post);

        if(count($tags) > 0){
            foreach($tags as $tag) {
                $topic = Topic::create([
                    "tag" => $tag
                ]);
                $post->topics()->attach($topic->id);
            }
        }

       Auth::user()->refresh();

       return redirect("/dashboard");
    }

    function update(Post $post){

        //TODO: Handle same tag values being fetched back. Basically they should not be added again.

        request()->validate([
            "title" => ['required'],
            "body" => ['required']
        ]);

        $tags = is_null(request("tags"))  ?  [] : request("tags");

        if(count($tags) > 0){
            //add new tags
            foreach($tags as $tag) {
                if(!$post->topics->contains("tag", $tag)){
                    $topic = Topic::create([
                        "tag" => $tag
                    ]);
                    $post->topics()->attach($topic->id);
                }
            }
        }

        //remove old tags if not in the list of tags...
        if(count($post->topics) > 0) {
            //create and array of tags from current post list.
            if(count($tags) > 0){
            $currentTags = [];

            foreach($post->topics as $topic){
                array_push($currentTags, $topic->tag);
            }

            $tagsToDelete = array_diff($currentTags, $tags);

              if(count($tagsToDelete) > 0){
                    foreach($tagsToDelete as $tag) {
                        $postToDetach = $post->topics->where("tag", "=", $tag)->first();
                        //removes post tag relationship from pivot table.
                        $post->topics()->detach($postToDetach->id);
                    }
              }

            }
        }

        $post->update([
            "title" => request('title'),
            "body" => request('body'),
           // "image" => request('banner') //not added yet
        ]);

        $post->save();

        return redirect('/dashboard');
    }


    function delete(Post $post){
        try {
            $post->delete();
        } catch (\Exception $e) {
            return $e;
        }

        return redirect('/dashboard');
    }
}
