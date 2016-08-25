<?php
namespace GetLink;

use \App\Support;

class vNCT extends Support {

    private function getXMLurl($URL) {
        $Source = $this->Curl($URL);
        if (preg_match('/http:\/\/v.nhaccuatui.com\/flash\/xml\?key2=([a-z0-9]+)/', $Source, $XML_URL) === 1) return $XML_URL[0];
        if (preg_match('/play_key="([a-z0-9]+)"/', $Source, $XML_URL) === 1) return 'http://v.nhaccuatui.com/flash/xml?key5=' . $XML_URL[1];
    }

    private function getDataXML($URL) {
        return $this->Curl($this->getXMLurl($URL));
    }

    private function string_between($string, $start, $end, $inclusive = false) {
        $fragments = explode($start, $string, 2);
        if (isset($fragments[1])) {
            $fragments = explode($end, $fragments[1], 2);
            if ($inclusive) {
                return $start.$fragments[0].$end;
            } else {
                return $fragments[0];
            }
        }
        return false;
    }

    private function parseURL($URL) {
        if (strpos($URL, '/phim/') || strpos($URL, '/hoat-hinh/')) $exp = '/^http:\/\/v.nhaccuatui.com\/(phim|hoat-hinh)\/([\w\-]+)\.(\w+)\.html\?key=(\w+)$/';
        if (strpos($URL, '/video/')) $exp = '/^http:\/\/v.nhaccuatui.com\/video\/([\w\-]+)\.(\w+)\.html$/';
        preg_match($exp, $URL, $ID);
        if (empty($ID) === false) return (isset($ID[4])) ? $ID[4] : $ID[2];
        return false;
    }

    private function getWithKey($Get, $Data) {
        $Return = [];
        foreach ($Get as $value) {
            $Return[$value] = $this->string_between($Data, "<$value>", "</$value>");
        }
        return $Return;
    }

    private function getAllKey($Data) {
        $Return = [];
        preg_match_all('/<(.*)>(.*)<\/(.*)>/', $Data, $Tag);
        foreach ($Tag[2] as $key => $value) {
            $Return[$Tag[3][$key]] = $value;
        }
        unset($Tag);
        return $Return;
    }

    protected function pushArr($Get, $Data) {
        if (empty($Get)) {
            return $this->getAllKey($Data);
        }
        return $this->getWithKey($Get, $Data);
    }

    public static function get($URL = null, $Get = []) {
        $vNCT = new self();
        $vNCT->checkIssetUrl($URL, 'v.Nhaccuatui');

        $ID = $vNCT->parseURL($URL);
        if ($ID === false) trigger_error('URL không hợp lệ, vui lòng thử lại', E_USER_ERROR);

        $XML = $vNCT->getDataXML($URL);

        $Split = str_replace('<![CDATA[', '', explode('</item>', explode('<item>', $XML)[1])[0]);
        $Split = str_replace(']]>', '', $Split);

        return json_encode($vNCT->pushArr($Get, $Split));
    }
}
