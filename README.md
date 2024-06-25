

<p align="center">
  <img src="./Assets/Images/Logo_1.png" width="100" align="center"/>
</p>

# [![Typing SVG](https://readme-typing-svg.demolab.com?font=Fira+Code&weight=500&size=35&pause=1000&multiline=true&random=false&width=525&height=55&lines=PLAYAZ+LUXURY+STREETWEAR)](https://git.io/typing-svg)

Discover Playaz Luxxury Streetwear: Your destination for edgy urban fashion. Explore our curated collection of clothing apparel blending luxury with street attitude. Elevate your style today!

# Installation Guide

## Prerequisites

1. **Git**: Make sure Git is installed on your system. If not, you can download it from [git-scm.com](https://git-scm.com/).
2. **XAMPP**: Make sure XAMPP is installed on your system. If not, you can download it from [apachefriends.org](https://www.apachefriends.org/download.html).
3. **Visual Studio Code**: Make sure Visual Studio Code is installed on your system. If not, you can download it from [code.visualstudio.com](https://code.visualstudio.com/).

# Installation Steps

## Step 1: Download the Repository

Click on the green **"Code"** button and select **"Download ZIP"**.

## Step 2: Extract the Files

After downloading the ZIP file, right-click on the file and select **"Extract All"**.

## Step 3: Open the Folder

Navigate to the extracted folder and open it. You should see a folder named **"EcomProject-G5-main"**. Rename it to **"EcomProject-G5"**.

## Step 4: Move the Folder

Move the **"EcomProject-G5"** folder to the following directory: `C:\xampp\htdocs`.

## Step 5: Start XAMPP

Open XAMPP and start the **Apache** and **MySQL** services.

## Step 6: Import the Database

### Modify Configuration Files

Before importing the database, you need to modify your `php.ini` and `my.ini` files.

1. **php.ini:**

   - Open the XAMPP Control Panel and click on the **"Config"** button for Apache then select **"php.ini"**.
   - Change the following values: <sup>(you can use Ctrl + F to search for the values)</sup>
     ```ini
     post_max_size = 750M
     upload_max_filesize = 750M
     max_execution_time = 5000
     max_input_time = 5000
     memory_limit = 1000M
     ```
   - Save the file and restart the Apache service.

2. **my.ini:**
   - Click on the **"Config"** button for MySQL then select **"my.ini"**.
   - Change the following value:
     ```ini
     max_allowed_packet = 750M
     ```
   - Save the file and restart the MySQL service.

By modifying these values, you are increasing the maximum file upload size and execution time for PHP scripts. This is necessary to import the database successfully.

### Import Database

1. Open your browser and go to `http://localhost/phpmyadmin/`.
2. Go to the **"Import"** tab and click on the **"Choose File"** button.
3. Navigate to the `EcomProject-G5/Database` folder and select the **"playaz_db.sql"** file.
4. Click on the **"Go"** button to import the database.

## Step 7: Open the Website

Open your browser and go to `http://localhost/EcomProject-G5/`.

## Step 8: Login to the Admin Panel

Go to `http://localhost/EcomProject-G5` and just login with the following credentials:

### Admin Credentials

- **Username:** admin
- **Password:** admin

after logging in, you can click on your profile then click on the "Dashboard" button to access the admin panel.

### Seller Credentials

- DBTK Seller
  - **Username:** dbtk@example.com
  - **Password:** dbtk123

after logging in, you can click on your profile then click on the "Dashboard" button to access the seller panel.

### Customer Credentials

For customer credentials, you can create a new account or use the following test account:

- **Email:** Example@domain.com
- **Password:** 123456

Please make sure that you have a working internet connection to load some of the external resources used in the website. 

## Step 9: Update SMTP Configuration

Login to the admin panel and go to the **"Email Services"** section. Update the SMTP configuration with your own email settings to enable email services like account verification, password reset, etc.

## Step 10: Enjoy the Website

You have successfully installed the website. Enjoy exploring the features of the <strong>Playaz Luxury Streetwear</strong> website!
