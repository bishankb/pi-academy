<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MobilePushNotification;
use App\User;
use Auth;
use Edujugon\PushNotification\Facades\PushNotification;

class MobilePushNotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:send_push_notifications');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        return view('backend.push-notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
                [
                    'title'       => 'required|min:2|max:100',
                    'description' => 'nullable|min:3|max:256',
                    'message'     => 'required|min:5|max:655356',
                ]
            );

        try {
            $notification = MobilePushNotification::create(
                [
                    'title'       => request('title'),
                    'description' => request('description'),
                    'message'     => request('message'),
                ]
            );

            $notification_data = [
                'title'            => $notification->title,
                'text'             => $notification->description,
                'file_category_id' => 15,
                'key'              => $notification->id,
                'contentType'      => 'html',
            ];

            PushNotification::setService('fcm')
                ->setMessage($notification_data)
                ->setApiKey(config('pi-academy.fcm_api_key'))
                ->setConfig(['dry_run' => config('pi-academy.fcm_dry_run')])
                ->sendByTopic(config('pi-academy.fcm_android_topic'))
                ->getFeedback();

            flash('Notification send successfully.')->success();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while sending the notification.')->error();
        }

        return redirect(route('push-notification.create'));
    }
}
