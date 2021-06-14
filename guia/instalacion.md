# Instrucciones de instalación y despliegue

## En local

#### Requisitos previos:
* PHP 7.3.0 ó superior
* PostgreSQL
* Composer
* Git

#### Instalación:
1. Clonamos el proyecto:
   
   ```
   $ git clone https://github.com/joseckk/sharescode.git
   ``` 
2. Nos movemos a la raiz del proyecto y ejecutamos el siguiente comando:

    ```
    $ composer install
    ```

3. Creamos la base de datos e intyectamos con los scripts, dentro de la raiz del proyecto ejecutamos los siguientes comandos:

    ```
    $ db/create.sh
    $ db/load.sh
    ```
4. Modificamos el archivo **.env.example** y lo guardamos como **.env** con las siguentes variables de entorno:
    * `SMTP_PASS=clave de aplicación de correo`

5. Cambiamos la dirección de correo en:
`config/params.php`

5. Ejectumos la aplicación desde la raiz del proyecto con el siguiente comando:

    ```
     $ make serve
    ```
6. Abrimos el navegador con la siguiente dirección:
`http://localhost:8080/`



## En la nube

#### Requisitos previos:

* Heroku CLI (https://devcenter.heroku.com/articles/heroku-cli)

#### Instalación:

1. Crear cuenta en heroku.com

2. Iniciar sesión en Heroku y crear una apliación.

3. Introducir las mismas variables de entorno que usamos en local, pero añadiendo además la de 'YII_ENV=prod' para indicar que estamos en producción y no en desarrollo.

4. Añadir a la aplicación el *add-on* Heroku Postgres.

5. Iniciar sesión en heroku desde la terminal:

    ```
    $ heroku login
    ```

6. Inyectamos la base de datos:

    ```
    $ heroku psql < db/sharecode.sql
    ```

7. Sincronizar el proyecto con GitHub, y seleccionar en que rama queremos el despliegue:

    ```
    $ git push heroku master
    ```