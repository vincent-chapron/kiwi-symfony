docker run --name=mysql -d -p 3307:3306 -e MYSQL_DATABASE=kiwi -e MYSQL_ROOT_PASSWORD=root centurylink/mysql
echo "\033[32mmysql --host 127.0.0.1 --port 3307 -uroot -p kiwi\033[0m"
