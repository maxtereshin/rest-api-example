<?php

namespace App\Services\User;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostService
{

    private string $error;

    public function list()
    {
        return Post::all();
    }

    public function get($id)
    {
        $post = Post::find($id);
        if(!$post) {
            $this->error = 'Post not found';
            return false;
        }
        return $post;
    }

    public function add($data)
    {
        Post::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'user_id' => Auth::user()->id,
            'created_at' => now(),
        ]);
        return true;
    }

    public function update($id, $data)
    {
        $post = $this->get($id);
        if(!$post || !$this->checkPolicy('update-post', $post)) {
            return false;
        }
        $post->update($data);
        return true;
    }

    public function delete($id)
    {
        $post = $this->get($id);
        if(!$post || !$this->checkPolicy('delete-post', $post)) {
            return false;
        }
        $post->delete();
        return true;
    }

    public function checkPolicy($method, $post){
//        $response = Gate::inspect($method, $post);
//        if(!$response->allowed()) {
//           $this->error = $response->message();
//           return false;
//        }
//        if(!Gate::allows($method, $post)) {
//            $this->error = 'You are not allowed to perform this action';
//            return false;
//        }
        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }
}