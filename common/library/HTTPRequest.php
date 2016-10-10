<?php
/**
 * Created by PhpStorm.
 * User: Veaer
 * Date: 14-5-24
 * Time: 上午11:31
 */
namespace common\library;

class HTTPRequest {
    public static $defaultUserAgent = 'Mozilla/5.0 (iPad; U; CPU OS 4_3_0 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10';

    public static function asyncRequest($url, $timeout = 0, $ua = null)
    {
        //$defhost = parse_url(Yii::app()->request->hostInfo);
        $vars = parse_url(str_replace('&amp;', '&',$url));
        $host = empty($vars['host']) ? '127.0.0.1' : $vars['host'];
        $path = $vars['path'];
        $query = isset($vars['query']) ? $vars['query'] : '';
        $fp = fsockopen($host, 80, $errno, $errstr, $timeout);
        if (!$fp) {
            return array('code'=>400,'error'=>$errstr,'errno'=>$errno);
        } else {
            $out = "GET " . $path .'?'. $query . " HTTP/1.1\r\n";
            $out .= "Host: " . $host . "\r\n";
            $out .= "Connection: Close\r\n\r\n";

            $result = array('Status'=>'OK', 'Content'=>'');

            fwrite($fp, $out);
            if ($timeout > 0) {
                while (!feof($fp)) {
                    $buffer = fgets($fp, 1024);
                    if (strncmp($buffer, 'HTTP', 4) == 0) {
                        $vars = explode(' ', $buffer);
                        if ($vars[1] != 200) {
                            $result['Status'] = 'Fail';
                            $result['Code'] = $vars[1];
                        }
                    }
                    if (strncmp($buffer, '{', 1) == 0 || strncmp($buffer, '[', 1) == 0) {
                        $result['Content'] .= $buffer;
                    }
                }
                if ($result['Status'] != 'Fail') {
                    $result = json_decode($result['Content']);
                }
            }
            fclose($fp);
            return $result;
        }
    }

    public static function smsRequest($url, $params)
    {
        $param_str = http_build_query($params);
        $length = strlen($param_str);
        $vars = parse_url($url);
        $host = $vars['host'];
        $port = empty($vars['port']) ? 80 : $vars['port'];
        $path = $vars['path'];

        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$fp) {
            Yii::log('fsockopen error: '.$errstr."--->".$errno, CLogger::LEVEL_ERROR);
            $result['Status'] = 'Fail';
            $result['Code'] = 500;
            return $result;
        }
        $header = "POST " . $path . " HTTP/1.1\r\n";
        $header .= "Host:".$host."\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        $header .= $param_str."\r\n";
        fputs($fp, $header);

