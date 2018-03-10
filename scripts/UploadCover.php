<?php
/**
 * Created by PhpStorm.
 * User: Newmcpe
 * Date: 07.03.2018
 * Time: 19:17
 */
$tmp_image = file_get_contents("http://194.67.200.179/scripts/DynamicCover.php");
file_put_contents(__DIR__."/images/dynamiccover.jpg","$tmp_image");
$token = "8f3c0adb4483895ef105b8e0a85d4b74ca8500af8b6a04bb238844d2180582e7add931ab4f8c7980d1da2";
$request_params = http_build_query(array(
    'group_id' => '154749823',
    'crop_x2' => '1590',
    'crop_y2' => '400',
    'access_token' => $token,
    'v' => '5.0'
));
$query = json_decode(file_get_contents('https://api.vk.com/method/photos.getOwnerCoverPhotoUploadServer?' . $request_params));
$url = $query->response->upload_url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, array("photo" => new CURLFile(__DIR__."/images/dynamiccover.jpg","image/jpeg","image0")));
$otvet = json_decode(curl_exec($ch),1);
var_dump($otvet);
curl_close($ch);
$request_params = http_build_query(array(
    'hash' => $otvet["hash"],
    'photo' => $otvet["photo"],
    'access_token' => $token,
    'v' => '5.0'
));
$query = json_decode(file_get_contents('https://api.vk.com/method/photos.saveOwnerCoverPhoto?' . $request_params));
echo "\n";
var_dump($query);
