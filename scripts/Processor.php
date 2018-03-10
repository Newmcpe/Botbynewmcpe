<?php
if (!isset($_REQUEST)) {
    return;
}
require_once "Tools.php";
require_once "Answers.php";
$confirmation_token = 'b2ac9619';
$token = '8f3c0adb4483895ef105b8e0a85d4b74ca8500af8b6a04bb238844d2180582e7add931ab4f8c7980d1da2';
$data = json_decode(file_get_contents('php://input'));
switch ($data->type) {
    case 'confirmation':
        echo $confirmation_token;
        //       echo('ok');
        break;
    case 'message_deny':
        $user_id = $data->object->user_id;
        $newmessage = "Что,пидор,запретил сообщения группы? Ну и пошел ты нахуй :)";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        unSubscribeFromSendMessages($user_id);
        echo "ok";
        break;
    case 'wall_post_new':
        sendMessages($token,$data->object->text);
        echo('ok');
        break;
    case 'message_new':
        $message = $data->object->body;
        getAnswerForThis($message,$data->object->user_id,$token);
        echo('ok');
        break;
    default:
        echo('ok');
        break;
}
?>