
## Problem Statement
The Nautilus DevOps team is practicing some of the Ansible modules and creating and testing different Ansible playbooks to accomplish tasks. Recently they started testing an Ansible file module to create soft links on all app servers. Below you can find more details about it.



Write a `playbook.yml` under `/home/thor/ansible` directory on `jump host`, an `inventory` file is already present under `/home/thor/ansible` directory on `jump host` itself. Using this playbook accomplish below given tasks:


1. Create an empty file `/opt/dba/blog.txt` on app server 1; its user owner and group owner should be `tony`. Create a `symbolic link` of source path `/opt/dba` to destination `/var/www/html`.


2. Create an empty file `/opt/dba/story.txt` on app server 2; its user owner and group owner should be `steve`. Create a `symbolic link` of source path `/opt/dba` to destination `/var/www/html`.


3. Create an empty file `/opt/dba/media.txt` on app server 3; its user owner and group owner should be `banner`. Create a `symbolic link` of source path `/opt/dba` to destination `/var/www/html`.


`Note:` Validation will try to run the playbook using command `ansible-playbook -i inventory playbook.yml` so please make sure playbook works this way without passing any extra arguments.
