# Roles Management

## Deploy to a kubernetes cluster

Before you need to create a namespace roles

```
kubectl create ns roles

```
And then deploy to namespace roles
```
kubectl apply -f .

```

## Schedule Script in Crontab for database backup

Copy the file mysql-backup.sh to /backup

Now schedule the script in crontab to run on a daily basis and complete backup on regular basis. Edit crontab on your system with crontab -e command. Add following settings to enable backup at 2 in the morning.

```

 0 2 * * * root /backup/mysql-backup.sh

```

Save your crontab file. After enabling cron, the script will take backup automatically, But keep check backups on a weekly or monthly basis to make sure.



# Authors
  [Ulrich Ntella](https://www.linkedin.com/in/ulrichsoft/). Senior Sofware/DevSecOPs Enginner

# License
This project is released under the MIT license.
