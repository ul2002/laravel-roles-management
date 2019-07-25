# Roles Management

This app allows you to manage user permissions and roles in a database

### Requirement

Kubernetes Cluster <br/>
Docker >= 17.06 CE <br/>
Composer

## Installation

Clone the repository and do theses steps

```
git clone https://github.com/ul2002/laravel-roles-management.git
cd laravel-roles-management
cp .env.example .env
chmod -R 777 storage
composer install
```

## Deploy to a kubernetes cluster 

Before you need to create a namespace roles

```
kubectl create ns roles

```
And then deploy to namespace roles
```
kubectl apply -f .

```

## CI/CD and auto deployent

Using Jenkins Pipeline , you may use jenkinsfile (jenkinsfile is located at the root of the project)


## Schedule Script in Crontab for database backup

Copy the file mysql-backup.sh to /backup

```
cp ./mysql-backup.sh /backup/

```


Now schedule the script in crontab to run on a daily basis and complete backup on regular basis. Edit crontab on your system with crontab -e command. Add following settings to enable backup at 2 in the morning.

```

 0 2 * * * root /backup/mysql-backup.sh

```

Save your crontab file. After enabling cron, the script will take backup automatically, But keep check backups on a weekly or monthly basis to make sure.

## Monitoring Resource Metrics with Prometheus

let’s first install Helm. To do that, head over https://get.helm.sh/helm-v2.14.2-linux-amd64.tar.gz and download the latest version

Next, unpack it:

```

tar -zxvf helm-v2.11.0-linux-amd64.tar.gz
```

Move it to your bin directory:

```

mv linux-amd64/helm /usr/local/bin/helm
```

Initialize helm and install tiller:

```
helm init
```

Create a service account

```
kubectl create serviceaccount --namespace kube-system tiller
```

Bind  the new service account to the cluster-admin role. This will give tiller admin access to the entire cluster

```
kubectl create clusterrolebinding tiller-cluster-rule --clusterrole=cluster-admin --serviceaccount=kube-system:tiller
```

Deploy tiller and add the line serviceAccount: tiller to spec.template.spec:

```
kubectl patch deploy --namespace kube-system tiller-deploy -p '{"spec":{"template":{"spec":{"serviceAccount":"tiller"}}}}'
```

Now we are ready to install the Prometheus operator

```
helm install --name prom-operator stable/prometheus-operator --namespace monitoring
```

Once the Prometheus operator is installed we can forward the Prometheus server pod to a port on our local machine

```
kubectl port-forward -n monitoring  prometheus-prom-operator-prometheus-o-prometheus-0 9090:9090
```

Access the Prometheus dashboard by navigating to http://localhost:9090



# Authors
  [Ulrich Ntella](https://www.linkedin.com/in/ulrichsoft/). Senior Sofware/DevSecOPs Enginner

# License
This project is released under the MIT license.
