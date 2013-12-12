<html>
<head>
<title>ARC Cheatsheet</title>
<link rel="stylesheet" href="main.css">
</head>
<body>

<h2>Development Environment</h2>
<p>Vagrant and VirtualBox are used in combination to bootstrap your development environment. Download and extract our base configuration here:<br />
<a href="https://github.com/PSU-OIT-ARC/vagrant-manifest/archive/master.zip">https://github.com/PSU-OIT-ARC/vagrant-manifest/archive/master.zip</a></p>
<p>Then run (assuming you have a supported version of Vagrant and VirtualBox installed):</p>
<code>vagrant up --provision</code>
<p>When it's booted and provisioned, login with <samp>ssh root@10.0.0.10</samp> (the password is "vagrant"). When you're done for the day, you can shutdown your virtual machine with <samp>vagrant halt</samp>. And the next day, just run <samp>vagrant up</samp> to bring it back. You can develop on the host machine, and run your code on the VM using the shared /vagrant directory (on the VM, which is shared with the host). This saves you from having to <samp>scp</samp> files around.</p>


<h2>Git</h2>

<h3>First Steps</h3>
<p>Create a <a href="http://github.com">github.com</a> account (even if you already have one). Then send us your username, and we'll add you to our PSU-OIT-ARC group.</p>
<p>On your development VM, configure git:</p>
<code>git config --global user.name "$first_name $last_name" 
git config --global user.email "$email"
git config --global push.default simple</code>

<h3>Workflow</h3>
<p>First <em>fork</em> the repo off of github.com/PSU-OIT-ARC/$repo_name into your own github account. Then clone <em>your</em> fork into your development environment and add a remote back to the ARC repo:</p>
<code>git clone git@github.com:$username/$repo_name.git
cd $repo_name
git remote add arc git@github.com:PSU-OIT-ARC/$repo_name.git</code>
<p>On <em>your</em> fork of the repo, you are free to develop however you see fit (it is assumed no one will pull from your repo). At least daily, make sure you merge or rebase in any changes on the ARC repo:</p>
<code>git pull arc master # use the --rebase option if you know what you're doing</code>
<p>For your own safely, you should push your local commits to github frequently:</p>
<code>git push</code>
<p>When your commits are tested and stable, you can push to the ARC repo:</p>
<code>git push arc master</code>


<h2>Project Setup &amp; Conventions</h2>

<p>A share at <samp>/vol/www/$project_name</samp> is created. It contains two subdirectories, <samp>prod</samp> and <samp>dev</samp><sup>&#134;</sup> (older projects may have <samp>htdocs</samp> and <samp>htdocs_dev</samp> directories instead). Both these directories are clones of the PSU-OIT-ARC/$project_name repo. A dev vhost is put on <samp>hermes.rc</samp> with a ServerName directive of <samp>ServerName $sitename.dev.rc.pdx.edu</samp> (*.dev.rc.pdx.edu is a wildcard DNS entry so no DNS needs to be configured). The prod vhost is placed on the production web servers by the unix team. 
Prod and dev databases should be created on <samp>mysql.rc</samp> and <samp>hermes.rc</samp>, respectively. See the following repos for our project structures and conventions:
</p>
<ul>
    <li>Django: <a href="https://github.com/PSU-OIT-ARC/django-example">https://github.com/PSU-OIT-ARC/django-example</a></li>
    <li>PHP: <a href="https://github.com/PSU-OIT-ARC/php-example">https://github.com/PSU-OIT-ARC/php-example</a> TODO</li>
    <li>Drupal: <a href="https://github.com/PSU-OIT-ARC/drupal-example">https://github.com/PSU-OIT-ARC/drupal-example</a> TODO</li>
</ul>
<p><small><sup>&#134;</sup>dev is not for development, but for staging. You do your development on your own VM</small></p>

<h3>Git Conventions</h3>
<p><samp>/vol/www/$project_name/(dev|prod)</samp> are both clones of the <em>same</em> repo. <samp>prod</samp> always runs off the master branch and <samp>dev</samp> typically runs off the master branch as well. <samp>dev</samp> can pull in changes at any time from the PSU-OIT-ARC repo, whereas <samp>prod</samp> only pulls in commits when they are considered stable.</p>

<h3>Always...</h3>
<ul>
    <li>create a README that describes, in excruciating detail, how to bootstrap and run an application after a git clone.</li>
    <li>use <samp>__file__</samp> (Python) or <samp>__FILE__</samp> (PHP) to generate paths (don't hardcode them).</li>
    <li>exclude credentials like DB usernames/passwords, API keys, reproducible binaries, and user uploads from the git repo.</li>
</ul>


<h2>Checklist</h2>

<ol class="checklist">
    <li>Get added to consultants@pdx.edu</li>
    <li>Get a research shell account</li>
    <li>Get added to the arc group</li>
    <li>Get added to github:PSU-OIT-ARC</li>
</ol>


<h2>Useful URLs</h2>

<ul>
    <li>TODO timesheet URL</li>
    <li>example.com</li>
    <li><a href="http://github.com/PSU-OIT-ARC">github.com/PSU-OIT-ARC</a></li>
    <li><a href="http://traq.research.pdx.edu">traq.research.pdx.edu</a></li>
    <li><a href="http://support.oit.pdx.edu">support.oit.pdx.edu</a></li>
</ul>


<h2>Servers</h2>

<table>
    <tr>
        <th>Function</th>
        <th>Hostname(s)</th>
    </tr>
    <tr>
        <td>Login</td>
        <td>circe.rc, hecate.rc</td>
    </tr>
    <tr>
        <td>Web: Staging</td>
        <td>hermes.rc</td>
    </tr>
    <tr>
        <td>Web: Production</td>
        <td>iris.rc, helios.rc</td>
    </tr>
    <tr>
        <td>DB: Production</td>
        <td>pgsql.rc, mysql.rc</td>
    </tr>
    <tr>
        <td>DB: Staging</td>
        <td>hermes.rc</td>
    </tr>
</table>

</body>
</html>
