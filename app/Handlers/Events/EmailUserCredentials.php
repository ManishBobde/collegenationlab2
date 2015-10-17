<?php

namespace App\Handlers\Events;

use App\Events\UserRegistered;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class EmailUserCredentials implements ShouldBeQueued
{
    protected $mailer;


    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //$salt = env('SALT', 'manish');

        $user = $event->user;

        $first_name = $user->first_name;
        $email = $user->email;
        Mail::queue('emails.email',['email' =>$email,'password' => $event->plainTextPasswd] ,function($m) use ($first_name,$email){

           // $m->from("bobdemanish3@gmail.com");
            $m->to($email ,$first_name)->subject('Your credentials');


        });
    }
}
