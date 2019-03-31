### 安装 maven
去 http://maven.apache.org/ 下载bin文件apache-maven-3.6.0-bin.tar.gz
```
$ tar -zxvf apache-maven-3.6.0-bin.tar.gz
$ mv apache-maven-3.6.0 /usr/loca/maven
```
设置M2_HOME
```
$ sudo vim /etc/profile
```
添加
```
export M2_HOME=/usr/local/maven
export PATH=$PATH:$M2_HOME/bin
```
更新生效
```
$ source /etc/profile
```
验证
```
$ mvn -v
```

### CentOS 设置时区
```
sudo timedatectl set-timezone Asia/Shanghai
```
or
```
cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
```

### CentOS 安装 JDK
去oracle官网下载jdk
```
$ sudo mkdir /usr/local/java
$ tar -xzvf jdk-8u191-linux-x64.tar.gz
$ mv jdk1.8.0_191 /usr/local/java
```
设置环境变量
```
$ sudo vim /etc/profile
```
添加
```
export JAVA_HOME=/usr/local/java/jdk1.8.0_191
export JRE_HOME=$JAVA_HOME/jre
export CLASSPATH=.:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar:$JRE_HOME/lib
export PATH=$PATH:$JAVA_HOME/bin
```
更新生效
```
source /etc/profile
```
检查是否设置成功
```
java -version
```

[JVM诊断调优](http://www.rowkey.me/blog/2017/03/23/java-profile-cheatsheet/)
