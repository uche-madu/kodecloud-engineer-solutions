
## Problem Statement
Several new developers and DevOps engineers just joined the xFusionCorp industries. They have been assigned the `Nautilus` project, and as per the onboarding process we need to create user accounts for new joinees on at least one of the app servers in `Stratos DC`. We also need to create groups and make new users members of those groups. We need to accomplish this task using Ansible. Below you can find more information about the task.


There is already an inventory file `~/playbooks/inventory` on `jump host`.


On `jump host` itself there is a list of users in `~/playbooks/data/users.yml` file and there are two groups — `admins` and `developers` — that have list of different users. Create a playbook `~/playbooks/add_users.yml` on `jump host` to perform the following tasks on `app server 2` in `Stratos DC`.


a. Add all users given in the `users.yml` file on `app server 2`.


b. Also add `developers` and `admins` groups on the same server.


c. As per the list given in the `users.yml` file, make each user member of the respective group they are listed under.


d. Make sure home directory for all of the users under `developers` group is `/var/www` (not the default i.e `/var/www/{USER}`). Users under `admins` group should use the default home directory (i.e `/home/devid` for user `devid`).


e. Set password `ksH85UJjhb` for all of the users under `developers` group and `dCV3szSGNA` for of the users under `admins` group. Make sure to use the password given in the `~/playbooks/secrets/vault.txt` file as Ansible vault password to encrypt the original password strings. You can use `~/playbooks/secrets/vault.txt` file as a vault secret file while running the playbook (make necessary changes in `~/playbooks/ansible.cfg` file).


f. All users under `admins` group must be added as sudo users. To do so, simply make them member of the `wheel` group as well.


`Note:` Validation will try to run the playbook using command `ansible-playbook -i inventory add_users.yml` so please make sure playbook works this way, without passing any extra arguments.

## Solution
1. Encrypt the Passwords using Ansible Vault:
    ```bash
    ansible-vault encrypt_string 'ksH85UJjhb' --name 'developer_password' --vault-password-file ~/playbooks/secrets/vault.txt > ~/playbooks/secrets/developer_password.yml

    ansible-vault encrypt_string 'dCV3szSGNA' --name 'admin_password' --vault-password-file ~/playbooks/secrets/vault.txt > ~/playbooks/secrets/admin_password.yml
    ```
2. Modify the ansible.cfg:
    Add the vault password file location to the ansible.cfg:
        ```bash
        [defaults]
        host_key_checking = False
        vault_password_file = ~/playbooks/secrets/vault.txt
        ```
3. Create the ansible playbook `~/playbooks/add_users.yml`


`Note:` Without Encrypting the passwords, you'd expect the following warning, which happens because ansible expects hashed passwords for security reasons. 

    ```bash
    TASK [Add admin users with default home directories and set password] *********************
    changed: [stapp02] => (item=rob)
    changed: [stapp02] => (item=david)
    changed: [stapp02] => (item=joy)
    [WARNING]: The input password appears not to have been hashed. The 'password' argument must be encrypted for this module to work properly.
    ```
However, in the playbook, I have included password hashing using the python `passlib` library.