<?php
namespace GetLink;

use \App\Support;

class ZingMp3 extends Support {

    private $API = [
        'bai-hat'      =>  'http://api.mp3.zing.vn/api/mobile/song/getsonginfo?keycode=fafd463e2131914934b73310aa34a23f&requestdata={"id":"%s"}',
        'video-clip'   =>  'http://api.mp3.zing.vn/api/mobile/video/getvideoinfo?keycode=fafd463e2131914934b73310aa34a23f&requestdata={"id":"%s"}'
    ];

    private function parseUrl($URL) {
		preg_match('/(http:\/\/)?mp3.zing.vn\/(bai-hat|video-clip)\/([\w\-]+)\/(\w{8}).html/', $URL, $ID);
        return (empty($ID)) ? false : [$ID[2], $ID[4]];
    }

    public static function get($Url = null, $Get = []) {
        $Mp3 = new self();

        $Mp3->checkIssetUrl($Url, 'ZingMp3');

        $ID_Type = $Mp3->parseUrl($Url);

        if ($ID_Type === false) {
            trigger_error('URL không hợp lệ, vui lòng kiểm tra lại URL', E_USER_ERROR);
            return false;
        }

        $URL_API = sprintf($Mp3->API[$ID_Type[0]], $ID_Type[1]);

        $Json = json_decode($Mp3->Curl($URL_API), true);

        return json_encode($Mp3->pushArr($Json, $Get));
    }

}
