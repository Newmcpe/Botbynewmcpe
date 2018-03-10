<?php
/**
 * Created by PhpStorm.
 * User: Newmcpe и MrKarasik
 * Date: 08.03.2018
 * Time: 1:21
 */
require_once "Tools.php";
$token = "fea01489a5b578360fe1dbac23a9dc5d91fc8615cb85d9373d1d3738dc153a83799d7c9ba7988714a3910";
$user_id = 477189774;
$captcha_album = 251278738;
$rospisphoto = "photo431257723_456239044";
$request_params = http_build_query(array(
    'hash' => $otvet["hash"],
    'photo' => $otvet["photo"],
    'access_token' => $token,
    'v' => '5.0'
));
$activated_victorinas = array();
$query = json_decode(file_get_contents('https://api.vk.com/method/messages.getLongPollServer?' . $request_params), 1);
$server = $query["response"]["server"];
$key = $query["response"]["key"];
$ts = $query["response"]["ts"];
$captchakey = "";
$captchasid = "";
while (true) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://{$server}?act=a_check&key={$key}&ts={$ts}&wait=90&mode=2&version=2 ");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    // $result = "{\"failed\":2}";
    $decres = json_decode($result, 1);
    if (mb_stripos($result, "{\"failed\":2") !== false) {
        $datetime = date("H:i:s");
        mysqli_query(getMySQLConnection(), "INSERT INTO logs (text,timedate) VALUES ('ключ,устарел пробую получить новые данные','$datetime')");
        echo "ключ,устарел пробую получить новые данные\n";
        $request_params = http_build_query(array(
            'access_token' => $token,
            'v' => '5.0'
        ));
        $query = json_decode(file_get_contents('https://api.vk.com/method/messages.getLongPollServer?' . $request_params), 1);
        var_dump($query);
        $server = $query["response"]["server"];
        $key = $query["response"]["key"];
        $ts = $query["response"]["ts"];
    } else {
        $ts = $decres["ts"];//431257723
    }
    if ($decres["updates"][3][6]["source_act"] == "chat_invite_user") {
        echo "Обнаружено приглашение в беседу\n";
        $request_params = http_build_query(array(
            'message' => "💾Привет ,пидоры я бот Карась💾 \n🔴Доступные функции🔴: \n 1.💾Команды 💾 \n 2.😄 Для веселья 😄 \n 3.☕ Картинки и т.д ☕ \n 4.🚔Оскорбления и пожелания🚔 \n 5.📖Карась истории📖 \n 6.💰Для покупок💰",
            'peer_id' => $decres["updates"][3][3],
            'access_token' => $token,
            'v' => '5.38'
        ));
        echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
    }
    if ($decres["updates"][0][0] == 4) {
        echo $decres["updates"][0][5] . "\n";;
    } elseif ($decres["updates"][1][0] == 4) {
        $msg = $decres["updates"][1][5];
        $whosended = $decres["updates"][1][6]["from"];
        if ($whosended != $user_id) { // черный список бота
            if (isset($activated_victorinas[$whosended])) {
                $question = getQuestion($activated_victorinas[$whosended]);
                $answer = $question["answer"];
                $question = $question["question"];
                $countsymbols = iconv_strlen($answer);
                if (mb_stripos($msg, "отказаться от викторины") !== false) {
                    $request_params = http_build_query(array(
                        'message' => "❌ Вы отказались от викторины :(! ❌\n\n Чтобы еще раз сыграть,просто напиши \"викторина\" ",
                        'peer_id' => $decres["updates"][1][3],
                        'captcha_sid' => $captchasid,
                        'captcha_key' => $captchakey,
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                    unset($activated_victorinas[$whosended]);
                }

                if (mb_stripos($answer, $msg) !== false) {
                    giveMoney($whosended, "2");
                    $request_params = http_build_query(array(
                        'message' => " ✔ Поздравляю, вы победили в викторине! ✔\n\n 💰 Ваш новый баланс: " . getMoney($whosended) . " 💰 \n\n Чтобы еще раз сыграть,просто напиши \"викторина\" ",
                        'peer_id' => $decres["updates"][1][3],
                        'captcha_sid' => $captchasid,
                        'captcha_key' => $captchakey,
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                    unset($activated_victorinas[$whosended]);
                } else {
                    $request_params = http_build_query(array(
                        'message' => " ❌ Ответ неверный! ❌\n\n📝 Вопрос: $question 📝\n\n🔢 Букв в ответе: $countsymbols 🔢\n\n💰Приз за ответ: 2 КарасьКоина💰 \n\n❌Если хочешь отказаться - просто напиши \"отказаться от викторины\" ❌ ",
                        'peer_id' => $decres["updates"][1][3],
                        'captcha_sid' => $captchasid,
                        'captcha_key' => $captchakey,
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    $response1 = json_decode(file_get_contents('https://api.vk.com/method/messages.send?' . $request_params), 1);
                    /*   if ($response1["error"]["error_code"] == 14) {

                           $request_params = http_build_query(array(
                               'album_id' => $captcha_album,
                               'access_token' => $token,
                               'v' => '5.38'
                           ));
                           $uploadserver1 = json_decode(file_get_contents('https://api.vk.com/method/photos.getUploadServer?' . $request_params), 1)["response"]["upload_url"];
                           file_put_contents(__DIR__ . "/captcha.jpg", file_get_contents($response1["error"]["captcha_img"]));
                           $curl = curl_init($uploadserver1);
                           curl_setopt($curl, CURLOPT_POST, true);
                           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                           curl_setopt($curl, CURLOPT_POSTFIELDS, array('file1' => new CURLFile(__DIR__ . "/captcha.jpg")));
                           $json = json_decode(curl_exec($curl), 1);
                           var_dump($json);
                           $request_params = http_build_query(array(
                               'album_id' => $captcha_album,
                               'server' => $json["server"],
                               'hash' => $json["hash"],
                               'photos_list' => $json["photos_list"],
                               'access_token' => $token,
                               'v' => '5.38'
                           ));
                           $uploadserver = json_decode(file_get_contents('https://api.vk.com/method/photos.save?' . $request_params), 1);
                           $photoid = "photo" . $uploadserver["response"][0]["owner_id"] . "_" . $uploadserver["response"][0]["id"];
                           $request_params = http_build_query(array(
                               'peer_id' => $decres["updates"][1][3],
                               'message' => "Обнаружена капча,напишите боту Карась ввести капчу [код],чтобы бот заработал",
                               'attachment' => $photoid,
                               'access_token' => $token,
                               'v' => '5.38',
                           ));
                           $captchasid = $response1["error"]["captcha_sid"];
                           echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                       }
                   }*/
                }
            }
            if (mb_stripos($msg, "соси") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Я так твоей мамке ночью говорил.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }

            if (mb_stripos($msg, "Карась кто") !== false) {
                $what = implode(" ", array_slice(explode(" ", $msg), 2));
                $chatid = $decres["updates"][1][3] - 2000000000;
                $request_params = http_build_query(array(
                    'chat_id' => $chatid,
                    'fields' => "photo_50",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                $res = json_decode(file_get_contents('https://api.vk.com/method/messages.getChatUsers?' . $request_params), 1);
                $response = $res["response"][array_rand($res["response"])];
                $name = $response["first_name"] . " " . $response["last_name"];
                $id = $response["id"];
                $request_params = http_build_query(array(
                    'message' => "Я думаю,что [id$id|$name] $what",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась скажи") !== false) {
                $what = str_ireplace(" ", "+", implode(" ", array_slice(explode(" ", $msg), 2)));
                $tmp_image = file_get_contents("http://194.67.200.179/speechkit/www/api/yandex_api.php?say=$what");
                $hashrand = md5(mt_rand(0, 99999999999));
                $fname = __DIR__ . "/audios/$hashrand.ogg";
                file_put_contents($fname, "$tmp_image");
                $request_params = http_build_query(array(
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'type' => 'audio_message',
                    'v' => '5.38'
                ));
                $uploadserver = json_decode(file_get_contents('https://api.vk.com/method/docs.getMessagesUploadServer?' . $request_params), 1)["response"]["upload_url"];
                $curl = curl_init($uploadserver);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => new CURLFile($fname)));
                $json = json_decode(curl_exec($curl), 1);
                $file = $json["file"];
                $request_params = http_build_query(array(
                    'file' => $json["file"],
                    'captcha_sid' => $captchasid,
                    'captcha_key' => $captchakey,
                    'title' => $hashrand,
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                $response1 = json_decode(file_get_contents('https://api.vk.com/method/docs.save?' . $request_params), 1);
                $request_params = http_build_query(array(
                    'peer_id' => $decres["updates"][1][3],
                    //  'message' => $file,
                    'attachment' => 'doc' . $response1["response"][0]["owner_id"] . "_" . $response1["response"][0]["id"],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n" . $response1["error"]["error_code"];
                if ($response1["error"]["error_code"] == 14) {
                    /*******************************Обработка капчи****************************************/
                    $request_params = http_build_query(array(
                        'album_id' => $captcha_album,
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    $uploadserver1 = json_decode(file_get_contents('https://api.vk.com/method/photos.getUploadServer?' . $request_params), 1)["response"]["upload_url"];
                    file_put_contents(__DIR__ . "/captcha.jpg", file_get_contents($response1["error"]["captcha_img"]));
                    $curl = curl_init($uploadserver1);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array('file1' => new CURLFile(__DIR__ . "/captcha.jpg")));
                    $json = json_decode(curl_exec($curl), 1);
                    var_dump($json);
                    $request_params = http_build_query(array(
                        'album_id' => $captcha_album,
                        'server' => $json["server"],
                        'hash' => $json["hash"],
                        'photos_list' => $json["photos_list"],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    $uploadserver = json_decode(file_get_contents('https://api.vk.com/method/photos.save?' . $request_params), 1);
                    $photoid = "photo" . $uploadserver["response"][0]["owner_id"] . "_" . $uploadserver["response"][0]["id"];
                    $request_params = http_build_query(array(
                        'peer_id' => $decres["updates"][1][3],
                        'message' => "Обнаружена капча,напишите боту Карась ввести капчу [код],чтобы бот заработал",
                        'attachment' => $photoid,
                        'access_token' => $token,
                        'v' => '5.38',
                    ));
                    $captchasid = $response1["error"]["captcha_sid"];
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                }
            } elseif (mb_stripos($msg, "Карась ввести капчу") !== false) {
                if ($decres["updates"][1][6]["from"] != 431257723) {
                    $captcha = explode(" ", $msg)[3];
                    $request_params = http_build_query(array(
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'message' => "Капча успешно активирована",
                        'v' => '5.38'
                    ));
                    $captchakey = $captcha;
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                }
            }
            if (mb_stripos($msg, "команды") !== false) {
                $request_params = http_build_query(array(
                    'message' => "1.📊Карась шанс(текст)📊 \n 2.🔞Карась кто(текст)🔞 \n 3.💰Карась мой баланс💰 \n 4.💰Карась передай деньги(ид человека) (сумма) \n 5.📝Викторина📝 \n 6.📝Отказать от викторины📝 \n 7.💰Карась ставка(сумма)",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "для веселья") !== false) {
                $request_params = http_build_query(array(
                    'message' => "1.🤷🏻‍♂️ Мила 🤷🏻‍♂️ \n 2.🤷🏻‍♂️ Витя 🤷🏻‍♂️ \n 3.📄Карась рифма📄 \n 4.🔞Подрочить на федорчук🔞 \n 5.🔞Порно🔞 \n 6.🔞Хентай🔞 \n 7.🔞Ангелина🔞 \n 8.🔞Илья🔞 \n 9.🔞Алиса, измерь мой писос🔞",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "картинки и т.д") !== false) {
                $request_params = http_build_query(array(
                    'message' => "1.🎧Карась дай музло🎧 \n 2.🎬Карась дай видос🎬 ",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "хентай") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Запомни,аниме для пидоров,но все-таки дам тебе ссылку на эту хуйню\nhttps://vk.com/away.php?to=http%3A%2F%2Fanimemovie.ru%2Fhentai%2F&el=snippet\nhttps://www.24video.top/tag/view/280121",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "скорбления и пожелания") !== false) {
                $request_params = http_build_query(array(
                    'message' => "В разработке",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Для покупок") !== false) {
                $request_params = http_build_query(array(
                    'message' => "💾Команды💾: \n 1.📦Список товаров📦 \n 2.💰Карась купить (ид товара)💰",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась истории") !== false) {
                $request_params = http_build_query(array(
                    'message' => "💂История аслана💂 \n 🙅История милы🙅",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "история аслана") !== false) {
                $request_params = http_build_query(array(
                    'message' => "\n Давайте поиграем в игру \"Ассоциации\". Я начинаю первым! \n Хмм, что же загадать? Придумал, шептун! А вы теперь \n отгадываете с каким одноклассником это связано. Мда... Я \n загадал слишком лёгкое, каждый же отгадал, что это Аслан! \n Аслан - хороший друг и очень большой одноклассник. \n \"Поможет в беде, съест вас в радости!\" \n - эти слова про него, он весит больше, чем 10 Федорчук (Федорчук - единица измерения веса во вселенной восьмых классов школы №7). \n Но Витя всё ещё может кинуть его на прогиб, при его таком большом весе. \n А теперь переместимся в раздевалку. Только вспомните его животик когда он снимает свою футболку. А его ножки - это самое лучшее, что есть на этой планете. \n Я вспоминаю про них, когда ем сочные и жирные крылышки из KFC.Все девочки текут по Асланчику.",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239042",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась иди нахуй") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Не могу пойти на то чего у тебя нет",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "история милы") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Мила, Мила, Мила... Это имя уже у каждого на слуху, но как \n она стала такой? Всё началось с того, как она в середине 7 \n класса пришла к нам в школу. Она сразу начала подкатывать к некоторым парням (в том числе и одному из админов) \n Сначала мы все считали её обычной одноклассницей, но в начале 8 класса все узнали о её увлечении конным спортом \n Так же у неё есть собственный канал видеохостинге \"YouTube\" \n Мы сразу начали добро над неё шутить, но она это всё воспринимала всерьёз. И тогда началось противостояние! \n  Мы начали делать про неё много-много мемов, а потом нашли её вторую страницу с приват фотографиями. \n Она на них курила, бухала со своей ЛП Викой! \n (напишу комманду \"продолжение истории милы\" чтобы продолжить читать)  ",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239040",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "продолжение истории милы") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Эти фото мы слили, так как админы за ЗОЖ.\n И началась волна мемов с ними, как раз тогда популярность нашей группы сильно возросла. \n После этих действий она стала очень дерзкой (как пуля резкой) и борзой. \n Но вскоре она встала на путь исправления - стала прилично себя вести с одноклассниками. Сейчас она вполне обычная одноклассница, со своими интересами и вкусами, которые каждый из нас должен уважать!",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239041",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "витя") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Легенда",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239018",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "пропиздон") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Бля заебали мне один рас так просто мама сказала по приколу!(Илья Христнко)",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "блять") !== false) {
                $request_params = http_build_query(array(
                    'message' => "блять здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "сучка") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Твоя мать сучка!",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "шлюха") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Професия твоей мамы",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "мать ебал") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Я тебя понял.Твоя мать уже на столе скоро она узнает, что такое жёсткое БДСМ.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "О боте") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Все права на бота принадлежат [id190846469|Newmcpe] и [id455064951|MrKarasik]" . "\n Бот бы сделан специально для группы Мемасы 8И. (https://vk.com/memasnazakaz8i)",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "пес") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Пёс здесь только твой отец",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "прошмандовка") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Професия твоей мамы",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "сосать") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Я так твоеё маме ночью говорил",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "шавуха") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Бля если этот бот шаурма щас не съебётся значит я позвоню Путину и её запретят в Росии.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "шаурма") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Бля если этот бот шаурма щас не съебётся значит я позвоню Путину и её запретят в Росии.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ты чё охуел?") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ты чё ахуел?") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ты охуел?") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Быдло") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Быдло-это фамилия твоей семьи.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Нет ну ты точно ахуел") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Нет ну ты точно ахуел") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ты ахуел?") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ахуел здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "хуепутало") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Сложный прикол",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "пидарас") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Пидарас здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Сом") !== false) {
                $request_params = http_build_query(array(
                    'message' => "А Я НЕ ПОНЯЛ.КТО ТУТ ЕЩЁ ТАКОЙ СОМ А?",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ёбанная рыба") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ёбанный здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ебанная рыба") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ёбанный здесь только ты",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "хуй") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Хуй твоя кличка на зоне",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "порно") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Неа.Не дождёшься",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "мать сдохнет") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Мать сдохнет только у тебя",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "заебал") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Заебал здесь только ты меня",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карасик") !== false) {
                $request_params = http_build_query(array(
                    'message' => "💾Привет,пидоры,я бот Карась💾 \n🔴Доступные функции🔴: \n 1.💾Команды 💾 \n 2.😄 Для веселья 😄 \n 3.☕ Картинки и т.д ☕ \n 4.🚔Оскорбления и пожелания🚔 \n 5.📖Карасик истории📖 \n 6.💰Для покупок💰",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "хуесос") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Не думаю что карась подойдёт на эту роль.А вот ты да! ХУЕСОСИЩЕ",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Алиса, измерь мой писос") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Алиса измерила твой писос",
                    'attachment' => "photo477189774_456239043", "photo477189774_456239044", "photo477189774_456239045",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Алиса измерь мой писос") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Алиса измерила твой писос",
                    'attachment' => "photo477189774_456239043", "photo477189774_456239044", "photo477189774_456239045",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась пидарас") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Караси не пидоры.Все караси только натуралы, а вот ты пидарас ещё тот.",
                    'attachment' => "photo477189774_456239026",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "аниме") !== false) {
                $request_params = http_build_query(array(
                    'message' => "для пидоров",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239026",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "мила") !== false) {
                $request_params = http_build_query(array(
                    'message' => "лошадь",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239028",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "кек") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Лол кек чебурек.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "куртизанка") !== false) {
                $request_params = http_build_query(array(
                    'message' => "ВОУ ВОУ ВОУ! Какие умные слова.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "сука") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Здесб только твоя мать сука.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "наруто") !== false) {
                $request_params = http_build_query(array(
                    'message' => "бля только не эту парашу",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "украина") !== false) {
                $request_params = http_build_query(array(
                    'message' => "УКРАИНА В СЕРДЦЕ!ВСЕ МРАЗИ ПО ОДНОМУ КО МНЕ! ПОРВУ НА МАЛЮСКОВ!",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "пизда") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Тише тише не лезь к тому чего у тебя никогда не будет.",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "ангелина") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Я бы рассказал кто она по жизни и чем она занимается, но Илья запретил :(",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "илья") !== false) {
                $request_params = http_build_query(array(
                    'message' => "пидарас ебучий вообще как вы его в эту конфу пригласили не понимаю",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239026",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "карась класс") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Спасибо! Ведь я плаваю дял вас!",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239036",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "карась рифма") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Раунд!",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239047", "photo477189774_456239048", "photo477189774_456239050",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "карась, рифма") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Раунд!",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239028", "photo477189774_456239028", "photo477189774_456239028",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "курва") !== false) {
                $request_params = http_build_query(array(
                    'message' => "ОООО КТО У НАС ТУТ ТАКОЙ УМНЫЙ И РАЗГОВАРИВАЕТ НА ПОЛЬСКОМ",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "лох") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Лох здесь только ты ведь у меня есть отец.А у тебя не мамы не папы :(",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239034",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "подрочить на федорчук") !== false) {
                $request_params = http_build_query(array(
                    'message' => "Ошибка!Нельзя дрочить на бревно! \n Вот кстати страница бревна:",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => "photo477189774_456239046",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась дай музло") !== false) {
                $music = getMusic();
                $request_params = http_build_query(array(
                    'message' => "",
                    'peer_id' => $decres["updates"][1][3],
                    'attachment' => $music[array_rand($music)],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }

            if (mb_stripos($msg, "Карась добавь музло") !== false) {
                $type = $decres["updates"][1][6]["attach1_type"] . $decres["updates"][1][6]["attach1"];
                if (isMusicExists($type) == true) {
                    $request_params = http_build_query(array(
                        'message' => "Такая музыка уже есть в базе данных!",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                } else {
                    addNewMusic($type);
                    $request_params = http_build_query(array(
                        'message' => "Успешно добавил $type",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                }
            }

            if (mb_stripos($msg, "Карась дай видос") !== false) {
                $videostosend = array();
                $newmessage = "Получи и распишись:)";
                $tokenformother = '602e8d344e7684d9e3ace9007518e5da4267b54524d0a3e17c9918fc7b6ef76eea192ca57a3d6795a96e0';
                $request_params = http_build_query(array(
                    'owner_id' => '-45745333',
                    'access_token' => $tokenformother,
                    'v' => '5.0'
                ));
                $quer = json_decode(file_get_contents('https://api.vk.com/method/video.get?' . $request_params), 1);
                $items = $quer["response"]["items"];
                for ($i = 0; $i < count($items); $i++) {
                    array_push($videostosend, "video" . $items[$i]["owner_id"] . "_" . $items[$i]["id"]);
                }
                $request_params = http_build_query(array(
                    'owner_id' => '-89157850',
                    'access_token' => $tokenformother,
                    'v' => '5.0'
                ));
                $quer = json_decode(file_get_contents('https://api.vk.com/method/video.get?' . $request_params), 1);
                $items = $quer["response"]["items"];
                for ($i = 0; $i < count($items); $i++) {
                    array_push($videostosend, "video" . $items[$i]["owner_id"] . "_" . $items[$i]["id"]);
                }
                $request_params = http_build_query(array(
                    'owner_id' => '-30316056',
                    'count' => '100',
                    'access_token' => $tokenformother,
                    'v' => '5.0'
                ));
                $quer = json_decode(file_get_contents('https://api.vk.com/method/wall.get?' . $request_params), 1);
                $items = $quer["response"]["items"];
                for ($i = 0; $i < count($items); $i++) {
                    array_push($videostosend, "video" . $items[$i]["attachments"][0]["video"]["owner_id"] . "_" . $items[$i]["attachments"][0]["video"]["id"]);
                }
                $request_params = http_build_query(array(
                    'message' => "Получи и распишись",
                    'attachment' => $videostosend[array_rand($videostosend)],
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась мой баланс") !== false) {
                $request_params = http_build_query(array(
                    'message' => "💰Ваш баланс: " . getMoney($whosended) . " КарасьКоинов(КК)💰",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась шанс") !== false) {
                $what = implode(" ", array_slice(explode(" ", $msg), 2));
                $rand = mt_rand(1, 100);
                $request_params = http_build_query(array(
                    'message' => "Шанс $what равен $rand%",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "список товаров") !== false) {
                $what = implode(" ", array_slice(explode(" ", $msg), 2));
                $rand = mt_rand(1, 100);
                $request_params = http_build_query(array(
                    'message' => "📦 Список товаров 📦: \n 1.👍 Лайк на аву 👍(Стоимость:50)(Карась купить 1)\n2.📝 Роспись 📝(Стоимость:100)(Карась купить 2)\n3.❤ Лайк под закрепленную запись ❤(Стоимость:35)(Карась купить 3)\n4.❤ Добавление в друзья ❤(Стоимость:15)(Карась купить 4)\n5.📋 Репост вашей первой/закрепленной записи 📋(Стоимость:200)(Карась купить 5)",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась купить") !== false) {
                $what = explode(" ", $msg)[2];
                if ($what == 1) {
                    if (getMoney($whosended) >= 50) {
                        $request_params = http_build_query(array(
                            'user_ids' => "$whosended",
                            'fields' => "photo_id",
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        $photo_id = json_decode(file_get_contents('https://api.vk.com/method/users.get?' . $request_params), 1)["response"][0]["photo_id"];
                        $request_params = http_build_query(array(
                            'type' => "photo",
                            'owner_id' => explode("_", $photo_id)[0],
                            'item_id' => explode("_", $photo_id)[1],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        var_dump(file_get_contents('https://api.vk.com/method/likes.add?' . $request_params));
                        $request_params = http_build_query(array(
                            'message' => "✔ Лайк на аву успешно куплен.Проверяйте. ✔",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        takeMoney($whosended, 50);
                    } else {
                        $request_params = http_build_query(array(
                            'message' => "❌Ошибка, у вас не хватает денег. Вы можете их заработать на викторине❌",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                }
                if ($what == 2) {
                    if (getMoney($whosended) >= 100) {
                        $request_params = http_build_query(array(
                            'attachment' => $rospisphoto,
                            'message' => "Лови роспись!",
                            'owner_id' => $whosended,
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        var_dump(file_get_contents('https://api.vk.com/method/wall.post?' . $request_params));
                        $request_params = http_build_query(array(
                            'message' => "✔ Успешно запостил роспись на вашей странице. Проверяйте! ✔",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        takeMoney($whosended, 100);
                    } else {
                        $request_params = http_build_query(array(
                            'message' => "❌Ошибка, у вас не хватает денег. Вы можете их заработать на викторине❌",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                }
                if ($what == 3) {
                    if (getMoney($whosended) >= 35) {
                        $request_params = http_build_query(array(
                            'owner_id' => $whosended,
                            'count' => 1,
                            'filer' => "owner",
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        $res = json_decode(file_get_contents('https://api.vk.com/method/wall.get?' . $request_params), 1);
                        $request_params = http_build_query(array(
                            'type' => "post",
                            'owner_id' => $res["response"]["items"][0]["owner_id"],
                            'item_id' => $res["response"]["items"][0]["id"],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        var_dump(file_get_contents('https://api.vk.com/method/likes.add?' . $request_params));
                        $request_params = http_build_query(array(
                            'message' => "✔ Успешно поставил лайк на первую/закрепленную запись на вашей странице. Проверяйте! ✔",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        takeMoney($whosended, 35);
                    } else {
                        $request_params = http_build_query(array(
                            'message' => "❌Ошибка, у вас не хватает денег. Вы можете их заработать на викторине❌",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                }
                if ($what == 4) {
                    if (getMoney($whosended) >= 15) {
                        $request_params = http_build_query(array(
                            'user_id' => $whosended,
                            'text' => "✔ Вы купили добавление бота в друзья. Примите заявку ✔",
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        $res = json_decode(file_get_contents('https://api.vk.com/method/friends.add?' . $request_params), 1);
                        $request_params = http_build_query(array(
                            'message' => "✔ Отправил вам заявку в друзья. Примите её! ✔",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        takeMoney($whosended, 15);
                    } else {
                        $request_params = http_build_query(array(
                            'message' => "❌Ошибка, у вас не хватает денег. Вы можете их заработать на викторине❌",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                }
                if ($what == 5) {
                    if (getMoney($whosended) >= 200) {
                        $request_params = http_build_query(array(
                            'owner_id' => $whosended,
                            'count' => 1,
                            'filer' => "owner",
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        $res = json_decode(file_get_contents('https://api.vk.com/method/wall.get?' . $request_params), 1);
                        $request_params = http_build_query(array(
                            'object' => "wall".$res["response"]["items"][0]["owner_id"] . "_" . $res["response"]["items"][0]["id"],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        $res = json_decode(file_get_contents('https://api.vk.com/method/wall.repost?' . $request_params), 1);
                        $request_params = http_build_query(array(
                            'message' => "✔ Репостнул вашу первую/закрепленную запись. Проверяйте ✔",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                        takeMoney($whosended, 200);
                    } else {
                        $request_params = http_build_query(array(
                            'message' => "❌Ошибка, у вас не хватает денег. Вы можете их заработать на викторине❌",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                }
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась дай денег") !== false) {
                $moneytogive = explode(" ", $msg)[3];
                if ($whosended == 190846469 or $whosended == 455064951) {
                    giveMoney($whosended, $moneytogive);
                    $request_params = http_build_query(array(
                        'message' => "💰Держи на Xiaomi $moneytogive КарасьКоинов💰 \n💰Ваш новый баланс: " . getMoney($whosended) . " КарасьКоины(КК)💰",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                } else {
                    $request_params = http_build_query(array(
                        'message' => "Вы не в праве делать этого!",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                }
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась передай деньги") !== false) {
                $exploded = explode(" ", $msg);
                $nick = $exploded[3];
                $peredatmoney = $exploded[4];
                $request_params = http_build_query(array(
                    'user_ids' => "$nick",
                    'name_case' => "dat",
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                if ($peredatmoney >= 0) {
                    $resp = json_decode(file_get_contents('https://api.vk.com/method/users.get?' . $request_params), 1)["response"][0];
                    $idtogive = $resp["id"];
                    $fi = $resp["first_name"] . " " . $resp["last_name"];
                    takeMoney($whosended, $peredatmoney);
                    giveMoney($idtogive, $peredatmoney);
                    $request_params = http_build_query(array(
                        'message' => "Вы передали $fi $peredatmoney КарасьКоинов",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                } else {
                    $request_params = http_build_query(array(
                        'message' => "❌ Число не может быть отрицательным! ❌",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                }
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "викторина") !== false) {
                $vopros = getRandomQuestion();
                $question = $vopros["question"];
                $answer = $vopros["answer"];
                $id = $vopros["newid"];
                $countsymbols = iconv_strlen($answer, "UTF-8");
                $activated_victorinas[$whosended] = $id;
                $request_params = http_build_query(array(
                    'message' => "Вы начали играть в викторину , приятной игры!\n\n📝 Вопрос: $question 📝\n\n🔢 Букв в ответе: $countsymbols 🔢\n\n💰Приз за ответ: 2 КарасьКоина💰",
                    'peer_id' => $decres["updates"][1][3],
                    'access_token' => $token,
                    'v' => '5.38'
                ));
                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            if (mb_stripos($msg, "Карась установить баланс") !== false) {
                if ($whosended == 190846469 or $whosended == 455064951) {
                    $exploded = explode(" ", $msg);
                    $nick = $exploded[3];
                    $peredatmoney = $exploded[4];
                    $request_params = http_build_query(array(
                        'user_ids' => "$nick",
                        'name_case' => "dat",
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    $resp = json_decode(file_get_contents('https://api.vk.com/method/users.get?' . $request_params), 1)["response"][0];
                    $id = $resp["id"];
                    $fi = $resp["first_name"] . " " . $resp["last_name"];
                    setMoney($id, $peredatmoney);
                    $request_params = http_build_query(array(
                        'message' => "🔴Установлен баланс $fi $peredatmoney КарасьКоинов🔴\n\n🔵Теперь его баланс равен " . getMoney($id) . " КарасьКоинов(КК)🔵",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                    echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
                } else {
                    $request_params = http_build_query(array(
                        'message' => "Вы не в праве делать этого!",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                }
            }
            if (mb_stripos($msg, "Карась ставка") !== false) {
                $exploded = explode(" ", $msg);
                $nick = $exploded[2];
                $peredatmoney = $exploded[2];
                $random = mt_rand(1, 100);
                if (getMoney($whosended) > 0) {
                    if ($random > 50) {
                        $lastbalance = getMoney($whosended);
                        giveMoney($whosended, ($peredatmoney * 1.5));
                        $request_params = http_build_query(array(
                            'message' => "✔ Поздравляю, вы выйграли! ✔\n\n 💰 Ваша ставка: $peredatmoney 💰\n\n 💰 Ваш старый баланс: $lastbalance 💰 \n\n 💰 Ваш новый баланс: " . getMoney($whosended) . " 💰\n\n💻 Результат рандома: $random 💻",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    } else {
                        $lastbalance = getMoney($whosended);
                        takeMoney($whosended, $peredatmoney);
                        $request_params = http_build_query(array(
                            'message' => "❌ Сожалеем, но вы проиграли ❌ \n\n 💰 Мы отняли у вас сумму ставки $peredatmoney КарасьКоинов 💰 \n\n💰 Ваша ставка: $peredatmoney 💰\n\n 💰 Ваш старый баланс: $lastbalance 💰 \n\n 💰 Ваш новый баланс: " . getMoney($whosended) . " 💰\n\n💻 Результат рандома: $random 💻",
                            'peer_id' => $decres["updates"][1][3],
                            'access_token' => $token,
                            'v' => '5.38'
                        ));
                    }
                } else {
                    $request_params = http_build_query(array(
                        'message' => "❌ Ошибка, у вас не хватает денег ❌ \n\n💰 Заработать можно с помощью викторины(Карась викторина) 💰",
                        'peer_id' => $decres["updates"][1][3],
                        'access_token' => $token,
                        'v' => '5.38'
                    ));
                }

                echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
            }
            //в    if(mb_stripos($msg,"Карась "))
            echo $msg . "\n" . $result;
        } else {
            $request_params = http_build_query(array(
                'message' => "Пидорам не отвечаю.",
                'peer_id' => $decres["updates"][1][3],
                'access_token' => $token,
                'v' => '5.38'
            ));
         //   echo "get log:" . file_get_contents('https://api.vk.com/method/messages.send?' . $request_params) . "\n";
        }
    }
    echo $result;
}