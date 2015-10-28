<?php

namespace App\Handlers\Events;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\ResponseConstructor;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class EmailForgotPasswdLink implements ShouldBeQueued
{
    use ResetsPasswords;

    protected $mailer;
    /**
     * @var PasswordBroker
     */
    private $passwordBroker;
    /**
     * @var ResponseConstructor
     */
    private $responseConstructor;


    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer,PasswordBroker $passwordBroker,ResponseConstructor $responseConstructor)
    {
        $this->mailer = $mailer;
        $this->passwordBroker = $passwordBroker;
        $this->responseConstructor = $responseConstructor;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(ForgotPassword $event)
    {
        //$salt = env('SALT', 'manish');

        try {
            $user = $event->user;


            $first_name = $user->firstName;
            $email = $user->email;

            $response = $this->passwordBroker->sendResetLink(array("email" => $email), function ($message) {
                $message->subject('Password Reminder');
            });

            /*
                    Mail::queue('emails.email',['email' =>$email,function($m) use ($first_name,$email){

                        // $m->from("bobdemanish3@gmail.com");
                        $m->to($email ,$first_name)->subject('Forgot Password Link');


                    });*/

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return redirect()->back()->with('status', trans($response));

                case Password::INVALID_USER:
                    return redirect()->back()->withErrors(['email' => trans($response)]);
            }
        }catch (RequestException $e ){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Error Ocurred while sending mail")
                ->respondWithError($e->getMessage());

        }
       /* $first_name = $user->first_name;
        $email = $user->email;
        Mail::queue('auth.passwordlink',['token' =>$token] ,function($m) use ($first_name,$email){

           // $m->from("bobdemanish3@gmail.com");
            $m->to($email ,$first_name)->subject('Password Change Request');


        });*/
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /* public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }*/
}
