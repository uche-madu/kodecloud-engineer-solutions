
## Problem Statement
The Nautilus DevOps team want to deploy a PHP website on Kubernetes cluster. They are going to use Apache as a web server and Mysql for database. The team had already gathered the requirements and now they want to make this website live. Below you can find more details:



1. Create a config map `php-config` for `php.ini` with `variables_order = "EGPCS"` data.


2. Create a deployment named `lamp-wp`.


3. Create two containers under it. First container must be `httpd-php-container` using image `webdevops/php-apache:alpine-3-php7` and second container must be `mysql-container` from image `mysql:5.6`. Mount `php-config` configmap in `httpd container` at `/opt/docker/etc/php/php.ini` location.


4. Create kubernetes generic secrets for mysql related values like myql root password, mysql user, mysql password, mysql host and mysql database. Set any values of your choice.


5. Add some environment variables for both containers:


-- `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD` and `MYSQL_HOST`. Take their values from the secrets you created. Please make sure to use `env` field (do not use `envFrom`) to define the name-value pair of environment variables.


6) Create a node port type service `lamp-service` to expose the web application, nodePort must be `30008`.


7) Create a service for mysql named `mysql-service` and its port must be `3306`.


8) We already have `/tmp/index.php` file on `jump_host` server.


-- Copy this file into httpd container under Apache document root i.e `/app` and replace the dummy values for mysql related variables with the environment variables you have set for mysql related parameters. Please make sure you do not hard code the mysql related details in this file, you must use the environment variables to fetch those values.


-- You must be able to access this `index.php` on node port `30008` at the end, please note that you should see `Connected successfully` message while accessing this page.

## Solution

* Run `kubectl apply -f configmap.yaml -f lamp.yaml -f lamp-service.yaml -f mysql-service.yaml`

* Create Secrets:

    ```bash
    kubectl create secret generic mysql-secrets \
      --from-literal=MYSQL_ROOT_PASSWORD=r00t \
      --from-literal=MYSQL_DATABASE=kodekloud-lamp-db \
      --from-literal=MYSQL_USER=thor \
      --from-literal=MYSQL_PASSWORD=s3cr3tpassw0rd \
      --from-literal=MYSQL_HOST=mysql-service
    ```

* Copy the provided `/tmp/index.php` into the apache server container (replace container name)
`kubectl cp /tmp/index.php lamp-wp-xxxxxxxxxx-xxxxx:/app/index.php -c httpd-php-container`

* Run the next 2 commands to `exec` into the server container and edit the `/app/index.php`, replacing the dummy values for mysql related variables with the environment variables you have set for mysql related parameters as in the `index.php` file provided in this repo.

`kubectl exec -it pods/lamp-wp-xxxxxxxxxx-xxxxx -c httpd-php-container -- /bin/bash`

`vi /app/index.php`
