# Ubuntu 18.04 LTS 添加用户
- 有root权限
- 使用ssh key登录
- 禁止密码登录
- 以具有root权限的用户登录

### 切换到root用户
```
$ sudo su -
```

### 添加用户
```
# adduser username
```

### 设置密码
```
# passwd username 
```

### 添加到sudo用户组
```
# usermod -aG sudo username
```

### 修改sshd配置
```
# vim /etc/ssh/sshd_config
```
设置PubkeyAuthentication为yes
```
PubkeyAuthentication yes
```
设置PasswordAuthentication为no
```
PasswordAuthentication no
```

### 重启sshd
```
# systemctl restart sshd
```

### 创建authorized_keys文件
切换到username用户
```
# su - username
```
创建.ssh目录并设置权限是0700
```
$ mkdir .ssh
$ chmod 0700 .ssh
```
创建authorized_keys文件并设置权限是0600
```
$ cd .ssh
$ touch authorized_keys
$ chmod 0600 authorized_keys
```

### 在自己电脑上创建ssh key
```
$ ssh-keygen -b 4096
```
一路回车在当前目录下生成id_rsa和id_rsa.pub文件

### 复制id_rsa.pub到创建authorized_keys文件
> 省略

### 登录
```
ssh -i id_rsa username@server_ip
```

### 执行root权限的命令
```
# sudo root_cmd
```

### 切换到root用户
```
$ sudo su -
```
