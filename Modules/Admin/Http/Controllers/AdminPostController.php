<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Modules\Admin\Traits\AdminUtil;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Http\Requests\StorePostRequest;

class AdminPostController extends Controller
{
    use AdminUtil;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin::posts.index');
    }

    /**
     * Retrieve Post data as datatable
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        return response()->json(Post::generateDataTable($request));
    }

    /**
     * Activate specific post whether active or not
     *
     * @param  Post $post
     * @return void
     */
    public function activate(Post $post)
    {
        if ($post->isApproved())
        {
            $post->update([
                'approved' => false
            ]);

        } else {
            $post->update([
                'approved' => true
            ]);
        }

        return redirect()->route('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->whereNull('parent_id')->get();
        
        return view('admin::posts.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Admin\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $inputs = $request->except(['images']);
        
        if ($request->file('image')) {
            $imageUrl = $this->uploadImages($request->image, '/images/posts');
        }

        if (! $request->filled('slug')) {
            $inputs['slug'] = $this->createSlug($this->title);
        }

        $post = auth()->user()->posts()->create(
            array_merge($inputs, ['images' => $imageUrl])
        );

        $post->tags()->sync($request->input('tags'));
        $post->categories()->sync($request->input('categories'));

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::latest()->get();
        $categories = Category::whereNull('parent_id')->get();

        return view('admin::posts.edit', compact('tags', 'categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $inputs = $request->all();

        if (! $request->filled('slug')) {
            $inputs['slug'] = $this->createSlug($request->title);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('/' . $post->images);
            $inputs['images'] = $this->uploadImages($request->file('image'), '/images/posts');

        } else {
            $inputs['images'] = $post->images;
        }

        $post->update($inputs);

        $post->tags()->sync($request->input('tags'));
        $post->categories()->sync($request->input('categories'));

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
