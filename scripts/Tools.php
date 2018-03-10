<?php
/**
 * Created by PhpStorm.
 * User: Newmcpe
 * Date: 03.03.2018
 * Time: 15:30
 */
$tokenfor = '602e8d344e7684d9e3ace9007518e5da4267b54524d0a3e17c9918fc7b6ef76eea192ca57a3d6795a96e0';
function getMySQLConnection()
{
    $connection = mysqli_connect("127.0.0.1", "root", "artemcfki", "Server");
    mysqli_set_charset($connection,"utf8");
    return $connection;
}

function isSubscribedToSendMessages($id)
{
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM subscribers WHERE id='$id'");
    if (mysqli_num_rows($query) >= 1) {
        return true;
    } else {
        return false;
    }
}

function subscribeToSendMessages($id)
{
    $query = mysqli_query(getMySQLConnection(), "INSERT INTO subscribers (id) VALUES ('$id')");
    if ($query) return true;
}

function unSubscribeFromSendMessages($id)
{
    $query = mysqli_query(getMySQLConnection(), "DELETE FROM subscribers WHERE id = '$id'");
    if ($query) return true;
}

function getSubscribers()
{
    $subscribers = "";
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM subscribers");
    while ($row = mysqli_fetch_assoc($query)) {
        $subscribers = $subscribers . $row["id"] . ",";
    }
    return $subscribers;
}

function getMoney($id){
    $money = 0;
    if(isAccountExsists($id)) {
        $query = mysqli_query(getMySQLConnection(), "SELECT * FROM usermoney WHERE id = '$id'");
        $money = mysqli_fetch_assoc($query)["money"];
        echo "Аккаунт существует\n";
    } else {
        $query = mysqli_query(getMySQLConnection(),"INSERT INTO usermoney (id,money) VALUES ('$id','0')");
        echo "Аккаунт несуществует\n";
        var_dump($query);
    }
    return $money;
}
function giveMoney($id,$money){
    if(isAccountExsists($id)) {
        $query = mysqli_query(getMySQLConnection(), "UPDATE usermoney SET money=money+$money WHERE id = '$id'");
        var_dump($query);
    } else {
        $query = mysqli_query(getMySQLConnection(),"INSERT INTO usermoney (id,money) VALUES ($id,'$money')");
        var_dump($query);
    }
}
function takeMoney($id,$money){
    if(isAccountExsists($id)) {
        $query = mysqli_query(getMySQLConnection(), "UPDATE usermoney SET money=money-$money WHERE id = '$id'");
        var_dump($query);
    }
}
function setMoney($id,$money){
    if(isAccountExsists($id)) {
        $query = mysqli_query(getMySQLConnection(), "UPDATE usermoney SET money = '$money' WHERE id = '$id'");
        var_dump($query);
    }
}
function isAccountExsists($id){
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM usermoney WHERE id = '$id'");
    if(mysqli_num_rows($query) == 1){
        return true;
    }
}
function getRandomQuestion()
{
    $subscribers = array();
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM viktorina");
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($subscribers,$row);
    }
    return $subscribers[array_rand($subscribers)];
}

function getQuestion($id)
{
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM viktorina WHERE newid = '$id'");
    $row = mysqli_fetch_assoc($query);
    var_dump($row);
    return $row;
}

function addNewMusic($id)
{
    $query = mysqli_query(getMySQLConnection(), "INSERT INTO music (id) VALUES ('$id')");
    if ($query) return true;
}

function isMusicExists($id)
{
    $query = mysqli_query(getMySQLConnection(), "SELECT * FROM music WHERE id='$id'");
    if (mysqli_num_rows($query) >= 1) {
        return true;
    } else {
        return false;
    }
}

function sendMessagesPost($token, $textpost, $message)
{
    $messagetosend = "Новый пост/мем в группе: \n Зайди зацени! \nТекст поста/мема:\n $textpost";
    $request_params = array(
        'message' => $messagetosend,
        'user_ids' => getSubscribers(),
        'access_token' => $token,
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}

function sendMessages($token, $messagetosend)
{
    $request_params = array(
        'message' => $messagetosend,
        'user_ids' => getSubscribers(),
        'access_token' => $token,
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}

function sendMessage($token, $messagetosend, $userid,$attach)
{
    $request_params = array(
        'message' => $messagetosend,
        'user_id' => $userid,
        'attachment' => $attach,
        'access_token' => $token,
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}