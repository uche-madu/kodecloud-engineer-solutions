The Nautilus DevOps team has some data on each app server in `Stratos DC` that they want to copy to a different location. However, they want to create an archive of the data first, then they want to copy the same to a different location on the respective app server. Additionally, there are some specific requirements for each server. Perform the task using Ansible playbook as per requirements mentioned below:



Create a playbook named `playbook.yml` under `/home/thor/ansible` directory on `jump host`, an `inventory` file is already placed under `/home/thor/ansible/` directory on `Jump Server` itself.


1. Create an archive `official.tar.gz` (make sure archive format is `tar.gz`) of `/usr/src/security/` directory ( present on each app server ) and copy it to `/opt/security/` directory on all app servers. The user and group `owner` of archive `official.tar.gz` should be `tony` for `App Server 1`, `steve` for `App Server 2` and `banner` for `App Server 3`.

`Note:` Validation will try to run playbook using command `ansible-playbook -i inventory playbook.yml` so please make sure playbook works this way, without passing any extra arguments.

Details of users and servers are available [here](https://kodekloudhub.github.io/kodekloud-engineer/docs/projects/nautilus#infrastructure-details)

##Solution
* Create the playbook.yml file and edit the `inventory` file as per the `inventory` in this repo (add user_owner variable to each server). This is the more scalable approach.
* Alternatively, leave the inventory file unedited and create the playbook.yml file as provided with some changes as follows:
 ``` - name: Set user and group ownership based on ansible_host
      ansible.builtin.file:
        path: /opt/dba/demo.tar.gz
        owner: "{{ 'tony' if '172.16.238.10' in ansible_host else 'steve' if '172.16.238.11' in ansible_host else 'banner' }}"
        group: "{{ 'tony' if '172.16.238.10' in ansible_host else 'steve' if '172.16.238.11' in ansible_host else 'banner' }}"``` 
