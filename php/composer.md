# composer

### 阿里云 Composer 全量镜像

[https://mirrors.aliyun.com/composer/index.html](https://mirrors.aliyun.com/composer/index.html)

**全局配置（推荐）**

所有项目都会使用该镜像地址：
```
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

**取消配置：**
```
composer config -g --unset repos.packagist
```

**项目配置**

仅修改当前工程配置，仅当前工程可使用该镜像地址：
```
composer config repo.packagist composer https://mirrors.aliyun.com/composer/
```

**取消配置：**
```
composer config --unset repos.packagist
```

**调试**

composer 命令增加 -vvv 可输出详细的信息，命令如下：
```
composer -vvv require alibabacloud/sdk
```

### 自定义 package
```json
"require": {
    "your-package-name": "dev-master"
},
"repositories": [
    {
        "type": "vcs",
        "url": "<git repository url>"
    }
]
```
