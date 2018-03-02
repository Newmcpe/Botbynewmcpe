<?php
if (!isset($_REQUEST)) {
    return;
}
$confirmation_token = 'b2ac9619';
$token = '8f3c0adb4483895ef105b8e0a85d4b74ca8500af8b6a04bb238844d2180582e7add931ab4f8c7980d1da2';
$data = json_decode(file_get_contents('php://input'));
switch ($data->type) {
    case 'confirmation':
        echo $confirmation_token;
 //       echo('ok');ф
        break;
    case 'wall_post_new':
        $dir = __DIR__ . "/subscribers.txt";
        $textpost = $data->object->text;
        $messagetosend = "Новый пост/мем в группе:\nТекст поста/мема: $textpost";

        $request_params = array(
            'message' => $messagetosend,
            'user_ids' => file_get_contents($dir),
            //'user_id' => '455064951',
            'access_token' => $token,
            'v' => '5.0'
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
        break;
    case 'message_new':
        $user_id = $data->object->user_id;
        $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0"));
        $user_name = $user_info->response[0]->first_name;
        $user_name = $user_name . " " . $user_info->response[0]->last_name;
        $message = $data->object->body;
        if (stripos($message,"привет",0,"utf-8") !== false) {
            $newmessage = "Приветствую,товарищ $user_name.\nДоступные команды:\n🔴 Мила 🔴 \n 🔴 Аниме 🔴 \n 🔴 Посмотреть футбол 🔴 \n 🔴 мем 🔴 \n 🔴 Илья пидор 🔴 \n 🔴 Картинка 🔴 \n 🔴 Хентай 🔴 \n 🔴 Подписаться на рассылку 🔴 \n 🔴 Для важных переговоров 🔴 \n 🔴 О боте 🔴";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'access_token' => $token,
                'attachment' => 'photo-154749823_456239538',
                'v' => '5.0'
            );
        }
        if (mb_stripos($message,"мила") !== false) {
            $newmessage = "Лошадь";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239554",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos( $message,"ангелина") !== false) {
            $newmessage = "Найдена порнуха с Ангелиной: \nЭдуард Коряков жёстко изнасиловал Ангелину. \nhttps://vk.com/away.php?to=http%3A%2F%2Fporno365.xxx%2F&el=snippet";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239585',
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message,"аниме") !== false) {
            $newmessage = "Для пидоров";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message,"илья пидор") !== false) {
            $newmessage = "По статистике все Ильи Христенка - пидоры";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos( $message,"посмотреть футбол") !== false) {
            $newmessage = "1 матч футбола найден";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239556",
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message,"мем") !== false) {
            /*  $posts = json_decode(file_get_contents('https://api.vk.com/method/wall.get?owner_id=-154749823'),true)["response"][0]["items"][0]["id"];
              $request_params = array(
                  'user_id' => $user_id,
                  'message' => $posts,
                  'access_token' => $token,
                  'v' => '5.0'
              );
              file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
              $item = $posts[array_rand($posts)];
              $photo = "photo-154749823_".$item["attachments"][0]["id"];*/
            $mems = array("photo-154749823_456239546", "photo-154749823_456239544", "photo-154749823_456239541", "photo-154749823_456239524", "photo-154749823_456239523", "photo-154749823_456239522",);
            $newmessage = "";
            $request_params = array(
                'user_id' => $user_id,
                'attachment' => $mems[array_rand($mems)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos( $message,"картинка") !== false) {
            $mems = array("photo-154749823_456239558", "photo-154749823_456239560", "photo-154749823_456239561", "photo-154749823_456239562", "photo-154749823_456239563", "photo-154749823_456239564", "photo-154749823_456239565", "photo-154749823_456239566", "photo-154749823_456239567", "photo-154749823_456239570","photo-154749823_456239595","photo-154749823_456239596","photo-154749823_456239597","photo-154749823_456239599","photo-154749823_456239600","photo-154749823_456239603","photo-154749823_456239604");
            $newmessage = "";
            $request_params = array(
                'user_id' => $user_id,
                'attachment' => $mems[array_rand($mems)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos( $message,"хентай") !== false) {
            $newmessage = "Запомни,аниме для пидоров,но все-таки дам тебе ссылку на эту хуйню\nhttps://vk.com/away.php?to=http%3A%2F%2Fanimemovie.ru%2Fhentai%2F&el=snippet\nhttps://www.24video.top/tag/view/280121";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos( $message,"данил") !== false) {
            $newmessage = "найден Даннил на этой картинке";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos( $message,"подписаться на рассылку") !== false) {
            $dir = __DIR__ . "/subscribers.txt";
            if (mb_stripos(file_get_contents($dir), "$user_id") !== false) {
                $newmessage = "Вы уже подписаны на рассылку,сорре.";
                $request_params = array(
                    'message' => $newmessage,
                    'user_id' => $user_id,
                    'access_token' => $token,
                    'v' => '5.0'
                );
            } else {
                $newmessage = "Вы успешно подписались на рассылку.Спасибо!";
                $request_params = array(
                    'message' => $newmessage,
                    'user_id' => $user_id,
                    'access_token' => $token,
                    'attachment' => 'photo-154749823_456239593',
                    'v' => '5.0'
                );
                file_put_contents($dir, file_get_contents($dir) . "$user_id,");
            }
        }
        if (mb_stripos( $message,"бот пидор") !== false) {
            $request_params = array(
                'message' => "Я искусственный интелект.И у меня нет пола. А кто обзывается тот так сам и называется. :D",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"иди нахуй бот") !== false){
            $request_params = array(
                'message' => "Не могу пойти на то чего у тебя нет.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"классный бот") !== false){
            $request_params = array(
                'message' => "Спасибо.Ты тоже",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"мать ебал") !== false){
            $request_params = array(
                'message' => "Передам админам.Твоя мать уже на столе.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"о боте") !== false){
            $request_params = array(
                'message' => "Все права на бота принадлежат [id190846469|Newmcpe] и [id455064951|MrKarasik]",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"для важных переговоров") !== false){
            $mems = array("photo-154749823_456239618","photo-154749823_456239617","photo-154749823_456239616","photo-154749823_456239615","photo-154749823_456239614","photo-154749823_456239613","photo-154749823_456239612","photo-154749823_456239611","photo-154749823_456239610","photo-154749823_456239609","photo-154749823_456239608","photo-154749823_456239607","photo-154749823_456239606","photo-154749823_456239605");
            $request_params = array(
                'attachment' => $mems[array_rand($mems)],
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if(mb_stripos($message,"сука") !== false) {
            $request_params = array(
                'message' => "Сука твоя мать.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos( $message,"алиса, измерь писос") !== false) {
            $newmessage = "Алиса измерила твой писос";
            $alica = array("photo-154749823_456239628", "photo-154749823_456239629", "photo-154749823_456239630");
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => $alica [array_rand($alica)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
        break;
    default:
        echo('ok');
        break;
}
?>