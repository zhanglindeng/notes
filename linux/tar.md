# tar 解压缩

### 解压
- `tar -xvf filename.tar`  解压 `tar` 包
- `tar -xzvf filename.tar.gz` 解压 `tar.gz` 包
- `tar -xjvf file.tar.bz2` 解压 `tar.bz2` 包

## 压缩
- `tar -cvf filename.tar file1 file2` 打包 `tar`
- `tar -czf filename.tar.gz file1 file2` 打包并使用`gzip`压缩
- `tar -cjf filename.tar.bz2 file1 file2` 打包并用 `bzip2` 压缩
