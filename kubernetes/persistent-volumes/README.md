
## Problem Statement
The Nautilus DevOps team is working on a Kubernetes template to deploy a web application on the cluster. There are some requirements to create/use persistent volumes to store the application code, and the template needs to be designed accordingly. Please find more details below:


1. Create a `PersistentVolume` named as `pv-devops`. Configure the `spec` as storage class should be `manual`, set capacity to `4Gi`, set access mode to `ReadWriteOnce`, volume type should be `hostPath` and set path to `/mnt/data` (this directory is already created, you might not be able to access it directly, so you need not to worry about it).

2. Create a `PersistentVolumeClaim` named as `pvc-datacenter`. Configure the `spec` as storage class should be `manual`, request `3Gi` of the storage, set access mode to `ReadWriteOnce`.

3. Create a `pod` named as `pod-datacenter`, mount the persistent volume you created with claim name `pvc-devops` at document root of the web server, the container within the pod should be named as `container-datacenter` using image `nginx` with `latest` tag only (remember to mention the tag i.e `nginx:latest`).

Create a node port type service named `web-datacenter` using node port `30008` to expose the web server running within the pod.

`Note:` The `kubectl` utility on `jump_host` has been configured to work with the kubernetes cluster.

## Solution
* Run the provided files:
    `kubectl apply -f pv.yaml -f pvc.yaml -f pod.yaml -f pv-service.yaml`

`Note:` As per the instructions, "volume type should be `hostPath` and set path to `/mnt/data` (this directory is already created, you might not be able to access it directly, so you need not to worry about it)", the webpage may not be available. It shows a 403 error.

