## DuPHP ##
轻量，自由，极速，可高度自定义
## 如何使用##

伪静态
--------
    
    Nginx
        if (!-e $request_filename) {
       		 rewrite  ^(.*)$ /index.php?_s=$1 last;
             break;
        }
---------

	Apache
	<IfModule mod_rewrite.c>
		RewriteEngine on
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^(.*)$ index.php/?_s=$1 [QSA,L]
	</IfModule>      |