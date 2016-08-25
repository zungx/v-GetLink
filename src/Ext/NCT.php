<?php

namespace GetLink;

use \App\Support;
//use GetLink\vNCT;

class NCT extends Support {

    private $token = 'nct@asdgvhfhyth1391515932000';

    private $index = 1, $size = 30;

    private function createToken($type, $id) {
        return md5($type . $id . $this->token);
    }

    private function createSearchToken($type, $keyword){
        return md5($type . $keyword . $this->index . $this->size . $this->token);
	}

    private function buildURL($action, $token, $option){
        return 'http://api.m.nhaccuatui.com/mobile/v5.0/api?secretkey=nct@mobile_service&deviceinfo={"DeviceID":"90c18c4cb3c37d442e8386631d46b46f","OsName":"ANDROID","OsVersion":"10","AppName":"NhacCuaTui","AppVersion":"5.0.1","UserInfo":"","LocationInfo":""}&pageindex=' . $this->index . '&pagesize=' . $this->size . '&time=1391515932000&token=' . $token . '&action=' . $action . '&' . $option;
	}

    private function testURL($URL) {
        return (preg_match('/(http:\/\/(w{3}).)?nhaccuatui.com\/(bai-hat|video)\/([\w\-]+).(\w+).html/', $URL, $Type) === 1) ? [$Type[3], $URL] : false;
    }

    private function getID($URL) {
        preg_match('/itemid:(\d+)/', $this->Curl($URL), $item);
        return (empty($item)) ? false : $item[1];
	}

    private function getInfo($ID, $Key) {
        $token = $this->createToken($Key[0], $ID);
        $URL = $this->buildURL($Key[0], $token, $Key[1] . $ID);
        $Json = json_decode($this->Curl($URL), true);
        return $Json;
    }

    public static function get($URL = null, $Get = []) {
        $NCT = new self();

        $NCT->checkIssetUrl($URL, 'Nhaccuatui');

        $Check = $NCT->testURL($URL);

        if ($Check === false) {
            trigger_error('URL không hợp lệ', E_USER_NOTICE);
            return false;
        }

        $ID = $NCT->getID($Check[1]);

        if ($Check[0] === 'bai-hat') $Data = $NCT->getInfo($ID, ['get-song-info', 'songid=']);

        if ($Check[0] === 'video') $Data = $NCT->getInfo($ID, ['get-video-detail', 'videoid=']);

        return json_encode($NCT->pushArr($Data, $Get));
    }
}
