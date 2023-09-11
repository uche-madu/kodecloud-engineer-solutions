The Nautilus application development team observed some performance issues with one of the application that is deployed in Kubernetes cluster. After looking into number of factors, the team has suggested to use some in-memory caching utility for DB service. After number of discussions, they have decided to use Redis. Initially they would like to deploy Redis on kubernetes cluster for testing and later they will move it to production. Please find below more details about the task:


Create a redis deployment with following parameters:

1. Create a `config map` called `my-redis-config` having `maxmemory 2mb` in `redis-config`.

2. Name of the deployment should be `redis-deployment`, it should use
`redis:alpine` image and container name should be `redis-container`. Also make sure it has only `1` replica.

3. The container should request for `1` CPU.

4. Mount `2` volumes:

    a. An Empty directory volume called `data` at path `/redis-master-data`.

    b. A configmap volume called `redis-config` at path `/redis-master`.

    c. The container should expose the port `6379`.

5. Finally, `redis-deployment` should be in an up and running state.
`Note:` The `kubectl` utility on `jump_host` has been configured to work with the kubernetes cluster.