# AsbraSMS
Simple web frontend for smstools gateway with API
smsd folder must be a link to /var/spool/sms default smstools folder. Could be done with fstab:

```bash
# cat /etc/fstab
/var/spool/sms   /var/www/html/smsd        none    bind    0       0
```

Example of API usage (%2B is UNICODE for the plus sign '+', use it to prefix the mobile number with a country code):
```
http://sms.your.domain/api.php?phone=%2B46720437607&message=test+from+terminal
```
