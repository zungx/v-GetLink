<?php

namespace App;

use App\Helpers;

class Support extends Helpers {

    private static $instance = false;

    protected $useCurl = true;

    protected $listModule = [
        'ZingMp3'   => false
    ];

    protected function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

    public static function getInstance() {
        if ((bool)self::$instance === false) {
            self::$instance = new Support;
            self::$instance->Check_Curl();
            self::$instance->Check_PHPVersion();
        }
        return self::$instance;
    }

    private function Check_Curl() {
        return ($this->Helper_Check_Curl() === false) ? trigger_error('Curl đã bị tắt trên server, vui lòng mở chức năng Curl trên server để tiếp tục sử dụng', E_USER_NOTICE) : true;
    }

    private function Check_PHPVersion() {
        return ($this->Helper_Check_PHPVersion() === false) ? trigger_error('Phiên bản PHP không phù hợp, yêu cầu phiên bản PHP >= 5.4.0', E_USER_NOTICE) : true;
    }

    protected function pushArr($jSon, $Get) {
        if (empty($Get)) return $jSon;
        $Return = [];
        foreach ($Get as $Key => $Val) {
            if ($Key === 0) $Return[$Val] = $jSon[$Val];
            if ($Key !== 0) {
                foreach ($Val as $_Key) {
                    $Return[$_Key] = $jSon[$Key][$_Key];
                }
            }
        }
        return $Return;
    }

    protected function checkIssetUrl($Url, $Server) {
        if (empty($Url)) trigger_error('Bạn chưa nhập URL (Server: '. $Server .')', E_USER_ERROR);
    }

    protected function Curl($URL, $PostData = null) {
        if ($this->Helper_Check_Curl() === true) {
            $Source = $this->Helper_Curl($URL, $PostData);
            return ($Source !== false) ? $Source : trigger_error('Không thể lấy dữ liệu từ URL: ' . $URL, E_USER_ERROR);
        } else {
            return $this->Helper_File_Get_Contents();
        }
    }
}
