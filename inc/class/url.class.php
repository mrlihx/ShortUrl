<?php

class url
{

    function __construct()
    {
        global $db_c;
        $this->db = $db_c;
    }

    // 生成短地址
    public function set_url($url, $domain, $endtime)
    {
        global $config;
        $size = $config['length'];

        if ($endtime != -1) $endtime = time() + ($endtime * 60);

        // $id = $this->get_id($url, $endtime);
        // if(!$id) {
            $id = $this->create_id($url, $size);
            $ip = get_ip();
            $ua = get_ua();
            $this->db->insert('urls', 'id, url, ip, ua, endtime', "'$id', '$url', '$ip', '$ua', '$endtime'");
        // }
        $s_url = (is_https() ? 'https://' : 'http://') . $domain . "/" . $id;
        return $s_url;
    }

    // 生成地址 ID
    public function create_id($url, $size = 4)
    {
        $md5 = md5($url);
        // 随机抽取 MD5 中的字符作为 ID
        $id = '';
        for ($i = 0; $i < $size; $i++) {
            $rand_id = rand(0, strlen($md5) - 1);
            $id .= $md5[$rand_id];
        }
        // ID 检测
        if ($this->has_id($id)) {
            return $this->create_id($url, $size);
        } else {
            return $id;
        }
    }

    // 查询 ID 号
    public function get_id($url, $endtime)
    {
        $result = $this->db->query('urls', "WHERE url = '$url'");
        if (isset($result[0]['endtime']) and $result[0]['endtime'] < time() and $result[0]['endtime'] != -1) {
            //   $this->db->delete('urls', "WHERE url = '$url'");
            global $config;
            $size = $config['length'];
            $id = $this->create_id($url, $size);
            $this->db->update('urls', "`id` = '$id', `endtime` = '$endtime'", "`url` = '$url'");
            return $id;
        }
        (count($result) > 0) ? $opt = $result[0]['id'] : $opt = false;
        return $opt;
    }

    // 查询目标地址
    public function get_url($id)
    {
        $result = $this->db->query('urls', "WHERE id = '$id'");
        $this->clean_endtimeurls();  // 删除过期的短地址
        if ($result[0]['endtime'] < time() and $result[0]['endtime'] != -1) {
            $this->db->delete('urls', "WHERE id = '$id'");
            return false;
        }
        (count($result) > 0) ? $opt = $result[0]['url'] : $opt = false;
        return $opt;
    }

    // 检测 ID 是否已经存在
    public function has_id($id)
    {
        $result = $this->db->query('urls', "WHERE id = '$id'");
        (count($result) > 0) ? $opt = true : $opt = false;
        return $opt;
    }

    // 清空短地址
    public function clean_urls()
    {
        $del = $this->db->delete('urls');
        if ($del) return true;
        return false;
    }

    // 删除过期的短地址
    public function clean_endtimeurls()
    {
        $time = time();
        $del = $this->db->delete('urls', "WHERE `endtime` < '$time' and `endtime` != -1");
        if ($del) return true;
        return false;
    }


}

?>