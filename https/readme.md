# HTTPS

### CentOS 執行 sudo certbot --nginx 出現：ImportError: No module named 'requests.packages.urllib3' 錯誤解決辦法
```
pip install requests urllib3 pyOpenSSL --force --upgrade
pip install --upgrade --force-reinstall 'requests==2.6.0'
```

### 免費 HTTPS 證書
[https://letsencrypt.org/](https://letsencrypt.org/)

### ssh tunnel nginx
- `ssh -C -f -N -g -R 6001:localhost:8001 username@ip`
- `ssh -ND 1234 username@ip`
