The Nautilus DevOps team want to deploy a static website on Kubernetes cluster. They are going to use Nginx, phpfpm and MySQL for the database. The team had already gathered the requirements and now they want to make this website live. Below you can find more details:



1. Create some secrets for MySQL.

    - Create a secret named mysql-root-pass wih key/value pairs as below:
    
        ```bash
        name: password
        value: R00t
        ```


    - Create a secret named mysql-user-pass with key/value pairs as below:
        
        ```bash
        name: username
        value: kodekloud_aim
        ```

        ```bash
        name: password
        value: LQfKeWWxWD
        ```



    - Create a secret named mysql-db-url with key/value pairs as below:

        ```bash
        name: database
        value: kodekloud_db5
        ```



    - Create a secret named mysql-host with key/value pairs as below:

        ```bash
        name: host
        value: mysql-service
        ```



2. Create a config map `php-config` for `php.ini` with `variables_order = "EGPCS"` data.

3. Create a deployment named `lemp-wp`.


4. Create two containers under it. First container must be `nginx-php-container` using image `webdevops/php-nginx:alpine-3-php7` and second container must be `mysql-container` from image `mysql:5.6`. Mount `php-config` configmap in nginx container at `/opt/docker/etc/php/php.ini` location.


5. Add some environment variables for both containers:


    - `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD` and `MYSQL_HOST`. Take their values from the secrets you created. Please make sure to use env field (do not use envFrom) to define the name-value pair of environment variables.

6. Create a node port type service `lemp-service` to expose the web application, nodePort must be `30008`.


7. Create a service for mysql named `mysql-service` and its port must be `3306`.


8. We already have a `/tmp/index.php` file on `jump_host` server.


    - Copy this file into the `nginx` container under document root i.e `/app` and replace the dummy values for mysql related variables with the environment variables you have set for mysql related parameters. Please make sure you do not hard code the mysql related details in this file, you must use the environment variables to fetch those values.


    - Once done, you must be able to access this website using `Website` button on the top bar, please note that you should see `Connected successfully` message while accessing this page.


`Note:` The `kubectl` on `jump_host` has been configured to work with the kubernetes cluster.

## Solution
* Create the secrets:
    ```bash
    kubectl create secret generic mysql-root-pass \
    --from-literal=password=R00t

    kubectl create secret generic mysql-user-pass \
    --from-literal=username=kodekloud_tim \
    --from-literal=password=Rc5C9EyvbU

    kubectl create secret generic mysql-db-url \
    --from-literal=database=kodekloud_db7

    kubectl create secret generic mysql-host \
    --from-literal=host=mysql-service

    ```

* Create the configmap as in `mysql-cm.yaml` and run `kubectl apply -f mysql-cm.yaml`
* Create the `lemp-wp` deployment as in `lemp-wp-deployment.yaml` and run `kubectl apply -f lemp-wp-deployment.yaml`

* Copy the provided file from the terminal to the ngnix container: `kubectl cp /tmp/index.php lemp-wp-6665866b74-s8c79:/app/index.php -c nginx-php-container`

* Run the next 2 commands to `exec` into the server container and edit the `/app/index.php`, replacing the dummy values for mysql related variables with the environment variables you have set for mysql related parameters as in the `index.php` file provided in this repo:

    `kubectl exec -it pods/lamp-wp-xxxxxxxxxx-xxxxx -c httpd-php-container -- /bin/bash`

    `vi /app/index.php`

* All done! Click the website link to verify that it displays **Connected successfully**


