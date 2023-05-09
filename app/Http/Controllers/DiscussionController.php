<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Discussion;
use App\Models\User;
use App\Models\ReplyDislike;
use App\Models\ReplyLike;
use Telegram;
use App\Models\DiscussionReply;
use App\Notifications\NewTopic;
use App\Notifications\NewReply;

class DiscussionController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $forums = Forum::latest()->get();
        $forum = Forum::find($id);
        return \view('client.new-topic', \compact('forums', 'forum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $notify = 0;

        if ($request->notify && $request->notify == "on") {
            $notify = 1;
        }

        $topic = new Discussion;
        $topic->title = $request->title;
        $topic->desc = $request->desc;
        $topic->forum_id = $request->forum_id;
        $topic->user_id = auth()->id();
        $topic->notify = $notify;

        $topic->save();
        $user = auth()->user();
        $user->increment('rank', 10);
        $latestTopic = Discussion::latest()->first();
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewTopic($latestTopic));
        }
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
            'parse_mode' => 'HTML',
            'text' => '<b>' . auth()->user()->name . "</b>" . " Started a new Discussion " . "<b>" . $request->title . "</b>"
        ]);
        toastr()->success('Discussion Started successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = Discussion::find($id);
        if ($topic) {
            $topic->increment('views', 1);
        }
        return view('client.topic', \compact('topic'));
    }

    /**
     * Save reply to the database
     * Show the form for editing the specified resource.
     */
    public function reply(Request $request, string $id)
    {
        $reply = new DiscussionReply;
        $reply->desc = $request->desc;
        $reply->user_id = auth()->id();
        $reply->discussion_id = $id;
        $discussion = Discussion::find($id);
        $forumId = $discussion->forum->id;
        $url = \URL::to('/forum/overview/' . $forumId);

        $reply->save();

        $user = auth()->user();
        $user->increment('rank', 10);

        $latestReply = DiscussionReply::latest()->first();
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewReply($latestReply));
        }

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
            'parse_mode' => 'HTML',
            'text' => '<b>' . auth()->user()->name . "</b>" . " Replied to the topic " . "<b>" . $discussion->title . " : " . "</b>" . "\n" . $request->desc . "\n" . "<a href='" . $url . "'>Read it here</a>"
        ]);

        toastr()->success('Reply saved successfully!');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reply = DiscussionReply::find($id);
        $reply->delete();

        toastr()->success('Reply deleted successfully!');

        return back();
    }

    public function updates()
    {
        $updates = Telegram::getUpdates();

        dd($updates);
    }
    public function remove(string $id)
    {
        $discussion = Discussion::find($id);
        $discussion->delete();
        toastr()->success('Reply saved successfully!');
        return back();
    }

    public function sort(Request $request)
    {
        if ($request->time_posted == "none" || $request->author == "none" || $request->direction == "none") {
            toastr()->error('Please select at least one sorting criteria!');
            return back();
        }
        $topics = null;

        switch ($topics) {
            case $request->time_posted == "latest":
                $topics = Discussion::latest()->paginate(20);
                break;
                case $request->time_posted == "oldest":
                    $topics = Discussion::oldest()->paginate(20);
                    break;
                    default:
                    toastr()->error('No topics Found!');
                    break;
        }
        return back()->withTopics($topics);
    }

    public function like(string $id)
    {
        $reply = DiscussionReply::find($id);
        $user_id = $reply->id;

        // Check if user has already liked this reply
        $liked = ReplyLike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->first();
        if ($liked) {
            toastr()->warning('You have already liked this reply!');
            return back();
        }

        // Check if user has already disliked this reply
        $disliked = ReplyDislike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->first();
        if ($disliked) {
            $disliked->delete();
            $reply->decrement('dislikes', 1);
        }

        $reply_like = new ReplyLike;
        $reply_like->user_id = auth()->id();
        $reply_like->reply_id = $id;
        $reply_like->save();

        $owner = User::find($user_id);
        $reply->increment('likes', 1);
        $owner->increment('rank', 10);

        toastr()->success('Like saved successfully!');
        return back();
    }

    public function dislike(string $id)
    {
        $reply = DiscussionReply::find($id);
        $user_id = $reply->id;

        // Check if user has already disliked this reply
        $disliked = ReplyDislike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->first();
        if ($disliked) {
            toastr()->warning('You have already disliked this reply!');
            return back();
        }

        // Check if user has already liked this reply
        $liked = ReplyLike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->first();
        if ($liked) {
            $liked->delete();
            $reply->decrement('likes', 1);
        }

        $reply_dislike = new ReplyDislike;
        $reply_dislike->user_id = auth()->id();
        $reply_dislike->reply_id = $id;
        $reply_dislike->save();

        $owner = User::find($user_id);
        $reply->increment('dislikes', 1);
        $owner->decrement('rank', 10);

        toastr()->success('Dislike saved successfully!');
        return back();
    }
}
