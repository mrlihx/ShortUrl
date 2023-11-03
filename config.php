<?php
global $config;
$config = [];

// 程序安装路径
$config['path'] = '/';
// ID 长度
$config['length'] = 4;
// 网站标题
$config['title'] = 'Enzo短网址';
// 网站副标题
$config['subtitle'] = '仅提供免费的网址缩短服务';
// 网站关键词
$config['keywords'] = '网址缩短,短网址生成,新浪短链接,腾讯短链接,缩我短链接';
// 网站简介
$config['description'] = '免费的短网址生成与还原';
// IPC备案号
$config['ipc'] = '辽ICP备88888888号';


// 默认生成短链接时效  单位/分钟  1天=1440分钟, -1为永久
$config['urlendtime'] = 1440;
// API key
$config['key'] = "key123";
// 是否显示主页
$config['showhome'] = true;
// 域名
$config['domain'] = array(
    [
        "url" => "aaa.cn",
        'state' => true
    ],
    [
        "url" => "bbb.cn",
        'state' => false
    ]
);

