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
        //       echo('ok');
        break;
    case 'wall_post_new':
        $dir = __DIR__ . "/subscribers.txt";
        $textpost = $data->object->text;
        $messagetosend = "Новый пост/мем в группе: \n Зайди зацени! \nТекст поста/мема: $textpost";
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
        if (mb_stripos($message, "привет", 0, "utf-8") !== false) {
            $newmessage = "Приветствую,товарищ $user_name.\nДоступные функции:\n 💾Комманды: 💾 \n 1.📅 Расписание 📅 \n 2.💾 Узнать ид музыки 💾 \n 3.💾 Узнать ид видео 💾 \n 4.📢 Подписаться на рассылку 📢  \n 5.💾 О боте 💾 \n 2.😄 Для веселья:) 😄 \n 1.😄 Илья пидор 😄 \n 2.🤷🏻‍♂️ Мила 🤷🏻‍♂️ \n 3.🔞 Алиса, измерь мой писос 🔞 \n 4.🔞 Хентай 🔞 \n 5.🤷🏻‍♂️ Витя 🤷🏻‍♂️ \n 6.🔞 Порно 🔞 \n 3.☕ Видео,аудио,картинка,мем ☕ \n 1.📷Мем📷 \n 2.📷Картинка📷 \n 3.🎧Аудио🎧 \n 4.🎬Видео🎬 \n 5.💾 Для важных переговоров 💾 \n 4.🚔Оскорбления и пожелания🚔 \n 1🚔.Гадайте сами:)🚔";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'access_token' => $token,
                'attachment' => 'photo-154749823_456239538',
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "мила") !== false) {
            $newmessage = "Лошадь";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239554",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "ангелина") !== false) {
            $newmessage = "Найдена порнуха с Ангелиной: \nЭдуард Коряков жёстко изнасиловал Ангелину. \nhttps://vk.com/away.php?to=http%3A%2F%2Fporno365.xxx%2F&el=snippet";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239585',
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "аниме") !== false) {
            $newmessage = "Для пидоров";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "илья пидор") !== false) {
            $newmessage = "По статистике все Ильи Христенка - пидоры";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "посмотреть футбол") !== false) {
            $newmessage = "1 матч футбола найден";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239556",
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "мем") !== false) {
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
        if (mb_stripos($message, "картинка") !== false) {
            $mems = array("photo-154749823_456239595", "photo-154749823_456239596", "photo-154749823_456239597", "photo-154749823_456239599", "photo-154749823_456239600", "photo-154749823_456239603", "photo-154749823_456239604");
            $newmessage = "";
            $request_params = array(
                'user_id' => $user_id,
                'attachment' => $mems[array_rand($mems)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "хентай") !== false) {
            $newmessage = "Запомни,аниме для пидоров,но все-таки дам тебе ссылку на эту хуйню\nhttps://vk.com/away.php?to=http%3A%2F%2Fanimemovie.ru%2Fhentai%2F&el=snippet\nhttps://www.24video.top/tag/view/280121";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "данил") !== false) {
            $newmessage = "найден Даннил на этой картинке";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "подписаться на рассылку") !== false) {
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
        if (mb_stripos($message, "бот пидор") !== false) {
            $request_params = array(
                'message' => "Я искусственный интелект.И у меня нет пола. А кто обзывается тот так сам и называется. :D",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "иди нахуй бот") !== false) {
            $request_params = array(
                'message' => "Не могу пойти на то чего у тебя нет.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "блять") !== false) {
            $request_params = array(
                'message' => "блять - это ты",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "ты ахуел") !== false) {
            $request_params = array(
                'message' => "Я не охуел, а ты да!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "хуй") !== false) {
            $request_params = array(
                'message' => "Хуй твоя кличка в школе!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "хуесос") !== false) {
            $request_params = array(
                'message' => "Я бот,и не могу двигаться,а ты на эту роль вполне подходишь",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "классный бот") !== false) {
            $request_params = array(
                'message' => "Спасибо.Ты тоже",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "мать ебал") !== false) {
            $request_params = array(
                'message' => "Передам админам.Твоя мать уже на столе.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "о боте") !== false) {
            $request_params = array(
                'message' => "Все права на бота принадлежат [id190846469|Newmcpe] и [id455064951|MrKarasik]" . "\n Бот бы сделан специально для группы Мемасы 8И.Все идеи предлагал Илья Христенко и разработчики.Бот в Бета тесте так что не ругайтесь)",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "для важных переговоров") !== false) {
            $mems = array("photo-154749823_456239618", "photo-154749823_456239617", "photo-154749823_456239616", "photo-154749823_456239615", "photo-154749823_456239614", "photo-154749823_456239613", "photo-154749823_456239612", "photo-154749823_456239611", "photo-154749823_456239610", "photo-154749823_456239609", "photo-154749823_456239608", "photo-154749823_456239607", "photo-154749823_456239606", "photo-154749823_456239605");
            $request_params = array(
                'attachment' => $mems[array_rand($mems)],
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "сука") !== false) {
            $request_params = array(
                'message' => "Сука твоя мать.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "алиса, измерь мой писос") !== false) {
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
        if (mb_stripos($message, "алиса измерь мой писос") !== false) {
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
        if (mb_stripos($message, "алиса не работает") !== false) {
            $request_params = array(
                'message' => "Я замещаю алису.Вам что-то надо?",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "порно") !== false) {
            $request_params = array(
                'message' => "Неа.Не дождёшься.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "витя") !== false) {
            $newmessage = "Легенда!";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239633",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "иди нахуй") !== false) {
            $request_params = array(
                'message' => "Не могу пойти на то чего у тебя нет.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "Ты охуел?") !== false) {
            $request_params = array(
                'message' => "Я не охуел, а ты да!.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "пошёл нахуй") !== false) {
            $request_params = array(
                'message' => "Не могу пойти на то чего у тебя нет.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "спасибо") !== false) {
            $request_params = array(
                'message' => "Спасибо тебе!За то, что пользуешься ботом!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "пидор") !== false) {
            $request_params = array(
                'message' => "Я искусственный интелект.И у меня нет пола. А кто обзывается тот так сам и называется. :D",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "расписание") !== false) {
            $newmessage = "Не благодари:)";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239632",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "соси") !== false) {
            $request_params = array(
                'message' => "Я так твоей маме говорил ночью.",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "витя пидор") !== false) {
            $newmessage = "Согласен";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239634",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "пидарас") !== false) {
            $newmessage = "Пидарас здесь только ты";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239555",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "заебал") !== false) {
            $newmessage = "Вообще-то я работаю 24/7 и могу тупить.Не сердись :(";
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => "photo-154749823_456239635",
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "видео") !== false) {
            $newmessage = "Получи и распишись:)";
            $video = array("video-154749823_456239082", "video-154749823_456239021", "video214185425_456239090", "video-30316056_456267531", "video-30316056_456267531", "video-30316056_456271659", "video2148659_170176745", "video92594301_456239140", "video-30316056_456268329", "video-147961728_456239104", "video-66678575_456249572", "video-30316056_456276602", "video-30316056_456275576", "video-30316056_456268704", "video-30316056_456274347", "video-30316056_456278425", "video-30316056_456278623", "video-30316056_456278827");
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => $video [array_rand($video)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "узнать ид музыки") !== false) {
            $datapizdata = json_decode(file_get_contents('php://input'), 1);
            $user_id = $datapizdata["object"]["user_id"];
            $music = $datapizdata["object"]["attachments"][0]["audio"]["owner_id"];
            $id = $datapizdata["object"]["attachments"][0]["audio"]["id"];
            $request_params = array(
                'message' => "audio" . $music . "_" . $id,
                'user_id' => $user_id,
                'access_token' => $token,
                'attachment' => 'photo-154749823_456239637',
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "узнать ид видео") !== false) {
            $datapizdata = json_decode(file_get_contents('php://input'), 1);
            $user_id = $datapizdata["object"]["user_id"];
            $music = $datapizdata["object"]["attachments"][0]["video"]["owner_id"];
            $id = $datapizdata["object"]["attachments"][0]["video"]["id"];
            $request_params = array(
                'message' => "video" . $music . "_" . $id,
                'user_id' => $user_id,
                'access_token' => $token,
                'attachment' => 'photo-154749823_456239638',
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "Аудио") !== false) {
            $newmessage = "Лови и диградируй";
            $musica = array("audio455064951_456239340","audio455064951_456239348","audio455064951_456239303","audio455064951_456239309","audio455064951_456239347","audio455064951_456239343","audio190846469_456239154");
            $request_params = array(
                'message' => $newmessage,
                'user_id' => $user_id,
                'attachment' => $musica[array_rand($musica)],
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "хуй") !== false) {
            $request_params = array(
                'message' => "Хуй твоя кличка на зоне!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "мразь") !== false) {
            $request_params = array(
                'message' => "Тебя так в детстве мама звала!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "дед пидарас") !== false) {
            $request_params = array(
                'message' => "У меня нет деда,а у тебя есть и зовут его Антон.А антон гандон!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "гондон") !== false) {
            $request_params = array(
                'message' => "По гандону твоя мать течёт!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "говно") !== false) {
            $request_params = array(
                'message' => "Говно ты ешь на заврак!!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "мудак") !== false) {
            $request_params = array(
                'message' => "Тебя так учитель истории называл!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "ахуел") !== false) {
            $request_params = array(
                'message' => "Ахуел здесь только ты!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "тупой") !== false) {
            $request_params = array(
                'message' => "тупой только твой хуй",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "пес") !== false or mb_stripos($message, "псина") !== false) {
            $request_params = array(
                'message' => "Пёс твой отец!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }

        if (mb_stripos($message, "Ты точно охуел") !== false) {
            $request_params = array(
                'message' => "Неа!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "Бля") !== false) {
            $request_params = array(
                'message' => "Не матерись!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "Ты пидр") !== false) {
            $request_params = array(
                'message' => "Я нет, а ты да!",
                'user_id' => $user_id,
                'access_token' => $token,
                'v' => '5.0'
            );
        }
        if (mb_stripos($message, "Мать сдохнет") !== false) {
            $request_params = array(
                'message' => "У меня нет, а вот твоей маме уже заказываю гроб из твоих денег :(",
                'user_id' => $user_id,
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