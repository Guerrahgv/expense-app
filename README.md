# Expensess en PHP

## Config proyecto

### Bd
-crear una base de datos e importar en `bd/expenses.sql`

### servidor
Para actualizar las conexiones a la base de datos es importante cambiar los datos que se encuentran en `/config/config.php` actualmente: 


```php
define('URL', 'http://localhost:80/expense-app/')
define('HOST', 'localhost')
define('DB', 'expenseapp')
define('USER', 'root')
define('PASSWORD', "") -> Cambiar segun tu password de BD
define('CHARSET', 'utf8mb4')
```

tambien  en `public/js/dashboard.js`, `public/js/admin.js` y `views/expenses/index.php` es necesario verificar que las URLs usadas para hacer solicitudes asíncronas estén también apuntando correctamente de acuerdo a tu servidor, actualmente: `http://localhost:80/expense-app/`.

## Users:

```
Admin: admin
Password: admin

user: roberto
Password: roberto


user: prueba
Password: prueba
```