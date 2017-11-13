### 配置私钥
- 使用命令ssh-keygen -t rsa生成密钥，会生成一个私钥和一个公钥，在提示输入passphrase时如果不输入，直接回车，那么以后你登录服务器就不会验证密码，否则会要求你输入passphrase，默认会将私钥放在/root/.ssh/id_rsa公钥放在
/root/.ssh/id_rsa.pub。
- 将公钥拷贝到远程服务器上的/root/.ssh/authorized_keys文件
(scp /root/.ssh/id_rsa.pub server:/root/.ssh/authorized_keys)，注意，文件名一定要叫authorized_keys。
- 客户端上保留私钥，公钥留不留都可以。也就是服务器上要有公钥，客户端上要有私钥。这样就可以实现无密码验证登录了。

### 如果想要获得最大化的安全性，禁止口令登录，可以修改www.example.com上/etc/ssh/sshd_conf中的
PasswordAuthentication yes 改为
PasswordAuthentication no
也即只能使用密匙认证的openssh，禁止使用口令认证。
