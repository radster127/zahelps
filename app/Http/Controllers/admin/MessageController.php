<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models [start]
use App\Message;
use App\User;
use App\Custom;

class MessageController extends Controller
{
    public function __construct() {
    $this->base_view = 'admin.messages.';
  }

  private function getUnreadCounter() {
    return Message::where([
                ['to_id', '=', Auth::user()->id],
                ['message_type', '=', 'message'],
                ['is_read', '=', '0'],
            ])->count();
  }

  public function inbox(Request $request) {
    $data['messages'] = Message::where([
                ['to_id', '=', Auth::user()->id],
                ['message_type', '=', 'message'],
            ])->paginate(1);

    $data['unreadCounter'] = $this->getUnreadCounter();
    //dd($data);
    return view($this->base_view . 'inbox', $data);
  }

  public function outbox(Request $request) {
    $data['messages'] = Message::where([
                ['from_id', '=', Auth::user()->id],
                ['message_type', '=', 'message'],
            ])->paginate(25);

    $data['unreadCounter'] = $this->getUnreadCounter();
    //dd($data);
    return view($this->base_view . 'outbox', $data);
  }

  public function compose(Request $request) {
    $data['unreadCounter'] = $this->getUnreadCounter();
    return view($this->base_view . 'compose', $data);
  }

  public function detail($id) {
    $data['message'] = Message::where([
                ['id', '=', $id],
                ['message_type', '=', 'message'],
            ])->first();

    if ($data['message']->to_id == Auth::user()->id) {
      $data['message']->is_read = '1';
      $data['message']->save();
    }



    $data['unreadCounter'] = $this->getUnreadCounter();

    if (!$data['message']) {
      abort(404);
    }
    return view($this->base_view . 'detail', $data);
  }

  public function sendMessage(Request $request) {

    $validator = Validator::make($request->all(), [
                'to_id' => 'required|exists:users,id',
                'subject' => 'required',
                'message' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('member/compose-message')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      Message::create([
          'from_id' => Auth::user()->id,
          'to_id' => $request->get('to_id'),
          'subject' => $request->get('subject'),
          'message' => $request->get('message'),
      ]);

      session()->flash('success_message', 'Message has been sent successfully!');
      return redirect('admin/compose-message');
    }
  }

  public function broadcast(Request $request) {
    return view($this->base_view . 'broadcast');
    //return view('member.email-template.broadcast');
  }

  public function sendBroadcast(Request $request) {

    $validator = Validator::make($request->all(), [
                'subject' => 'required',
                'message' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('member/broadcast')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $data = $request->all();
      $mail_content = view('member.email-template.broadcast', $data);


      // Find Active Users.
      if ($request->get('send_to') == 'all') {
        $users = User::all();
      } elseif ($request->get('send_to') == 'newsletter') {
        $users = User::where('newsletter', '=', '1')->get();
      } elseif ($request->get('send_to') == 'active_users') {
        $users = User::where('status', '=', 'active')->get();
      } elseif ($request->get('send_to') == 'suspended_users') {
        $users = User::where('suspended', '=', '1')->get();
      }

      if (count($users) > 0) {
        foreach ($users as $user) {
          Custom::sendHtmlMail($user->email, $request->get('subject'), $mail_content);
        }
        //Custom::sendHtmlMail('ajay.makwana87@gmail.com', $request->get('subject'), $mail_content);
      }

      session()->flash('success_message', 'Message has been sent to all!');
      return redirect('admin/broadcast');
    }
  }
}