        $result = array('Status'=>'OK', 'Content'=>'');
        $buffer = '';
        while (!feof($fp)) {
            $buffer = fgets($fp);
            if (strncmp($buffer, 'HTTP', 4) == 0) {
                $vars = explode(' ', $buffer);
                if ($vars[1] != 200) {
                    $result['Status'] = 'Fail';
                    $result['Code'] = $vars[1];
                }
                while (!feof($fp)) {
                    $buffer = fgets($fp);
                    if ($buffer === "\r\n") {
                        break;
                    }
                }
            }
            $result['Content'] .= trim($buffer);
        }
        return $result;
    }

    public static function jsonRequest($url, $params)
    {
        $param_str = json_encode($params);
        $length = strlen($param_str);
        $vars = parse_url($url);
        $host = $vars['host'];
        $port = empty($vars['port']) ? 80 : $vars['port'];
        $path = $vars['path'];

        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$fp) {
            Yii::log('fsockopen error: '.$errstr."--->".$errno, CLogger::LEVEL_ERROR);
            $result['Status'] = 'Fail';
            $result['Code'] = 500;
            return $result;
        }
        $header = "POST " . $path . " HTTP/1.1\r\n";
        $header .= "Host:".$host."\r\n";
        $header .= "Content-Type: application/json; charset=UTF-8\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        $header .= $param_str."\r\n";
        fputs($fp, $header);

        $result = array('Status'=>'OK', 'Content'=>'');
        $buffer = '';
        while (!feof($fp)) {
            $buffer = fgets($fp);
            if (strncmp($buffer, 'HTTP', 4) == 0) {
                $vars = explode(' ', $buffer);
                if ($vars[1] != 200) {
                    $result['Status'] = 'Fail';
                    $result['Code'] = $vars[1];
                }
                while (!feof($fp)) {
                    $buffer = fgets($fp);
                    if ($buffer === "\r\n") {
                        break;
                    }
                }
            }
            $result['Content'] .= trim($buffer);
        }
        return $result;
    }

    public static function request($url, $timeout = 15, $ua = null, $post = null, $header = null)
    {
        $result['status'] = 'OK';
        $result['url'] = $url;



        $ch = curl_init($url);
        if ($header != null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($ua == null) {
            $ua = self::$defaultUserAgent;
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 2);
        if ($post != null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $cont = curl_exec($ch);
        if (!curl_errno($ch)) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($cont, 0, $header_size);
            $cont = substr($cont, $header_size);
            $info = curl_getinfo($ch);
            $result['url'] = $info['url'];
            $result['content'] = $cont;
            $result['header'] = $header;
            $result['Info'] = json_encode($info);
        } else {
            $result['Status'] = 'FAIL';
            $result['Info'] = curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    public static function soapRequest($url, $body, $timeout = 15)
    {
        $length = strlen($body);
        $vars = parse_url($url);
        $scheme = $vars['scheme'];
        $host = $vars['host'];
        $port = empty($vars['port']) ? (($scheme=='https') ? 443:80) : $vars['port'];
        $path = $vars['path'];

        $fp = @fsockopen((($scheme=='https') ? 'ssl://':'').$host, $port, $errno, $errstr, 15);
        if (!$fp) {
            Yii::log('fsockopen error: '.$errstr."--->".$errno, CLogger::LEVEL_ERROR);
            $result['Status'] = 'Fail';
            $result['Code'] = 500;
            return $result;
        }
        $header = "POST " . $path . " HTTP/1.0\r\n";
        $header .= "Host:".$host."\r\n";
        $header .= "Content-Type: text/xml; charset=UTF-8\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Accept-Encoding: gzip\r\n";
        $header .= "Connection: Close\r\n\r\n";
        $header .= $body."\r\n";
        fputs($fp, $header);

        $result = array('Status'=>'OK', 'Content'=>'');
        $line_number = 1;
        while (!feof($fp)) {
            $buffer = fgets($fp);
            if (strncmp($buffer, 'HTTP', 4) == 0) {
                $vars = explode(' ', $buffer);
                if ($vars[1] != 200) {
                    $result['Status'] = 'Fail';
                    $result['Code'] = $vars[1];
                }
                while (!feof($fp)) {
                    $buffer = fgets($fp);
                    if ($buffer === "\r\n") {
                        break;
                    }
                }
            }else if ($line_number++ % 2 == 0 || strncmp(trim($buffer), '<', 1) == 0) {
                $result['Content'] .= trim($buffer);
            }
        }
        return $result;
    }

    public static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
            return true;
        }
        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap") != false) {
            return true;
        }
        //判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array (
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        //协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public static function requestByProxy($url, $timeout = 30, $ua = null, $post_data = null)
    {
        $result['status'] = 'OK';
        $result['url'] = $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($ua == null) {
            $ua = 'Mozilla/5.0 (iPad; U; CPU OS 4_3_0 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10';
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 2);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, '10.170.209.226');
        curl_setopt($ch, CURLOPT_PROXYPORT, 35768);
        if ($post_data != null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        $cont = curl_exec($ch);
        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            $result['url'] = $info['url'];
            $result['content'] = $cont;
            $result['info'] = json_encode($info);
        } else {
            $result['status'] = 'FAIL';
            $result['info'] = curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    public static function getRealIP(){
        if( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ){
            $client_ip =
                ( !empty($_SERVER['REMOTE_ADDR']) ) ?
                    $_SERVER['REMOTE_ADDR']
                    :
                    ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
                        $_ENV['REMOTE_ADDR']
                        :
                        "unknown" );

            $entries = preg_split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

            reset($entries);
            while (list(, $entry) = each($entries)){
                $entry = trim($entry);
                if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) ){
                    // http://www.faqs.org/rfcs/rfc1918.html
                    $private_ip = array(
                        '/^0\./',
                        '/^127\.0\.0\.1/',
                        '/^192\.168\..*/',
                        '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                        '/^10\..*/');

                    $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                    if ($client_ip != $found_ip){
                        $client_ip = $found_ip;
                        break;
                    }
                }
            }
        } else {
            $client_ip =
                ( !empty($_SERVER['REMOTE_ADDR']) ) ?
                    $_SERVER['REMOTE_ADDR']
                    :
                    ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
                        $_ENV['REMOTE_ADDR']
                        :
                        "unknown" );
        }
        return $client_ip;
    }
}