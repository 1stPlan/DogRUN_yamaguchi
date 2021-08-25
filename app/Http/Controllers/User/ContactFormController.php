<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactForm;

class ContactFormController extends Controller
{
    public function index()
    {
        return view('user.contact.contact');
    }

    public function form(ContactRequest $request)
    {
        $inputs = $request->all();
        return view('user.contact.contact_form')->with(['inputs'=> $inputs]);
    }

    public function send(Request $request, ContactForm $contactForm)
    {
        $action = $request->get('action');
        $inputs = $request->all();

        if ($action === '送信') {

        // 二重送信防止のためトークンを発行
            $request->session()->regenerateToken();

            // datebaeに保存
            $contactForm = new $contactForm();
            $contactForm->name_top = $request->name_top;
            $contactForm->name_bottom = $request->name_bottom;
            $contactForm->mail = $request->mail;
            $contactForm->content = $request->content;
            $contactForm->save();

            // メール送信処理などを実装
            // お客様に送るメール
            Mail::send('emails.contact_customer', ['inputs' => $inputs], function ($message) use ($request) {
                $message->to($request->mail, $request->name_top)
              ->subject('お問い合わせを受付けました。');
            });

            // 管理者に送るメール
            Mail::send('emails.contact_admin', ['inputs' => $inputs], function ($message) use ($request) {
                $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
              ->subject('お問い合わせを受付けました。');
            });

            return view('user.contact.contact_send');
        } else {
            return redirect()->action('User\ContactFormController@index')->withInput($inputs);
        }
    }

}
