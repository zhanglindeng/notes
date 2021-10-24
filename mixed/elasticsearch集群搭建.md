# Elasticsearch 集群搭建

> 版本：7.9.3

## 节点 01

> IP：192.168.1.14

**elasticsearch.yml**

```yaml
# 集群名称，所有节点要一样
cluster.name: es-cluster

# 节点名称，不能重复
node.name: node01

# 是不是有资格主节点
node.master: true

# 是否存储数据
node.data: true

# 最大集群节点数，因为3个集群，所以配置3
node.max_local_storage_nodes: 3

# 网关地址
network.host: 0.0.0.0

# 端口
http.port: 9200

# 内部节点之间沟通端口
transport.tcp.port: 9300

# es7.x 之后新增的配置，写入候选主节点的设备地址，在开启服务后可以被选为主节点
discovery.seed_hosts: ["192.168.1.14:9300", "192.168.1.15:9300", "192.168.1.16:9300"]

# es7.x 之后新增的配置，初始化一个新的集群时需要此配置来选举 master
cluster.initial_master_nodes: ["node01", "node02", "node03"]

```



## 节点 02

>IP：192.168.1.15

**elasticsearch.yml**

```yaml
# 集群名称，所有节点要一样
cluster.name: es-cluster

# 节点名称，不能重复
node.name: node02

# 是不是有资格主节点
node.master: true

# 是否存储数据
node.data: true

# 最大集群节点数，因为3个集群，所以配置3
node.max_local_storage_nodes: 3

# 网关地址
network.host: 0.0.0.0

# 端口
http.port: 9200

# 内部节点之间沟通端口
transport.tcp.port: 9300

# es7.x 之后新增的配置，写入候选主节点的设备地址，在开启服务后可以被选为主节点
discovery.seed_hosts: ["192.168.1.14:9300", "192.168.1.15:9300", "192.168.1.16:9300"]

# es7.x 之后新增的配置，初始化一个新的集群时需要此配置来选举 master
cluster.initial_master_nodes: ["node01", "node02", "node03"]

```



## 节点 03

> IP：192.168.1.16

**elasticsearch.yml**

```yaml
# 集群名称，所有节点要一样
cluster.name: es-cluster

# 节点名称，不能重复
node.name: node03

# 是不是有资格主节点
node.master: true

# 是否存储数据
node.data: true

# 最大集群节点数，因为3个集群，所以配置3
node.max_local_storage_nodes: 3

# 网关地址
network.host: 0.0.0.0

# 端口
http.port: 9200

# 内部节点之间沟通端口
transport.tcp.port: 9300

# es7.x 之后新增的配置，写入候选主节点的设备地址，在开启服务后可以被选为主节点
discovery.seed_hosts: ["192.168.1.14:9300", "192.168.1.15:9300", "192.168.1.16:9300"]

# es7.x 之后新增的配置，初始化一个新的集群时需要此配置来选举 master
cluster.initial_master_nodes: ["node01", "node02", "node03"]

```



**检查集群是否搭建成功**

```
http://192.168.1.14:9200/_cat/health?v
```



## 注意事项

- 基本上除了 `node.name` 不同外，其他的配置都一样
- 注意 yaml 文件格式
- 端口根据情况修改

## 使用 nssm 注册 Windows 服务

- `nssm install`
- `[tab] Application` 
  - `path` 选择 `elasticsearch.bat`
  - `Service name`  `Windows`服务名称，如 `elasticsearch7`
- `[tab] Details`
  - `display name` `Windows` 服务吗显示名称，可选
  - `description` `Windows` 服务描述信息，可选
  - `startup type` 启动类型：`Automatic`-自动，`Manual`-手动，`Disabled`-禁用，`Automatic(Delayed Start)`-延迟启动
- `[tab] environment`
  - `Environment variables` `JAVA_HOME` 设置为 `ES` 自带的 `jdk` 目录
- 点击 `Install service`

