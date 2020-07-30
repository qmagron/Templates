# Templates

This repository contains templates for websites and web apps.

## SQL database

Some templates are using SQL to manage database.

The used PHP extension for accessing databases is PDO (*PHP Data Object*), just enable it by uncomment the following line in `php.ini`:

```
extension=pdo_mysql
```

The code is written to work with MySQL / MariaDB but can be easily adapted for other DBMS.

All these templates are using the `templates` database. Just modify the inititial PDO instantiation to make it work with your configuration.

To create preset tables for testing, enter the following command:

```
mysql -p < given_file.sql
```

### Safety notice

PDO instantiation requires writing the login and password in clear text in the source file to access the database.

To prevent malicious alteration of the database, it is recommended to create a new user with just the necessary rights:

```sql
CREATE USER 'user'@'localhost' IDENTIFIED BY 'pass';
GRANT SELECT|INSERT|UPDATE|DELETE ON templates.tableName TO 'user'@'localhost';
```

To prevent a malicious person from reading the source files on the server, just change access permissions of files containing sensitive data and disallow the non-root users to read it:

```shell
chown http:http file.php
chmod 600 file.php
```

*Note:* the web server must still be able to read these files.
