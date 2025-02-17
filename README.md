# Web Application

## Description
This application allows users to:  
- Register and log in  
- Add products to the shopping cart  
- Place orders  
- Generate an XML file with order data  

![image](img/z0.png)
![image](img/z1.png)
![image](img/z2.png)
![image](img/z3.png)
![image](img/z4.png)

## Deployment  

### Docker  
To start the application using Docker, run:
```bash
sudo docker-compose up
```

### Ansible  
If the `inventory` file has been configured, the application can be deployed using Ansible:
```bash
ansible-playbook ansible.yml -i inventory --ask-become-pass --vault-id @prompt
```  

Ansible installs the application in `/var/www/html` by default, replacing existing files in this location.  

#### Requirements for Ansible  
The application can be installed on **Debian** and **RedHat**-based systems.  

## Technologies Used  
- **PHP** – backend application (port **80**)  
- **MySQL** – database (port **3306**)  
- **SCSS, JavaScript** – frontend 