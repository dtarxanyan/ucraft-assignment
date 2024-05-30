## How to install

<b>It is required to have Docker to be installed on your macOS or Windows device</b>

<code>git clone https://github.com/dtarxanyan/ucraft-assignment.git </code>

It is a monorepo that containing <b>RMQ</b>, The <b>Blog Laravel</b>  application and The <b>Notifications Node.js</b>
application.

<code>cd ucraft-assignment</code>

<code>chmod +x local-deployment.sh && ./local-deployment.sh</code>

After running the command above, all required containers will be automatically created.

You can check the result on the Docker desktop application to make sure that all containers are properly running

<i><b>Note:</b> It is important to run the command above inside a compatible shell environment installed. For example
Git Bash or your IDE terminal with shell support:</i>

## How to test

<b>API</b>

Here is the link to the postman collection. 
https://api.postman.com/collections/26501479-265ddc6a-fc8d-4343-b5b3-8c21b05fb5e5?access_key=PMAT-01HZ9TH70QYR1QR42DRN8YN5VT



<b>Microservices</b>

Event logs are being captured to the notifications.app container stdout. You can open the container and see logs related to
the consumer 


<b>Notification creation inside DB</b>

There is also <b>pgadmin</b> container which will allow to see all the created notifications inside database. 

URL: http://localhost:5050/browser/ 
username: admin@admin.com
password: pgadmin4

You will need to connect to the database:

- on the top left side in the menu right click to the Servers
- Then Register > Server ...
- Enter any name as a connection name 
- Go to the <b>Connection</b>tab (Next to General)
- Host name/address: db 
- username: postgres
- password: postgres

Then you can find <b>post_notifications</b> table inside the <b>notifications</b> db and see all created notifications