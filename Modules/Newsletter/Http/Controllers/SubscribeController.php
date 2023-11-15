<?php

namespace Modules\Newsletter\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Entities\Newsletter;
use Modules\Newsletter\Http\Requests\SubscribeRequest;
use Modules\Newsletter\Jobs\EmailSubscribeNotification;

class SubscribeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Newsletter\Http\Requests\SubscribeRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SubscribeRequest $request)
    {
        $newsletter = Newsletter::withTrashed()->whereEmail($request->email)->first();


        if($newsletter && $newsletter->trashed()){
            $newsletter->restore();
        }else{
            $newsletter = Newsletter::create([
                'email' => $request->email,
                'token' => bin2hex($request->email)
            ]);
        }

        EmailSubscribeNotification::dispatchAfterResponse($newsletter);
        // EmailSubscribeNotification::dispatch($newsletter)->delay(now()->addSeconds(30));

        return response()->json([
            'message' => __('web.newsletter_subscription_success'),
        ]);
    }


    /**
     * Delete newsletter subscribre
     *
     * @param Request $request
     * @param string $token
     * @return Illuminate/Http/Request
     */
    public function delete(Request $request, $token)
    {

        $subscriber = Newsletter::whereToken($token)->first();

        if (method_exists($subscriber, 'softDelete')) {

            if (config('app.softDelete'))
                $subscriber->delete();
            else
                $subscriber->forceDelete();
        } else {
            $subscriber->delete();
        }

        return redirect()->back();
    }
}
