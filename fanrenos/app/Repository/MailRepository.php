<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Mail;

class MailRepository
{
    
    public function send(){
        $name = 'Mostanily';
        $flag = Mail::send('emails.test',['name'=>$name],function($message){
            $to = 'p229885381@163.com';
            $message ->to($to)->subject('测试邮件');
        });
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
    }
}