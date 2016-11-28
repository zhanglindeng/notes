### crontab
- `crontab -e #编辑`
- `crontab -l #列出`
- `crontab -r #删除`

```shell
# m h dom mon dow command
# m:0-59
# h:0-23
# dom:1-31
# mon:1-12
# dow:0-6
# dom day of month
# dow day of week

# 每分钟执行
* * * * * date >> /root/date.txt

# 每天凌晨两点执行
0 2 * * * date >> /root/date.txt
```
