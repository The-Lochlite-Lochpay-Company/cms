<h1><img src="./src/Disk/public/56x56.png">  Lochlite CMS</h1>
<p>This is not open source software. Lochlite grants you a limited and revocable personal license to manage its website. See our terms of service, license and privacy for more details.</p>

<p>Lochlite CMS is a modern content management software based on PWA technology, with it your website has an administrative control panel, user panel, reliable login system and a modern routing system that allows navigation without reloading the page. This is your best opportunity to get ahead of the competition with a robust website along the lines of big companies.</p>


<h3>Language</h3>
<p>Previously Lochlite CMS has a more restrictive license, this is slowly changing. Currently Lochlite is making the resources available seasonally, being available at this first moment only the Brazilian Portuguese version, even so, you can start using it.</p>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/BR.svg" /> Current &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/US.svg" /> Next &nbsp;&nbsp;&nbsp;&nbsp;    </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/ES.svg" /> September/2022 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/JP.svg" /> March/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/FR.svg" /> May/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>

<h3>Minimum technical requirement</h3>

```html
   Web server with the following features:
   - PHP 8.1
   - MySQL 5.7 (recommended 8.0) or MariaDB 10.0
   - Minimum storage of 20 GB
   - Minimum RAM memory of 1.5 GB
   - Dual-core or higher processor with background task support
   - Email service (sending and receiving)
   - File manager
```

<h3>Starting from scratch with a starter kit</h3>
<p>Currently you need a PHP developer to install this software or have moderate technical knowledge. If you're not sure if you can install it or things are going wrong, email <a href="mailto:drcg@lochlite.com"><strong> drcg@lochlite.com </strong></a> and we'll walk you through the process.</p>

<b>The instructions below must be followed using your personal/corporate computer and not directly on the server. In the next section you will see how to place Lochlite CMS on the web server.</b>

   1. <h5>Install Composer on your device</h5>
      <p>Follow the guidance <a href="https://getcomposer.org/doc/00-intro.md">from this page</a> and proceed to the next step.</p>

   2. <h5>Download Lochlite CMS</h5>
      <p>Open the command prompt in the folder of your choice, paste the highlighted text below and press Enter.</p>

      ```html
      composer create-project lochlite/cms-install lochlite 
      ```
      
      <p>This process may take a few minutes, do not interrupt it, wait until the command prompt is unlocked for new commands.</p>
      
   3. <h5>Configure the database</h5>
      <p>In the previous step a folder called 'lochlite' was created by the system. Enter the 'lochlite' folder and locate a file called 'env' or '.env'.</p>
      <p>Once you find the 'env' file, open it in a text editor, edit the snippet below with the corresponding details for your database and save the changes.</p>
      
      ```html
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=database_name
       DB_USERNAME=database_username
       DB_PASSWORD=database_password 
      ```
      <p>If you don't have a database or you don't know what the database details are, contact your hosting company or IT department for more details.</p>
   
   4. <h5>Making final adjustments</h5>
      <p>Return to the command prompt opened in step 1, paste the highlighted text below and hit enter.</p>
 
      ```html
      cd lochlite; php artisan migrate --force && php artisan db:seed --force 
      ```
      <p>This process may take a few minutes, do not interrupt it, wait until the command prompt is unlocked for new commands.</p>
      
<p>If no errors occurred in the previous steps, you are ready to put your site online and start creating your pages and articles.</p>    

<h3>Putting on a web server</h3>
<p>The steps described in the previous section <strong>must be done on your local computer and not directly on the server</strong>, to put Lochlite CMS on a web server safely, some additional steps are necessary.</p>    

         
