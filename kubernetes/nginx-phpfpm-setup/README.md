
## Problem Statement
The Nautilus Application Development team is planning to deploy one of the php-based applications on Kubernetes cluster. As per the recent discussion with DevOps team, they have decided to use nginx and phpfpm. Additionally, they also shared some custom configuration requirements. Below you can find more details. Please complete this task as per requirements mentioned below:


1. Create a service to expose this app, the service type must be `NodePort`, nodePort should be `30012`.


2. Create a config map named `nginx-config` for `nginx.conf` as we want to add some custom settings in `nginx.conf`.


  a) Change the default port `80` to `8093` in `nginx.conf`.


  b) Change the default document root `/usr/share/nginx` to `/var/www/html` in `nginx.conf`.


  c) Update the directory index to index `index.html` `index.htm` `index.php` in `nginx.conf`.


3. Create a pod named `nginx-phpfpm`.


  a) Create a shared volume named `shared-files` that will be used by both containers (nginx and phpfpm) also it should be a `emptyDir` volume.


  b) Map the ConfigMap we declared above as a volume for nginx container. Name the volume as `nginx-config-volume`, mount path should be `/etc/nginx/nginx.conf` and subPath should be `nginx.conf`


  c) Nginx container should be named as `nginx-container` and it should use `nginx:latest` image. PhpFPM container should be named as `php-fpm-container` and it should use `php:8.2-fpm-alpine` image.


  d) The shared volume `shared-files` should be mounted at `/var/www/html` location in both containers. Copy `/opt/index.php` from `jump host` to the nginx document root inside the `nginx` container, once done you can access the app using `App` button on the top bar.


Before clicking on `finish` button always make sure to check if all pods are in `running` state.


`You can use any labels as per your choice`.


`Note:` The `kubectl` utility on `jump_host` has been configured to work with the kubernetes cluster.

## Solution
* Apply the provided `nginx-phpfpm.yaml` file:
  ```
  kubectl apply -f nginx-phpfpm.yaml
  ```

* Copy `/opt/index.php` from jump host to the nginx document root inside the nginx container:
  ```
  kubectl cp /opt/index.php nginx-phpfpm:/var/www/html/index.php -c nginx-container
  ```

* Verify that the pods are in a running state:
   ```
   kubectl get pods
   ```
   The output should look like:

     ```bash
     NAME           READY   STATUS    RESTARTS   AGE
     nginx-phpfpm   2/2     Running   0          13m
     ```