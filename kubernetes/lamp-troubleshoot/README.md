## Problem Statement
One of the DevOps team member was trying to install a WordPress website on a LAMP stack which is essentially deployed on Kubernetes cluster. It was working well and we could see the installation page a few hours ago. However something is messed up with the stack now due to a website went down. Please look into the issue and fix it:



FYI, deployment name is `lamp-wp` and its using a service named `lamp-service`. The Apache is using http default `port` and `nodeport` is `30008`. From the application logs it has been identified that application is facing some issues while connecting to the database in addition to other issues. Additionally, there are some environment variables associated with the pods like `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_HOST`.


Also do not try to delete/modify any other existing components like deployment name, service name, types, labels etc.


`Note:` The `kubectl` utility on `jump_host` has been configured to work with the kubernetes cluster.

## Solution
* Running `kubectl get deployments.apps lamp-wp -o yaml` shows that the environment variables (MYSQL_*) are supposed to have been set from a Secret resource
* Running `kubectl get svc lamp-service` shows that the service is using port `8080` instead of `80`. Therefore, run `kubectl edit service lamp-service` and change the `port` and `targetPort` to `80`.
* At this point, attempting to connect to the app no longer shows a `502` error: it now shows `Unable to Connect to ''`
* Check the logs of both containers in the pod (replace the pod name)

* Run `k logs lamp-wp-56c7c454fc-rc9f5 -c mysql-container`: Everything seems fine
* Run `k logs lamp-wp-56c7c454fc-rc9f5 -c httpd-php-container`: From the logs provided, there are a few key points to note:

i. Undefined Indexes in PHP:
`[29-Aug-2023 08:46:21] WARNING: [pool www] child 223 said into stderr: "NOTICE: PHP message: PHP Notice:  Undefined index: MYSQL_PASSWORDS in /app/index.php on line 4"
[29-Aug-2023 08:46:21] WARNING: [pool www] child 223 said into stderr: "NOTICE: PHP message: PHP Notice:  Undefined index: HOST_MYQSL in /app/index.php on line 5"`
This indicates that the PHP code in /app/index.php is trying to access environment variables `MYSQL_PASSWORDS` and `HOST_MYQSL`, but they are not set. It's likely there's a typo here since the environment variables you mentioned earlier are `MYSQL_PASSWORD` and `MYSQL_HOST`.

ii. MySQL Connection Error:
`[29-Aug-2023 08:46:21] WARNING: [pool www] child 223 said into stderr: "NOTICE: PHP message: PHP Warning:  mysqli_connect(): (HY000/2005): Unknown MySQL server host 'mysql' (-2) in /app/index.php on line 8"`
This indicates that the PHP application is trying to connect to a MySQL server with the hostname mysql, but it's unable to resolve this hostname. This suggests that either the MySQL service is not named mysql in the Kubernetes cluster, or there's a DNS resolution issue within the cluster.

iii. Environment Variables in Deployment:
Ensure that the environment variables in the deployment configuration match the ones expected by the PHP application. From the provided deployment configuration, the environment variables are correctly named as `MYSQL_PASSWORD` and `MYSQL_HOST`. So, the issue might be in the PHP code where it's trying to access `MYSQL_PASSWORDS` and `HOST_MYQSL`.

### Fix PHP Code:

Update the PHP code in `/app/index.php` to use the correct environment variable names: MYSQL_PASSWORD and MYSQL_HOST.

i. `k exec -it lamp-wp-56c7c454fc-rc9f5 -c httpd-php-container -- /bin/bash`
ii. `vi /app/index.php`

iii. Set the variables properly:
```php
$dbpass = $_ENV['MYSQL_PASSWORD'];
$dbhost = $_ENV['MYQSL_HOST'];
```
iv. Exit vi with `:wq`

That's it! Reload the app page. It should now say: ***Connected successfully***
