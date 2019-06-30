<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('removeAccent')) {
    function removeAccent($str){
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        $str = str_replace(' ', '_', $str);
        return $str;
    }
}

if(!function_exists('getVideoYoutubeId')){
    function getVideoYoutubeId($videoUrl){
        preg_match_all("#(?<=v=|v\/|vi=|vi\/|youtu.be\/)[a-zA-Z0-9_-]{11}#", $videoUrl, $matches);
        if(!empty($matches[0])) return $matches[0][0];
        return '';
    }
}

if (!function_exists('curlCrawl')){
    function curlCrawl($url, $postStr = array()){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        set_time_limit (60);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
        //Set the proxy IP.
        // curl_setopt($ch, CURLOPT_PROXY, '128.199.129.127');
        // curl_setopt($ch, CURLOPT_PROXYPORT, '80');
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:39.0) Gecko/20100101 Firefox/39.0");
        if (!empty($postStr)) {
            curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($postStr, '', '&', PHP_QUERY_RFC3986));
            curl_setopt ($ch, CURLOPT_POST, TRUE);
        }
        curl_setopt ($ch, CURLOPT_REFERER, $url);

        if(curl_errno($ch)){
            curl_close($ch);
            return false;
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('curlMulti')){
    function curlMulti($url, $postStr){
        $result = '';
        // array of curl handles
        $multiCurl = array();
        // data to be returned
        $result = array();
        // multi handle
        $mh = curl_multi_init();
        foreach ($ids as $i => $id) {
          // URL from which data will be fetched
          $fetchURL = $url.$id;
          $multiCurl[$i] = curl_init();
          curl_setopt($multiCurl[$i], CURLOPT_URL,$fetchURL);
          curl_setopt($multiCurl[$i], CURLOPT_HEADER,0);
          curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER,1);
          curl_multi_add_handle($mh, $multiCurl[$i]);
        }
        $index=null;
        do {
          $result =  curl_multi_exec($mh,$index);
        } while($index > 0);
        // get content and remove handles
        foreach($multiCurl as $k => $ch) {
          $result[$k] = curl_multi_getcontent($ch);
          curl_multi_remove_handle($mh, $ch);
        }
        // close
        curl_multi_close($mh);

        return $result;
    }
}