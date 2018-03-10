<?php
/**
 * Created by PhpStorm.
 * User: Newmcpe
 * Date: 07.03.2018
 * Time: 17:36
 */
header("Content-type: image/png");
$token = "8f3c0adb4483895ef105b8e0a85d4b74ca8500af8b6a04bb238844d2180582e7add931ab4f8c7980d1da2";
date_default_timezone_set("	Asia/Irkutsk");
$request_params = http_build_query(array(
    'group_id' => '154749823',
    'sort' => 'time_desc',
    'count' => '1',
    'fields' => 'photo_200_orig',
    'access_token' => $token,
    'v' => '5.0'
));
$query = json_decode(file_get_contents('https://api.vk.com/method/groups.getMembers?' . $request_params),1);
$lastSubscriberPhoto = $query["response"]["users"]["0"]["photo_200_orig"];
$firstName = $query["response"]["users"]["0"]["first_name"];
$lastName = $query["response"]["users"]["0"]["last_name"];
$im = imagecreatefromjpeg(__DIR__."/images/cover.jpg");
$stamp = roundedCorners(imagecreatefromjpeg($lastSubscriberPhoto),200);
imagecopy($im,$stamp,1382,168,0,0,imagesx($stamp),imagesx($stamp));
imagettftext($im,25,0,1368,395,imagecolorallocate($im,255,255,255),__DIR__."/fonts/font.ttf",$firstName . " " . $lastName);
imagettftext($im,22,0,1411,160,imagecolorallocate($im,255,255,255),__DIR__."/fonts/font.ttf","Новенький:");
imagettftext($im,25,0,0,363,imagecolorallocate($im,255,255,255),__DIR__."/fonts/font.ttf","".date("j Марта\nH:i"));
imagejpeg($im,NULL,100);
imagedestroy($im);

function roundedCorners($img_res, $radius)
{
    $width  = imagesx($img_res);
    $height = imagesy($img_res);

    imagesavealpha($img_res, true);

    // corners START
    $img_tmp = imagecreate($width, $height);

    $black  = imagecolorallocate($img_tmp, 0, 0, 0);
    $transp = imagecolorallocatealpha($img_tmp,
        0, 0, 0, 127);

    imagefill($img_tmp, $width / 2, $height / 2, $transp);

    // left upper
    imagearc($img_tmp,  $radius / 2 - 1,
        $radius / 2 - 1,
        $radius,
        $radius, 180, 270, $black);
    imagefill($img_tmp, 0, 0, $black);
    // right upper
    imagearc($img_tmp,  $width - $radius / 2,
        $radius / 2 - 1,
        $radius,
        $radius, 270, 0, $black);
    imagefill($img_tmp, $width - 1, 0, $black);
    // right lower
    imagearc($img_tmp,  $width - $radius / 2,
        $height - $radius / 2,
        $radius,
        $radius, 0, 90, $black);
    imagefill($img_tmp, $width - 1, $height - 1, $black);
    // left lower
    imagearc($img_tmp,  $radius / 2 - 1,
        $height - $radius / 2,
        $radius,
        $radius, 90, 180, $black);
    imagefill($img_tmp, 0, $height - 1, $black);

    // corners END

    imagecopyresampled($img_res, $img_tmp,
        0, 0, 0, 0,
        $width, $height, $width, $height);

    $transp = imagecolorallocatealpha($img_res,
        0, 0, 0, 127);
    imagefill($img_res, 0, 0, $transp);
    imagefill($img_res, $width - 1, 0, $transp);
    imagefill($img_res, $width - 1, $height - 1, $transp);
    imagefill($img_res, 0, $height - 1, $transp);

    imagedestroy($img_tmp);

    return $img_res;
}