### 防止 SSH 被暴力破解
```
denyhosts
```

### Ubuntu 开启 BBR
[参考网址](https://www.cnblogs.com/binarization/p/6421877.html)

### 根据进程名杀死进程
```
pkill -f "process_name_pattern"
```

### 查找杀死进程
```
pgrep <name> | xargs kill -s 9
```

### 结束进程
- `kill -s 9 <pid>`

### Linux 强制踢人
- `pkill -kill -t pts/1`

### 計算文件md5值
- `md5sum <file>`

### 查看linux版本
- `lsb_release -a`
- `uname -r`
- `uname -a`
- `cat /proc/version`

### ubuntu 修改时区
```
dpkg-reconfigure tzdata
```
