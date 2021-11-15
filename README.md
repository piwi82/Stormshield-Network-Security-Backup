# Stormshield-Network-Security-Backup

Automate the configuratino backup of [Stormshield Network Security (SNS)](https://www.stormshield.com/products-services/products/network-security/product-range-sns/) devices/appliances.

This PHP script can handle your [SNS backups](https://documentation.stormshield.eu/SNS/v3/en/Content/User_Configuration_Manual_SNS_v3.7_LTSB/Maintenance/Backup_tab.htm) to your local/outsourced HTTP/HTTPS server.

## 1. Basic configuration of the SNS device/appliance

*SNS Configuration* > *System* > *Maintenance* > *Backup* :
* Backup server : `sns-backup.domain.tld`

*SNS Configuration* > *System* > *Maintenance* > *Backup* > *Advanced configuration* : 
* Name of the backup file : `backupFile`
* Server port : `http` (tcp/80)
* Communication protocol : `HTTP`
* Server certificate : *Not used*
* Access path : `/path/backup.php`
* Method of sending : `POST`
* User name : *Not used*
* Password : *Not used*
* POST - control name : `controlName`
* Backup frequency : `Every day`
* Password of the backup file : *Not used*

The general format of the URL called by SNS is :
```
[{methodOfSending}] {communicationProtocol}://{backupServer}:{serverPort}/{accessPath}
```
Using the previous configuration data :
```
[POST] https://sns-backup.domain.tld:80/path/backup.php
```

## 2. Configure the backup.php script

`$source` is a list of IP addresses allowed to access the script (i.e. your SNS devices/appliances IP addresses) :
```
$source = [
	'192.0.2.1',
	'192.0.2.2'
];
```

`$name` must be the same as in SNS *SNS Configuration* > *System* > *Maintenance* > *Backup* > *Advanced configuration* > *POST - control name* :
```
$name = 'controlName';
```
