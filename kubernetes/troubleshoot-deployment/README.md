Last week, the Nautilus DevOps team deployed a redis app on Kubernetes cluster, which was working fine so far. This morning one of the team members was making some changes in this existing setup, but he made some mistakes and the app went down. We need to fix this as soon as possible. Please take a look.



The deployment name is `redis-deployment`. The pods are not in running state right now, so please look into the issue and fix the same.

## Solution Steps
* Run `kubectl describe deployments.apps redis-deployment` to see that the deployment is running a `redis:alpin` image. Note that it appears misspelt.
* Run `kubectl describe pod`. This shows the status of the pod which is stuck at `ContainerCreating`, so obviously, something is wrong with the pod.
* Run `kubectl get deployments.apps redis-deployment -o yaml > redis-deployment.yaml` to output the deployment config into a file
* Run `vi redis-deployment.yaml`. Edit .spec.containers[0].image = `redis:alpine` and .spec.volumes.configmap.name = `redis-config`. Notice that the names were misspelt.
* With the deployment config saved to a file, delete the existing faulty deployment with `kubectl delete deployments.apps redis-deployment`
* Running `kubectl get deployment` shows that the resource no longer exists.
* Run `k apply -f redis-deployment.yaml`
