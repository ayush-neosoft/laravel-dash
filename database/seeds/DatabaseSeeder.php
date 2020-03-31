<?php

use App\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function ($user) {
            $user->details()->save(factory(UserDetail::class)->make());
            // $posts = factory(Post::class, 3)->make();
            // $user->posts()->saveMany($posts);
            // foreach($posts as $post) {
            //     $comments = factory(Comment::class, 5)->make();
            //     $post->comments()->saveMany($comments);

            //     $tags = factory(Tag::class, 3)->make();
            //     $post->tags()->saveMany($tags);
            // };
        });  
    }
}
