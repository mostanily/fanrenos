<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * 显示表单
     *
     * @return View
     */
    public function showForm()
    {
        $data = [
            'title' => config('blog.title').'|联系我',
            'subtitle' => config('blog.subtitle'),
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
        ];

        return view('blogs.contact',$data);
    }

    /**
     * Email the contact request
     *
     * @param ContactMeRequest $request
     * @return Redirect
     */
    public function sendContactInfo(ContactMeRequest $request)
    {
        $data = $request->only('name', 'email', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->subject('Blog Contact Form: '.$data['name'])
              ->to(config('blog.contact_email'))
              ->replyTo($data['email']);
        });

        return back()
            ->withSuccess("Thank you for your message. It has been sent.");
    }
}
