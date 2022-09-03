# AsbraSMS
Simple web frontend for smstools gateway with API
smsd folder must be a link to /var/spool/sms default smstools folder. Could be done with fstab:

```bash
# cat /etc/fstab
/var/spool/sms   /var/www/html/smsd        none    bind    0       0
```
