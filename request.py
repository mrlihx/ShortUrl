import requests

# 生成短网址
data = {
    "type": "toShort",
    "kind": "8zo.cn",  # 域
    "url": "https://www.baidu.com/",
    "endtime": "-1",  # 短网址时间 单位:分钟  -1为永久
    "key": "qq199466" # key
}
ret = requests.post("http://aaa.cn/api.php", data=data)
print(ret.text)


# 还原
data = {
    "type": "toLong",
    "url": "http://aaa.cn/60f90d"
}
ret = requests.post("http://aaa.cn/api.php", data=data)
print(ret.text)