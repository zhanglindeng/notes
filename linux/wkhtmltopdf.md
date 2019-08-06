# CentOS 7 安裝 wkhtmltopdf

### 官網下載 RPM 包
```
wget https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox-0.12.5-1.centos7.x86_64.rpm
```

### 依賴安裝
```
yum install -y libpng
yum install -y libjpeg
yum install -y openssl
yum install -y icu
yum install -y libX11
yum install -y libXext
yum install -y libXrender
yum install -y xorg-x11-fonts-Type1
yum install -y xorg-x11-fonts-75dpi
```

### 安裝
```
rpm -Uvh wkhtmltox-0.12.5-1.centos7.x86_64.rpm
```

### 中文字體亂碼
從 Windows 系統字體中複製字體文件到 `/usr/share/fonts` 目錄下，如：

- simsun.ttc 宋體
- msyh.ttf 微軟雅黑

# Ubuntu 16.04 安装 wkhtmltopdf 经历


### step 1
[https://gist.github.com/brunogaspar/bd89079245923c04be6b0f92af431c10](https://gist.github.com/brunogaspar/bd89079245923c04be6b0f92af431c10)
```
sudo apt-get install xvfb libfontconfig wkhtmltopdf
```
无法直接运行
```
wkhtmltopdf https://www.google.com google.pdf
```
出现错误
```
QXcbConnection: Could not connect to display
Aborted
```



### step 2
参考[网页](https://my.oschina.net/huqiji/blog/804899) 下载官方编译好的包，可以正常运行，并解决中文乱码问题

### step 3
关于 `wkhtmltoimage` 的使用参考知乎的[网页](https://www.zhihu.com/question/21455769)

