<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $option = Comment::create($this->extractData(new Comment(), $request));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return response()->json(["comment" => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateComment(CommentRequest $request, Comment $comment)
    {
        //dd($request->all());
        $comment->update($this->extractData($comment, $request));
        return redirect()->back();
    }


    private function extractData(Comment $comment, CommentRequest $request): array
    {
        //dd($request->all());
        $data = $request->validated();
        /**@var UploadedFile|null $image */
        $image = $request->validated('image');
        if ($image === null || $image->getError()) {
            return $data;
        }
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }
        $data['image'] = $image->store('comment', 'public');
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }
        $comment->delete();
        return redirect()->back();
    }
}
