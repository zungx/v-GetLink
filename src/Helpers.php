<?php

namespace App;

class Helpers {

    protected function Helper_Check_Curl() {
        return ($this->useCurl === true && function_exists('curl_version') === true) ? true : false;
    }

    protected function Helper_Check_PHPVersion() {
        return ((float)phpversion() < (float)'5.4.0') ? false : true;
    }

    protected function Helper_Curl($Url, $PostData) {
        $ch = curl_init();

        if ($PostData !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'X-Requested-With: XMLHttpRequest',
                'Conten-Length: ' . strlen($PostData)
            ]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $PostData);
        }

        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $Data = curl_exec($ch);
        if (!$Data) return False;
        $HttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($HttpCode >= 200 && $HttpCode < 300) ? $Data : False;
    }
}
