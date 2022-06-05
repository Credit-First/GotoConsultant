<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Session;

use App\Models\ChannelMessages;
use App\Models\TwilioChannels;
use App\Models\MissedNotification;
class MessageController extends Controller
{
  private $twilio;

  public function __construct() {
      $TWILIO_AUTH_SID= config('app.TWILIO_AUTH_SID');
      $TWILIO_AUTH_TOKEN= config('app.TWILIO_AUTH_TOKEN');
//      \Log::info( '-1 $ ::' . print_r( $TWILIO_AUTH_SID, true  ) );
//      \Log::info( '-2 $ ::' . print_r( $TWILIO_AUTH_TOKEN, true  ) );

    $this->twilio = new Client($TWILIO_AUTH_SID, $TWILIO_AUTH_TOKEN);
  }

  public function checkMissedNotifications (Request $request)
  {
      $requestData = $request->all();

      $missedNotifications= MissedNotification
          ::getByReceiverId($requestData['customer_id'])
          ->select('sender_id', DB::raw('count(*) as sender_total'))
          ->groupBy('sender_id')
          ->get()
          ->toArray();
      Session::put('missedNotifications', $missedNotifications);
      return response()->json( ['missedNotificationsCount' => count($missedNotifications), 'receiver_id'=> $requestData['customer_id'], 'sender_id'=> $requestData['consultant_id'] ] );

  }
  public function checkChannel (Request $request) {
    $requestData = $request->all();
//    \Log::info('-1 checkChannel $requestData ::' . print_r($requestData, true));

    $missedNotificationsToDelete= MissedNotification
      ::getByReceiverId($requestData['customer_id'])
      ->getBySenderId($requestData['consultant_id'])
      ->get()
      ->toArray();

//    \Log::info('-21 checkChannel $missedNotificationsToDelete ::' . print_r($missedNotificationsToDelete, true));
    foreach( $missedNotificationsToDelete as $nextMissedNotificationsToDelete ) {
      $missedNotification= MissedNotification::find($nextMissedNotificationsToDelete['id']);
      if($missedNotification!==null) {
//        $missedNotification->delete();
      }
    }

    try {
      if ($request->type !== "consultant") {
        $channel = $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))
            ->channels("private-".$request->consultant_id."-".$request->customer_id)
            ->fetch();
      } else {
        $consultant_id = min($request->customer_id, $request->consultant_id);
        $customer_id = max($request->customer_id, $request->consultant_id);
        $channel = $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))
            ->channels("private-".$consultant_id."-".$customer_id)
            ->fetch();
      }
      return response()->json($channel->uniqueName);
    } catch(RestException $e) {
      if ($request->type !== "consultant") {
        $channel = $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))
          ->channels->create(['uniqueName' => "private-".$request->consultant_id."-".$request->customer_id,'type' => 'private']);
        TwilioChannels::create([
          "channel" => "private-".$request->consultant_id."-".$request->customer_id,
          "consultant_id" => $request->consultant_id,
          "customer_id" => $request->customer_id,
          "direction" => "con-cus"
        ]);
      } else {
        $consultant_id = min($request->customer_id, $request->consultant_id);
        $customer_id = max($request->customer_id, $request->consultant_id);
        $channel = $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))
          ->channels->create(['uniqueName' => "private-".$consultant_id."-".$customer_id, 'type' => 'private']);
        TwilioChannels::create([
          "channel" => "private-".$consultant_id."-".$customer_id,
          "consultant_id" => $consultant_id,
          "customer_id" => $customer_id,
          "direction" => "con-con"
        ]);
      }
      try {
        $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members($request->consultant_email)->fetch();
      } catch (RestException $e) {
        $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members->create($request->consultant_email);
      }
      // Add customer to the channel
      try {
        $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members($request->customer_email)->fetch();
      } catch (RestException $e) {
        $this->twilio->chat->v2->services(config('app.TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members->create($request->customer_email);
      }
      return response()->json($channel->uniqueName);
    }
  }

  public function generate(Request $request)  {
    $token = new AccessToken(config('app.TWILIO_AUTH_SID'), config('app.TWILIO_API_SID'), config('app.TWILIO_API_SECRET'), 3600, $request->email);

    $chatGrant = new ChatGrant();
    $chatGrant->setServiceSid(config('app.TWILIO_SERVICE_SID'));
    $token->addGrant($chatGrant);

    return response()->json(['token' => $token->toJWT()]);
  }

  public function fetchMessages(Request $request) {
    $channel = ChannelMessages::where('channel', $request->channel)->first();
    return response()->json($channel->messages);
  }

  public function updateMessages(Request $request) {
    ChannelMessages::where('channel', $request->channel)->update(['messages' => $request->message]);
    return response()->json(true);
  }

  public function addMissedNotification(Request $request) {
    $requestData = $request->all();

    $missedNotification= new MissedNotification();
    $missedNotification->sender_id = $requestData["sender_id"];
    $missedNotification->receiver_id = $requestData["receiver_id"];
    $missedNotification->save();
    return response()->json(true);
  }
}
