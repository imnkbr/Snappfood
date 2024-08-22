<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(string $name)
    {
        $comments = Comment::where('request_for_deleting' , false)
        ->where('is_confirmed' , false)
        ->get();
        $restaurant = Restaurant::where('name' , $name)->first();

        return view('restaurant.comment')->with([
            'restaurant' => $restaurant ,
            'comments' => $comments
            ]);
    }

     public function delete(string $name,string $id)
    {
        $comments = Comment::where('request_for_deleting' , false)
        ->where('is_confirmed' , false)
        ->get();
        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('commentDelete' , $restaurant);

        Comment::find($id)->update([
            'request_for_deleting' => true
        ]);

        return redirect("restaurant/$restaurant->name/comments")->with([
            'restaurant' => $restaurant ,
            'comments' => $comments
            ]);

    }

    public function response(string $name,string $id, Request $request)
    {
        $comments = Comment::where('request_for_deleting' , false)
        ->where('is_confirmed' , false)
        ->get();

        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('commentUpdate' , $restaurant);

        Comment::find($id)->update([
            'response' => $request->input('response')
        ]);

        return redirect("restaurant/$restaurant->name/comments")->with([
            'restaurant' => $restaurant ,
            'comments' => $comments,
        ]);
    }

    public function confirm(string $name, string $id)
    {
        $comments = Comment::where('request_for_deleting' , false)
        ->where('is_confirmed' , false)
        ->get();

        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('commentConfirm' , $restaurant);

        Comment::find($id)->update([
            'is_confirmed' => true
        ]);

        return redirect("restaurant/$restaurant->name/comments")->with([
            'restaurant' => $restaurant ,
            'comments' => $comments
        ]);

    }



}
