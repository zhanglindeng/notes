### CentOS 7 时区设置

[参考网页](http://mathslinux.org/?p=637)


查看系统时间
```
$ timedatectl
```

列出所有时区
```
$ timedatectl list-timezones
```

将硬件时钟调整为与本地时钟一致, 0 为设置为 UTC 时间
```
$ timedatectl set-local-rtc 1
```

设置系统时区为上海
```
$ sudo timedatectl set-timezone Asia/Shanghai
```
