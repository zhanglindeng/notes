### install python pip
```
sudo apt-get install python-pip
```

### install shadowsocks
```
pip install shadowsocks
```

### shadowsocks.json
```json
{
  "server":"0.0.0.0",
  "server_port":8388,
  "password":"password",
  "timeout":300,
  "method":"aes-256-cfb"
}
```

### run
```
ssserver -c shadowsocks.json
```
