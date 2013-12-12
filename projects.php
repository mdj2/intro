<html>
<head>
<title>ARC Projects</title>
<link rel="stylesheet" href="main.css">
</head>
<body>
<h2>Project 0: Git Going</h2>
<p>Setup your VM, provision it and login (see <a href="index.php">Development Environment</a>).</p>

<p>In the <samp>/vagrant</samp> directory of your VM, create a new directory, <samp>tutorials</samp> and cd into it. Init a git repo with <samp>git init</samp>. Create a file, <samp>index.php</samp> with the following contents:</p>
<code>&lt;?php phpinfo(); ?&gt;</code>

<p>Add that file to your git repo with <samp>git add index.php; git commit -m "Initial commit"</samp></p>

<h3>Create a VirtualHost</h3>
<p>We need to create an Apache VirtualHost file, so you can serve up your <samp>/vagrant/tutorials</samp> directory on the web. Apache's vhost files are located in <samp>/etc/httpd/vhost.d</samp>. cd into that directory, and create the file <samp>tutorials.local.conf</samp> with the following contents:</p>
<code>&lt;VirtualHost *:80&gt;
    ServerName tutorials.local
    ServerAlias tutorials.local.*
    DocumentRoot /vagrant/tutorials
    ErrorLog /var/log/httpd/tutorials.local.error_log
    CustomLog /var/log/httpd/tutorials.local.access_log vhost

    &lt;Directory /vagrant/tutorials&gt;
        AllowOverride All
        Options Indexes FollowSymLinks
    &lt;/Directory&gt;
&lt;/VirtualHost&gt;
</code>

<p>This vhost won't work until you reload apache: <samp>service httpd reload</samp></p>
<p>Point your browser to http://tutorials.local.10.0.0.10.nip.io (you should see a PHP info page)</p>
<p>How does this all work? When Apache receives an HTTP request, it examines the URL requested  to determine which vhost it should use to handle the request. It tries to find a match based on the ServerName or ServerAlias directives in each vhost file. Since, <strong>tutorials.local.</strong>10.0.0.10.nip.io matches the ServerAlias <strong>tutorials.local.*</strong>, Apache uses that vhost. Since the DocumentRoot is specified as /vagrant/tutorials, it will serve up the index file there.</p>

<p>But what's with the nip.io, you ask? If you just pointed your browser to http://tutorials.local a DNS request would be sent out, asking for the IP address of tutorials.local (which won't exist). If we managed the DNS server ourselves, we could setup a DNS entry to map tutorials.local to 10.0.0.10 (the VM's IP address). But since we don't, we can use a fancy service like nip.io. nip.io's DNS system will return the IP address in the second component of the URL. So when we query the DNS server for tutorials.local.10.0.0.10.nip.io, nip.io will respond with 10.0.0.10.</p>


<h2>Project 1: Feedback Form</h2> 
<p>Create a simple feedback form using PHP (feedback.php). The form should have three fields: name, email address and a textarea for the user to enter feedback. When the form is submitted, it should send an email to <samp>YOU@pdx.edu</samp> (where <samp>YOU</samp> is your own ODIN name). The email should contain the user's name and the feedback they entered. To make it easy for you to reply, set a <samp>Reply-To</samp> header on the email to the user's email address.</p>

<p>After the form is processed and the email is sent, perform a 301 redirect to a "thank you" page (thanks.php).</p>

<p>When processing the form on the server side, make sure the user completely fills out the form with a valid email address, name, and feedback. If there are errors, redisplay the form with the relevant errors. Be sure to repopulate the form fields with the data the user entered so they don't have to retype it all!</p>

<h2>Project 2: Feedback Form with a Database Backend</h2>
<p>Modify <em>Project 1</em> so that instead of emailing you the feedback, the results are stored in a database table.</p>

<h2>Project 3: Central Authentication Service</h2>
<p>PSU uses a central authentication service (CAS) to handle authentication. CAS is a simple protocol, that you can implement from scratch.</p>

<p>Create a page, login.php, with the following contents:</p>
<code>&lt;?php
print_r($_GET);
?&gt;
</code>

<p>Now, create a simple page (home.php) with a login link. When clicked, the link should send the user to:</p>
<code>https://sso.pdx.edu/cas/login?service=http://10.0.0.10/login.php</code>
<p><em>This assumes your pages are accessible at 10.0.0.10. You may need to URL encode the <samp>service</samp> parameter</em>.</p>

<p>Now visit your home.php page, click the login link, and enter your ODIN credentials.</p>
<p>After logging in, note you are redirected to http://10.0.0.10/login.php, where your "ticket" is displayed.</p>

<p>To perform the authentication, you need to verify that the ticket is valid with the CAS server. In your browser, enter in:</p>
<p>https://sso.pdx.edu/cas/proxyValidate?ticket=<strong>YOUR_TICKET</strong>&service=http://10.0.0.10/login.php</p>
<p><em>Again, you may need to encode the <samp>service</samp> parameter of the URL</em></p>

<p>If all goes well, you will see a response from the CAS server with your username in it. View the source code on the page to see the full XML response.</p>

<p>Now edit your login.php file so that it automates the process of sending the ticket verification request to the CAS server. If the ticket is valid, create a session variable <samp>$_SESSION['username'] = $cas_username;</samp> (where $cas_username is the username that CAS responded with). Redirect the user to admin.php (just create a dummy page there for now).</p>

<h2>Project 4: Feedback Form Admin</h2>
<p>Now that authentication is working, create a page (admin.php) that returns, in an HTML table, all the feedback stored in the database. Make sure only you can access this page (check for the $_SESSION['username'] variable and make sure it matches your ODIN name).</p>

</body>
</html>
