<?php

// set time zone
date_default_timezone_set('Asia/Tehran');


// connction  
function connection($method, $datas = array())
{
    global $C;
    $url = "https://api.telegram.org/bot######TOOOOKEEEEEEN###########/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
    $res = json_decode(curl_exec($ch));
    if($res->ok==false or curl_errno($ch)){
        sendMessage($C->bot['logChannel'], '#curl error ' . curl_error($ch) .PHP_EOL.'=>  Link: '.$url.'?'.http_build_query($datas)."\n\n result for Tg=>\n".json_encode($res));
    }
    return $res;
}

 
function strTahvil(){
        $diffference = 1584676177 - time();
        $days = floor($diffference / (60 * 60 * 24));
        $hours = floor(($diffference % 86400) / 3600);    
        $min = floor(($diffference % 3600) / 60);
        return "🌺 تا سال 99 :
{$days} روز و {$hours} ساعت و {$min} دقیقه مانده !

🎉لحظه تحویل سال
ساعت 07 و 19 دقیقه 37 ثانیه روز جمعه ، ۱ فروردین ۱۳۹۹ |  20 March 2020 | ۲۵ رجب ۱۴۴۱

🐭 حیوان سال : موش
🌍 سال : کبیسه
⭐️تعطیلات : حدودا 29 روز تعطیل رسمی";
}


//get Update
    $update = json_decode(file_get_contents('php://input'));
    

 
 if(isset($update->inline_query)) {
       connection('answerInlineQuery', array(
                'inline_query_id' => $update->inline_query->id,
                'results' => json_encode([['type'=>'article','id'=>"HaDi".rand(),
                    'title'=>'🎉 تا سال 99 چقدر مونده ؟'
                    ,'description'=>'با دکمه ♻️ بروزرسانی'
                    ,'reply_markup'=>[
                        'inline_keyboard'=>[
                            [
                                ['text'=>'♻️ بروزرسانی','callback_data'=>'update']
                            ]
                        ]
                    ],
                    'input_message_content'=>[
                        'message_text'=>strTahvil(),
                    ]
                ],['type'=>'article','id'=>"HaDi".rand(),
                    'title'=>'🎉 تا سال 99 چقدر مونده ؟'
                                       ,'description'=>'ساده 😄'
                   
                    ,'input_message_content'=>[
                        'message_text'=>strTahvil(),
                    ]
                ]])

            )
        );
        exit(200);
    }elseif(isset($update->callback_query)){
       
       if(file_exists('jdf.php')){
    include 'jdf.php';
    $t= jdate('y/m/d H:i');
       }else{
             $t= date('Y/m/d H:i');
  
       }
 connection('editMessageText', array(
    
        'inline_message_id' => $update->callback_query->inline_message_id,
        'text' =>  strTahvil()."\n ➖➖➖\n 🔰آخرین بروزرسانی : \n {$t}",
        'parse_mode'=>'HTML',
        'disable_web_page_preview'=>true,
        'reply_markup' => json_encode(array(
            'inline_keyboard' => [  [
                                ['text'=>'♻️ بروزرسانی','callback_data'=>'update']
                            ]
                        ]
        ))
    ));
 exit(200);
    }elseif( isset($update->message->from->id)){
       
           // Fucking database   
      $users = json_decode(file_get_contents('users.json'),true);
       
      if(! in_array($update->message->from->id,$users)){
           connection('sendMessage', array(
        'chat_id' => $update->message->from->id,
        'text' => "فقط برای تفریح !
کاری از 
@hiddenPV",
    ));
          
$users[]=$update->message->from->id;
file_put_contents('users.json',json_encode($users));
#TODD : send Ah Ah :)))
exit(200);


      }
      
    }

exit(200);



        	?>


        
