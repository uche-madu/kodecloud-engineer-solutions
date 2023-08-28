One of the DevOps team members has created a zip archive on `jump host` in `Stratos DC` that needs to be extracted and copied over to all app servers in `Stratos DC` itself. Because this is a routine task, the `Nautilus` DevOps team has suggested automating it. We can use Ansible since we have been using it for other automation tasks. Below you can find more details about the task:


We have an `inventory` file under `/home/thor/ansible` directory on `jump host`, which should have all the app servers added already.


There is a zip archive `/usr/src/security/devops.zip` on `jump host`.


Create a `playbook.yml` under `/home/thor/ansible/` directory on `jump host` itself to perform the below given tasks.


1. Unzip `/usr/src/security/devops.zip` archive in `/opt/security/` location on all app servers.


2. Make sure the extracted data must have the respective sudo user as their `user` and `group` owner, i.e tony for app server 1, steve for app server 2, banner for app server 3.


3. The extracted data permissions must be `0755`.


`Note:` Validation will try to run the playbook using command `ansible-playbook -i inventory playbook.yml` so please make sure playbook works this way, without passing any extra arguments.


## Solution
As a simpler alternative to the playbook available in `playbook.yml`, the `unarchive` module can handle it all like so:

```
---
- name: Extract and Set Permissions for devops.zip
  hosts: all
  become: yes
  tasks:
    - name: Unzip /usr/src/security/devops.zip in /opt/security/ on app servers
      ansible.builtin.unarchive:
        src: /usr/src/security/devops.zip
        dest: /opt/security/
        remote_src: no
        owner: "{{ ansible_user }}"
        group: "{{ ansible_user }}"
        mode: '0755'

```
