<?php
/**
 * Created by PhpStorm.
 * User: Newmcpe and MrKarasik
 * Date: 03.03.2018
 * Time: 23:37
 */

function getAnswerForThis($message, $user_id, $token)
{
    $tokenformother = '4bcb984467ae2e03632f622cdea9dd815990aae5d5efa18e815650bd9f8e2f552ec0dfeb9dac2f0218bd5';
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0"));
    $user_name = $user_info->response[0]->first_name . " " . $user_info->response[0]->last_name;
    if (mb_stripos($message, "привет", 0, "utf-8") !== false) {
        $newmessage = "😎Приветствую, друг $user_name.😎 \n 📱Я бот МЕМАСЫ 8И желаю приятно провести время📱\n🔴Доступные функции🔴:\n 1.💾Команды 💾 \n 2.😄 Для веселья 😄 \n 3.☕ Картинки и т.д ☕ \n 4.🚔Оскорбления и пожелания🚔 \n 5.📖Истории📖 \n 6.📢Рассылки📢";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'access_token' => $token,
            'attachment' => 'photo-154749823_456239653',
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "рассылки") !== false) {
        $newmessage = "🔴Это рассылка уникальна!Не такая как на странцие группы!Вам будет приходить оповещение о новых мемах и т.д!Подпишись!🔴 \n 👍Подписаться на рассылку👍 \n 👎Отписаться от рассылки👎 \n 🔴Команда \"Рассылка(текст)\"(для админов)🔴";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239645",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "истории") !== false) {
        $newmessage = "💂История аслана💂 \n 🙅История милы🙅";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239654",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "команды") !== false) {
        $newmessage = "1.📅 Расписание 📅 \n 2.🎧 Узнать ид музыки 🎧 \n 3.🎬 Узнать ид видео 🎬 \n 4.📢 Подписаться на рассылку 📢  \n 5.💾 О боте 💾 \n 6.📱 Посчитать 📱 ";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239646",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "для веселья") !== false) {
        $newmessage = "1.😄 Илья пидор 😄 \n 2.🤷🏻‍♂️ Мила 🤷🏻‍♂️ \n 3.🔞 Алиса, измерь мой писос 🔞 \n 4.🔞 Хентай 🔞 \n 5.🤷🏻‍♂️ Витя 🤷🏻‍♂️ \n 6. 🔞 Порно 🔞 \n 7.🔞Юлька, определи мою ориентацию🔞 \n 8.🔞Подрочить на Федорчук🔞 \n  9.🤷🏻‍♂️Фускуф🤷🏻‍♂️";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239647",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "Картинки и т.д") !== false) {
        $newmessage = "1.📷Мем📷 \n 2.📷Картинка📷 \n 3.🎧Аудио🎧 \n 4.🎬Видео🎬 \n 5.💾 Для важных переговоров 💾";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239017",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "Оскорбления и пожелания") !== false) {
        $newmessage = "1.Гадайте сами:)";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239170",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "Посчитать") !== false) {
        $newmessage = "Вот комманды для кулькулятора: \n Работает только умножение и вычетание! \n Пишите слово !Калькулятор! Потом пишите число знак -(если хотите вычитание) или знак x(если умножение)";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239648",
            'access_token' => $token,
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
    if (mb_stripos($message, "илья пидарас") !== false) {
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
        if (isSubscribedToSendMessages($user_id) == true) {
            $newmessage = "Ошибка, вы уже подписаны на рассылку";
            $request_params = array(
                'message' => $newmessage,
                'attachment' => 'photo-154749823_456239643',
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
            subscribeToSendMessages($user_id);
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
    if (mb_stripos($message, "хорош") !== false) {
        $request_params = array(
            'message' => "Я знаю",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "фускуф") !== false) {
        $request_params = array(
            'message' => "Помним.Чтим.Скорбим.",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "смешно") !== false) {
        $request_params = array(
            'message' => "Хоть кто-то смеётся с моих шуток",
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
    if (mb_stripos($message, "годно") !== false) {
        $newmessage = "Спасибо! Я улучшаюсь для вас!";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239655",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "бот класс") !== false) {
        $newmessage = "Спасибо! Я улучшаюсь для вас!";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239655",
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
    if (mb_stripos($message, "история аслана") !== false) {
        $newmessage = " \n Давайте поиграем в игру \"Ассоциации\". Я начинаю первым! \n Хмм, что же загадать? Придумал, шептун! А вы теперь \n отгадываете с каким одноклассником это связано. Мда... Я \n загадал слишком лёгкое, каждый же отгадал, что это Аслан! \n Аслан - хороший друг и очень большой одноклассник. \n \"Поможет в беде, съест вас в радости!\" \n - эти слова про него, он весит больше, чем 10 Федорчук (Федорчук - единица измерения веса во вселенной восьмых классов школы №7). \n Но Витя всё ещё может кинуть его на прогиб, при его таком большом весе. \n А теперь переместимся в раздевалку. Только вспомните его животик когда он снимает свою футболку. А его ножки - это самое лучшее, что есть на этой планете. \n Я вспоминаю про них, когда ем сочные и жирные крылышки из KFC.Все девочки текут по Асланчику.";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239649",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "история милы") !== false) {
        $newmessage = "Мила, Мила, Мила... Это имя уже у каждого на слуху, но как \n она стала такой? Всё началось с того, как она в середине 7 \n класса пришла к нам в школу. Она сразу начала подкатывать к некоторым парням (в том числе и одному из админов) \n Сначала мы все считали её обычной одноклассницей, но в начале 8 класса все узнали о её увлечении конным спортом \n Так же у неё есть собственный канал видеохостинге \"YouTube\" \n Мы сразу начали добро над неё шутить, но она это всё воспринимала всерьёз. И тогда началось противостояние! \n  Мы начали делать про неё много-много мемов, а потом нашли её вторую страницу с приват фотографиями. \n Она на них курила, бухала со своей ЛП Викой! \n (напишу комманду \"продолжение истории милы\" чтобы продолжить читать)  ";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239650",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "Продолжение истории милы") !== false) {
        $request_params = array(
            'message' => "Эти фото мы слили, так как админы за ЗОЖ.\n И началась волна мемов с ними, как раз тогда популярность нашей группы сильно возросла. \n После этих действий она стала очень дерзкой (как пуля резкой) и борзой. \n Но вскоре она встала на путь исправления - стала прилично себя вести с одноклассниками. Сейчас она вполне обычная одноклассница, со своими интересами и вкусами, которые каждый из нас должен уважать!  ",
            'user_id' => $user_id,
            'attachment' => " photo-154749823_456239651",
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
    if (mb_stripos($message, "юлька, определи мою ориентацию") !== false) {
        $newmessage = "🔞Юлия Сомова определила твою ориетацию🔞";
        $som = array("photo-154749823_456239666", "photo-154749823_456239667", "photo-154749823_456239668");
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => $som [array_rand($som)],
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "юлька, определи мою ориентацию") !== false) {
        $newmessage = "🔞Юлия Сомова определила твою ориетацию🔞";
        $som = array("photo-154749823_456239666", "photo-154749823_456239667", "photo-154749823_456239668");
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => $som [array_rand($som)],
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "Лох") !== false) {
        $newmessage = "Лох-это фамилия твоей семьи";
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239661",
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
        $request_params = array(
            'message' => "Получи и распишись",
            'user_id' => $user_id,
            'attachment' => $videostosend[array_rand($videostosend)],
            'access_token' => $token,
            'v' => '5.0'
        );/**/
    }

    if (mb_stripos($message, "узнать ид музыки") !== false) {
        $datapizdata = json_decode(file_get_contents('php://input'), 1);
        if (!isset($datapizdata["object"]["attachments"][0]["audio"])) {
            $request_params = array(
                'message' => "Ошибка, прикрепите к сообщению аудиозапись",
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239643',
                'access_token' => $token,
                'v' => '5.0'
            );
        } else {
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
    }

    if (mb_stripos($message, "узнать ид видео") !== false) {
        $datapizdata = json_decode(file_get_contents('php://input'), 1);
        if (!isset($datapizdata["object"]["attachments"][0]["video"])) {
            $request_params = array(
                'message' => "Ошибка, прикрепите к сообщению видеозапись",
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239643',
                'access_token' => $token,
                'v' => '5.0'
            );
        } else {
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
    }
    if (mb_stripos($message, "аудио") !== false) {
        $newmessage = "Лови и диградируй";
        $musica = array("audio455064951_456239340", "audio455064951_456239348", "audio455064951_456239303", "audio455064951_456239309", "audio455064951_456239347", "audio455064951_456239343", "audio190846469_456239154", "audio455064951_456239358", "audio455064951_456239353", "audio455064951_456239359");
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
    if (mb_stripos($message, "пропиздон") !== false) {
        $request_params = array(
            'message' => "Может хватит уже.Мне мама просто так по шутке сказала 😢(Илья)",
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
    if (mb_stripos($message, "я порно хочу") !== false) {
        $request_params = array(
            'message' => "А я твою мать ну и?",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "псина") !== false) {
        $request_params = array(
            'message' => "Псина твой отец!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "класс") !== false) {
        $request_params = array(
            'message' => "Как мило!Спасибо :)",
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
    if (mb_stripos($message, "шлюха") !== false) {
        $request_params = array(
            'message' => "Шлюха професия твоей мамы.",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "плохой") !== false) {
        $request_params = array(
            'message' => "Не завидуй мне.",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "мне похуй") !== false) {
        $request_params = array(
            'message' => "мне тоже.",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "похуй") !== false) {
        $request_params = array(
            'message' => "Мне тоже.",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "лошадь") !== false) {
        $request_params = array(
            'message' => "Прости сегодня без деревенских утех :(",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "пидр") !== false) {
        $request_params = array(
            'message' => "Пидр твой отвец",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "пока") !== false) {
        $request_params = array(
            'message' => "До скорых встреч!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "нет") !== false) {
        $request_params = array(
            'message' => "пидора ответ",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "голубой") !== false) {
        $request_params = array(
            'message' => "Так называется твой билет проездной",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "ладно") !== false) {
        $request_params = array(
            'message' => "в трусах прохладно!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "люблю тебя") !== false) {
        $request_params = array(
            'message' => "Как мило! А я тебя нет!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "прошмандовка") !== false) {
        $request_params = array(
            'message' => "Профессия твоей мамы!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "гандон") !== false) {
        $request_params = array(
            'message' => "По гандону твоя мать течёт!",
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
    if (mb_stripos($message, "параша") !== false) {
        $request_params = array(
            'message' => "Твоя мамаша!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "блядь") !== false) {
        $request_params = array(
            'message' => "Блять здесь только ты!",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "петух") !== false) {
        $request_params = array(
            'message' => "Твой отец",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "в смысле") !== false) {
        $request_params = array(
            'message' => "В коромысле",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "подрочить на Федорчук") !== false) {
        $request_params = array(
            'message' => "Она бревно :(. Порно не найдено!",
            'user_id' => $user_id,
            'attachment' => "photo-154749823_456239662",
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "сучка") !== false) {
        $request_params = array(
            'message' => "Твоя ручка",
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
    if (mb_stripos($message, "бот хороший") !== false) {
        $request_params = array(
            'message' => "Спасибо!",
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
    if (mb_stripos($message, "мать сдохнет") !== false) {
        $request_params = array(
            'message' => "У меня нет, а вот твоей маме уже заказываю гроб из твоих денег :(",
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "калькулятор") !== false) {
        // калькулятор(0) 2(1) +(2) 2(3)
        $exploded = explode(" ", $message);
        if ($exploded[2] = "+") {
            $newmessage = $exploded[1] + $exploded[3] . "\ndebug:plus";
        }
        if ($exploded[2] = "-") {
            $newmessage = $exploded[1] - $exploded[3] . "\ndebug:minus";
        }
        if ($exploded[2] = "/") {
            $newmessage = $exploded[1] / $exploded[3] . "\ndebug:razdelit";
        }
        if ($exploded[2] = "*") {
            $newmessage = $exploded[1] * $exploded[3] . "\ndebug:umnozhit\n" . implode(" ", $exploded);
        }
        $request_params = array(
            'message' => $newmessage,
            'user_id' => $user_id,
            'access_token' => $token,
            'v' => '5.0'
        );
    }
    if (mb_stripos($message, "рассылка") !== false) {
        $request_params = http_build_query(array(
            'group_id' => '154749823',
            'filter' => 'managers',
            'access_token' => $token,
            'v' => '5.0'
        ));
        $quer = file_get_contents('https://api.vk.com/method/groups.getMembers?' . $request_params);
        if (mb_stripos($quer, $user_id) !== false) {
            $messagetosend = implode(" ", array_slice(explode(" ", $message), 1));
            $request_params = array(
                'message' => "Начинаю отсылать сообщения....",
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239645',
                'access_token' => $token,
                'v' => '5.0'
            );
            sendMessages($token, $messagetosend);
        } else {
            $request_params = array(
                'message' => "Прости,но ты не избраный :(",
                'user_id' => $user_id,
                'attachment' => 'photo-154749823_456239643',
                'access_token' => $token,
                'v' => '5.0'
            );
        }
    }
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}