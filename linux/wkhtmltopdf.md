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

