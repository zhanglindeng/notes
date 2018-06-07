# git

### 删除最后一个提交（还没有push到服务器）
```
git -c core.quotepath=false -c log.showSignature=false reset --soft <倒数第二次commit的hash>
```

- 打包 `git archive --format zip --output /path/to/file.zip master # 将 master 以zip格式打包到指定文件`
- 新建tag `git tag -a v1.4 -m "version 1.4"`

### 初始化
- 设置用户名和邮箱
```shell
git config --global user.name "name"
git config --global user.email "name@domain.com"
```
- 新建仓库
```shell
git clone http://domain.com/name/name.git
cd name
touch README.md
git add README.md
git commit -m "add README"
git push -u origin master
```
- 从已有文件夹创建
```shell
cd existing_folder
git init
git remote add origin http://domain.com/name/name.git
git add .
git commit
git push -u origin master
```
