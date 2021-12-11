<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Modules\Cart\Entities\Cart;
use Modules\Comment\Entities\Comment;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function edit(User $user)
    {
        $this->authorize('edit-user', $user);
        return view('edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'password' => 'nullable|string|confirmed',
            'name' => 'required|min:3|max:10',
            'family' => 'required|min:3|max:20',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'numeric|nullable'
        ]);
        if (is_null($data["password"])) {
            unset($data["password"]);
        }
        $user->update($data);
        return redirect('user/profile');
    }
    public function comments(User $user)
    {
        $comments = $user->comments;
        return view('comments', compact('comments'));
    }
    public function editcomment($user, $comment)
    {
        $new_comment = (int)$comment;
        $this->authorize('edit-comment', $new_comment);
        $comment = Comment::find($new_comment);
        if (!$comment->approved) {
            return view('editcomment', compact('comment'));
        }
        return redirect(route('user.comments', $user));
    }
    public function updatecomment(Request $request, Comment $comment)
    {
        if (!$comment->approved) {
            $data = $this->validate($request, [
                'comment' => 'required',
            ]);
            $comment->update($data);
        }
        return redirect(route('user.comments', $request->user()->id));
    }
    public function delete($user, $comment)
    {
        $new_comment = (int)$comment;
        $comment = Comment::find($new_comment);
        $comment->delete();
        return back();
    }
    public function purchased(User $user)
    {
        $purchase = Cart::all()->where('user_id', $user->id);
        return view('purchased', compact('purchase'));
    }
    public function Ajaxpurchased(User $user)
    {
        $purchase = Cart::all()->where('user_id', $user->id);
        return view('InnerPurchase', compact('purchase'));
    }
}
