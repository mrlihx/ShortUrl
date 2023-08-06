<?php

//还原短网址
function restoreUrl($shortUrl)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $shortUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0');
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_NOBODY, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    $data = curl_exec($curl);
    $curlInfo = curl_getinfo($curl);
    curl_close($curl);
    if ($curlInfo['http_code'] == 301 || $curlInfo['http_code'] == 302) {
        return $curlInfo['redirect_url'];
    }
    return '';
}
//get请求
function get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
//返回结果
function returnResult($url, $msg="获取失败")
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $res_data['url'] = $url;
        $res_data['status'] = 1;
    } else {
        $res_data['status'] = 0;
        $res_data['msg'] = $msg;
    }
    exit(json_encode($res_data));
}

//post
function curl_post($url, $post)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// 获取配置
function get_config($key)
{
    global $config;
    return $config[$key];
}


// 获取用户 IP
function get_ip()
{
    $ip = '0.0.0.0';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else if (!empty($_SERVER['HTTP_VIA'])) {
        $ip = $_SERVER['HTTP_VIA '];
    }
    return $ip;
}

// 获取用户 UserAgent
function get_ua()
{
    $ua = 'N/A';
    if (!empty($_SERVER['HTTP_USER_AGENT'])) $ua = $_SERVER['HTTP_USER_AGENT'];
    return $ua;
}

// 获取程序所在路径
function get_uri()
{
    global $config;
    // 获取传输协议
    $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    // 获取域名
    $url .= $_SERVER['HTTP_HOST'];
    // 获取程序所在路径
    $url .= $config['path'];
    if (substr($url, strlen($url) - 1) != '/') $url .= '/';

    return $url;
}

function is_https()
{
    if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
        return true;
    } elseif (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
        return true;
    } elseif (isset($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        return true;
    } elseif (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') {
        return true;
    } elseif (isset($_SERVER['HTTP_EWS_CUSTOME_SCHEME']) && $_SERVER['HTTP_EWS_CUSTOME_SCHEME'] == 'https') {
        return true;
    }
    return false;
}


// 时间转换
function getTimeHour($timediff = '', $is_hour = 1, $is_minutes = 1)
{
    $timediff = $timediff * 60;
    if (empty($timediff) || $timediff <= 60) return '';
    $day = floor($timediff / (3600 * 24));
    $day = $day > 0 ? $day . '天' : '';
    $hour = floor(($timediff % (3600 * 24)) / 3600);
    $hour = $hour > 0 ? $hour . '小时' : '';
    if ($is_hour && $is_minutes) {
        $minutes = floor((($timediff % (3600 * 24)) % 3600) / 60);
        $minutes = $minutes > 0 ? $minutes . '分钟' : '';
        return $day . $hour . $minutes;
    }
    if ($hour) return $day . $hour;
    return $day;
}


// 生成短网址
function create_uri($url, $domain, $endtime = 0)
{
    global $config;
    $url_c = new url();
    $opt = [];
    $opt['success'] = false;
    $opt['msg'] = "success";
    $opt['url'] = $url;
    $opt['endtime'] = 0;

    // 添加 HTTP 协议前缀
    if (!strstr($url, 'http://') && !strstr($url, 'https:')) $url = 'http://' . $url;
    // 检测网址格式是否正确
    $is_link = preg_match('(http(|s)://([\w-]+\.)+[\w-]+(/)?)', $url);

    // 判断条件
    if ($url != '' && !strstr($url, $_SERVER['HTTP_HOST']) && $is_link) {
        $opt['success'] = true;
        $opt['msg'] = "success";
        $data = $url_c->set_url($url, $domain, $endtime);
        $opt['url'] = $data;

    } else if (strstr($url, $_SERVER['HTTP_HOST'])) {
        $opt['msg'] = '链接已经是短地址了。';
    } else if (!$is_link) {
        $opt['msg'] = '请输入正确格式的网址。';
    }

    return $opt;
}


?>