简单的PHP生成短网址

### Nginx伪静态

```
error_page 404 /404.html;
error_page 403 /404.html;
location ^~ /inc/ {
  return 404;
}
location / {
  try_files $uri $uri/ =404;
  rewrite "/(\d+|\w+)$" /index.php?id=$1;
}
```