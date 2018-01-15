Prerequisites:

-a database named 'todo'
-login for the database:

	connection: localhost
	User: root
	pw: 123abc

-bitnami WAMP Stack server

To run this program you must have a webserver running that can handle php files

I used a server program called Bitname WAMP Stack so this guide is 
written under the assumption you used that as well



1. place overview.php, task.php, taskManager.php, and todo-main.php inside of dir\bitnami\apache2\htdocs

2. make sure that your webserver is running

3. navigate to localhost/todo-main.php in your browser

4. press 'Initialize Database to ensure database is set up properly
