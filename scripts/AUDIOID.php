<?php

if (!isset($_REQUEST)) {
    return;
}
function sendMessage($token, $messagetosend, $userid)
{
    $request_params = array(
        'message' => $messagetosend,
        'user_id' => $userid,
        'attachment' => '',
        'access_token' => $token,
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}
//Строка для подтверждения адреса сервера из настроек Callback API
$confirmation_token = '02dc68da';

//Ключ доступа сообщества
$token = '4af571a63102714c2c6b945fcaeb84462096e56172949c91f832143aaf2a0f92cf13a0b789f441c000dcb';

//Получаем и декодируем уведомление
$data = json_decode(file_get_contents('php://input'),1);

//Проверяем, что находится в поле "type"
switch ($data["type"]) {
//Если это уведомление для подтверждения адреса...
    case 'confirmation':
//...отправляем строку для подтверждения
        echo $confirmation_token;
        break;
    default:
//...отправляем строку для подтверждения
        echo "ok";
        break;

//Если это уведомление о новом сообщении...
    case 'message_new':
        $user_id = $data["object"]["user_id"];
        $tokenformother = '602e8d344e7684d9e3ace9007518e5da4267b54524d0a3e17c9918fc7b6ef76eea192ca57a3d6795a96e0';
        if($data["object"]["body"] = "видосы"){
            $request_params = http_build_query(array(
                'owner_id' => '-45745333',
                'access_token' => $tokenformother,
                'v' => '5.0'
            ));
            $quer = json_decode(file_get_contents('https://api.vk.com/method/video.get?' . $request_params),1);
            $items = $quer["response"]["items"];
            $msg = "";
            for($i = 0; $i < count($items); $i++){
                $msg = $msg . "\n" . $items[$i]["id"];
            }
            sendMessage($token,$msg,$user_id);

        }
        if(isset($data["object"]["attachments"][0]["audio"])) {

            $music = $data["object"]["attachments"][0]["audio"]["owner_id"];
            $id = $data["object"]["attachments"][0]["audio"]["id"];
//С помощью messages.send отправляем ответное сообщение
            $request_params = array(
                'message' => "audio" . $music . "_" . $id,
//'attachment' => "",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
            $request_params1 = array(
                'message' => "error response code 500 critical",
//'attachment' => "",
                'user_id' => "455064951",
                'access_token' => "8f3c0adb4483895ef105b8e0a85d4b74ca8500af8b6a04bb238844d2180582e7add931ab4f8c7980d1da2",
                'v' => '5.0'
            );

            $get_params = http_build_query($request_params);

            file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
            $get_params1 = http_build_query($request_params1);

            file_get_contents('https://api.vk.com/method/messages.send?' . $get_params1);
        }

//Возвращаем "ok" серверу Callback API

        echo('ok');

        break;

}
?>