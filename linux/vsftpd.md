# vsftpd

## CentOS 7

### 安装与运行
```
# 安装
yum install vsftpd

# 开机启动
systemctl enable vsftpd

# 启动
systemctl start vsftpd

# 重启
systemctl restart vsftpd

# 查看状态
systemctl status vsftpd
```

### 配置
`vim /etc/vsftpd/vsftpd.conf`

内容如下：
```
# 禁用匿名访问
anonymous_enable=NO

# 允许本地账户进行ftp用户登录验证
local_enable=YES

# 使用本地时间
use_localtime=YES

# 限定用户在其主目录下
chroot_local_user=YES
# 是否启动限制用户的名单 YES为启用  NO禁用(包括注释掉也为禁用)
#chroot_list_enable=YES
# 是否限制在主目录下的用户名单，参考：https://blog.csdn.net/bluishglc/article/details/42398811
#chroot_list_file=/etc/vsftpd/chroot_list
# 如果启用了限定用户在其主目录下需要添加这个配置
allow_writeable_chroot=YES

# 允许写入权限，包括修改，删除
write_enable=YES

# 设置本地用户默认文件掩码022
local_umask=022

# 是否显示目录说明文件, 默认是YES 但需要手工创建.message文件,
# 这个.message，只有用命令登陆或者用工具，才可以看见,他不是一个弹出对话框，
# 而是一段字符,如在pub下建立一个.message,那么在客户端进入pub目录时就会显示.message文档中的内容
dirmessage_enable=YES

# 启用上传和下载的日志功能，默认开启
xferlog_enable=YES

# 确保ftp-datad 数据传送使用20端口
connect_from_port_20=YES

# 如果启用该选项，传输日志文件将以标准 xferlog 的格式书写，该格式的日志文件默认为 /var/log/xferlog，
# 也可以通过 xferlog_file 选项对其进行设定。默认值为NO
xferlog_std_format=YES

# ftp监听端口 默认没有这一行
listen_port=21

# 使用standalone启动vsftpd，而不是super daemon(xinetd)控制它 (vsftpd推荐使用standalone方式)
listen=YES

#listen_ipv6=YES

# PAM所使用的名称.同userlist_*一样限制用户登陆，不同的是userlist_*在进行密码验证之前拒绝用户登陆，
# pam是在密码验证之后拒绝登陆.(提示密码错误) 用户列表默认存放在/etc/ftpusers中，一行一个. 
# (可通过/etc/pam.d/vsftpd重定向用户列表存放文件)
pam_service_name=vsftpd

# 为yes时， /etc/vsftpd/user__list文件中的用户将不能访问vsftpd服务器
userlist_enable=YES

tcp_wrappers=YES

# 如果使用者600秒没有动作，则强制离线，也就是指令超时时间
idle_session_timeout=600

# 如果 client与 Server 间的数据传送在 180 秒内都无法传送成功，那 Client的联机就会被我们的 vsftpd 强制剔除！
# data_connection_timeout=180

```

### 注意问题
> 在 `CentOS Linux release 7.6.1810 (Core)` 上出现的

- 登录报 `530 Login incorrect` 错误，需要把 `/etc/pam.d/vsftpd` 中的 `pam_shells.so` 改为 `pam_nologin.so`


### 用户配置（本地用户模式）

> 其实就是添加 `Linux` 系统用户，只不过设置了不能通过 `SSH` 登录

```
# 如创建用户名为：foobar 的用户，-d 指定用户家目录，就是用户登录ftp后可以操作的目录；-s 指定shell为nologin，这样就可以禁用 SSH 登录
useradd -d /data/ftp/foobar -s /sbin/nologin foobar

# 设置 foobar 的登录密码
passwd foobar
# （根据提示输入即可，注意密码的复杂度）

# 重启 vsftpd
systemctl restart vsftpd

# 然后就可以使用ftp客户端登录使用了

```

### 用户配置（虚拟用户模式）
**暂缺，还不懂**
