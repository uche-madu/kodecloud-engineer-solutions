## Problem Statement
There is an application that needs to be deployed on Kubernetes cluster under Apache web server. The Nautilus application development team has asked the DevOps team to deploy it. We need to develop a template as per requirements mentioned below:


1. Create a `namespace` named as `httpd-namespace-xfusion`.

2. Create a `deployment` named as `httpd-deployment-xfusion` under newly created `namespace`. For the deployment use `httpd` image with `latest` tag only and remember to mention the tag i.e `httpd:latest`, and make sure replica counts are `2`.

3. Create a `service` named as `httpd-service-xfusion` under same `namespace` to expose the deployment, `nodePort` should be `30004`.

`Note:` The `kubectl` utility on `jump_host` has been configured to work with the kubernetes cluster.

## Solution
Create the `webserver.yml` file and run `kubectl apply -f webserver.yml`
The output on terminal shows:
```
namespace/httpd-namespace-xfusion created
deployment.apps/httpd-deployment-xfusion created
service/httpd-service-xfusion created
```
That's it.