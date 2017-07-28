<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models [start]
use App\Message;
use App\Custom;
use App\GH;
use App\PH;
use App\Pair;
use App\Setting;
use \Carbon\Carbon;

class MessageController extends Controller
{
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
	            ])->paginate(25);

	    $data['unreadCounter'] = $this->getUnreadCounter();
	    //dd($data);
	    return view('member.messages.inbox', $data);
	}

  	public function outbox(Request $request) {
	    $data['messages'] = Message::where([
	                ['from_id', '=', Auth::user()->id],
	                ['message_type', '=', 'message'],
	            ])->paginate(25);

	    $data['unreadCounter'] = $this->getUnreadCounter();
	    //dd($data);
	    return view('member.messages.outbox', $data);
	}

	public function compose(Request $request) {
	    $data['unreadCounter'] = $this->getUnreadCounter();
	    return view('member.messages.compose', $data);
	}

	public function detail($id) {
	    $data['message'] = Message::where([
	                ['id', '=', $id],
	                ['to_id', '=', Auth::user()->id],
	                ['message_type', '=', 'message'],
	            ])->first();
	    $data['message']->is_read = '1';
	    $data['message']->save();

	    $data['unreadCounter'] = $this->getUnreadCounter();

	    if (!$data['message']) {
	      abort(404);
	    }
	    return view('member.messages.detail', $data);
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
	      return redirect('member/compose-message');
	    }
	}

 	public function sendPairMessage(Request $request) {

	    $pair_item = Pair::find($request->get('pair_id'));

	    if (!$pair_item) {
	      return [
	          'status' => '0',
	          'message' => 'Pair not found'
	      ];
	    } else {

	      if ($pair_item->PH->user_id == Auth::user()->id || $pair_item->GH->user_id == Auth::user()->id) {

	        $to_id = $pair_item->GH->user_id;
	        if ($pair_item->GH->user_id == Auth::user()->id) {
	          $to_id = $pair_item->PH->user_id;
	        }

	        Message::sendPairMessage([
	            'pair_id' => $pair_item->id,
	            'from_id' => Auth::user()->id,
	            'to_id' => $to_id,
	            'message' => $request->get('message'),
	        ]);

	        $userAvatar = asset('/') . 'images/user.png';
	        if (Auth::user()->avatar != '') {
	          $userAvatar = asset('/') . 'uploads/members/' . Auth::user()->id . '/thumb_50X50_' . Auth::user()->avatar;
	        }


	        return [
	            'status' => '1',
	            'message' => 'Message sent',
	            'message_content' => [
	                'username' => Auth::user()->username,
	                'image' => $userAvatar,
	                'time' => 'now',
	                'message' => $request->get('message')
	            ]
	        ];
	      } else {
	        return [
	            'status' => '0',
	            'message' => 'You do not have access to send message!'
	        ];
	      }
	    }
  	}
}
