# ante-toki-pona
platform for crowdsourced translating of larger works of literature, initially made for toki pona

Depending on where you install it on your server, you might have to change all instances of $_SERVER["DOCUMENT_ROOT"] in all php files to the path you're using. And you'll probably want to add a password protection through .htaccess and .htpasswd for /backend

Use blank.csv as a template for making a new translation project, then upload it using /backend/upload.php  
