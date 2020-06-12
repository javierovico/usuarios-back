<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre el Proyecto:
Todas las peticiones deben tener como cabecera ```Content-Type: application/json```

Todas los parametros deben ser enviados y recibidos como json
<h3>- Inicio de sesion:</h3>

Ruta: /api/auth/login

Metodo: POST

Parametros: 
```json
{
    "email":"correo@correo.com",
    "password":"passWorD"
}
```
Respuesta exitosa: status(200)
```json
{
       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTY0MTc5Zjk4YmE4ZDVhZGY0NzA1ZTA2ZGI1MGM2OGU4OGZlODYwZmQ1OGFhMzdkM2VmNzE3Y2I1MzI3Y2YzZGM5NzI1NWIzMDUzZjMxZmMiLCJpYXQiOjE1OTE5ODY1MzksIm5iZiI6MTU5MTk4NjUzOSwiZXhwIjoxNjIzNTIyNTM5LCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.qto6BtDj8nEH2lEIXtcN4pU9gliV_pp78ksibTdJLvW_liIV-IMRhGQtlrtv_2aIkGqjABLU0e0AOaFQLSqwexTbOOWFfd_of7xQDzPjkz0605GOh_EDSl_bt3H1Oz0DHhVyDmZbDQ2kXmfmXNruVsRT-tkXVHN8O5115gpQC_0fEk-ck-u-PUCglfz4HcNldgUKN0bbAEo_ja26gBt8UFgQEgm_GObZ6SCpj3_u9HoKQ8FDP_SujVJSWT60S1Sa0cTcfgr2ZqowDkGQk6XR2dH6TxnyDj4-LuhhHsCO10BP9U_22N0FfT5lcrIrH_EcWH2WIxqp-b8hQljjES8pBmb0-lFm2352Mo-tx2b8RNQkGddg1jmkfaarBF6vbVMhaZth6mhmiIloDVd_hIERRuQAMFegnuyiamZb8NHznRHWRuzdeNTc4Qvs9bp62FdlYUx3qUmz6J6WrtwRDnuuLqld53lka9VN0MJY1tLZfKdij83H69Y9nncxeWn_eJ50v8L21iqCITqp4S0vTMr8BEgzIczUw2PbEd8Nxx2WiOLr4V_HnHkzLmI1rc0TWTaookijuV-sqjZ0CLKhPlhYS7IvbR5Q4F0aP1Lpdewccx7rfyJIsonqL_enNW54i7AmysfWz5k1NekG5qm9Od5vyavWK5C86xq6egXCJttgBnU",
       "token_type": "Bearer",
       "expires_at": "2020-06-12 19:28:59"
   }
```
El frontend debe encargarse de guardar el access_token y enviarlo en la cabecera de cada futura peticion.

Ejemplo:
```
  axios.defaults.headers.common['Authorization'] = 'Bearer '+access_token;
```

Respuesta Fallida: status () != 200
```json
{
    "message": "Unauthorized"
}
```

<h3>- Creacion de usuario:</h3>

Ruta: /api/auth/signup

Metodo: POST

Parametros: 
```json
{
    "email":"user1@usuarios.com.py",
    "password":"user1",
    "first_name":"aldo",
    "last_name":"javier",
    "username":"aldinho",
    "password_confirmation":"user1",
    "name":"aldovico"
}
```
Nota: todos los parametros son obligatorios, y el parametro username y email deben ser unicos

Nota2: en caso de algun error, retornara un estado != 200 con un "message" y una lista de errores en "errors"
indicando cual parametro presenta inconsistencia

Ejemplo Respuesta erronea: status(422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```
Ejemplo Respuesta correcta: status(201)
```json
{
    "success": true,
    "message": "usuario creado"
}
```

<h3>- Deslogueo de usuario:</h3>

Desloguea un usuario (inhabilita el token)

Ruta: /api/auth/logout

Metodo: GET

Parametros: ninguno

Nota: El token debe estar presente

Retorno: no retorna nada


<h3>- Perfil de usuario:</h3>

Te trae la informacion de tu usuario, ademas te trae los roles del usuario

Ruta: /api/auth/user

Metodo: GET

Parametros: ninguno

Ejemplo Respuesta erronea: status(401) Si el usuario no esta autenticado o si el token caduco 
```json
{
    "message": "Unauthenticated."
}
```
Ejemplo Respuesta correcta: status(200)
```json
{
    "id": 1,
    "first_name": "",
    "last_name": "",
    "username": "admin",
    "name": "Aldo",
    "email": "admin@usuarios.com.py",
    "email_verified_at": null,
    "status": "00",
    "created_at": "2020-06-11T00:05:27.000000Z",
    "updated_at": "2020-06-12T13:06:32.000000Z",
    "rols": [
        {
            "id": 2,
            "name": "admin",
            "description": "rol administrador",
            "created_at": "2020-06-11T00:05:27.000000Z",
            "updated_at": "2020-06-11T00:05:27.000000Z",
            "pivot": {
                "user_id": 1,
                "rol_id": 2,
                "created_at": "2020-06-12T13:06:32.000000Z",
                "updated_at": "2020-06-12T13:06:32.000000Z"
            }
        },
        {
            "id": 1,
            "name": "user",
            "description": "rol por defecto",
            "created_at": "2020-06-11T00:05:27.000000Z",
            "updated_at": "2020-06-11T00:05:27.000000Z",
            "pivot": {
                "user_id": 1,
                "rol_id": 1,
                "created_at": "2020-06-12T13:06:32.000000Z",
                "updated_at": "2020-06-12T13:06:32.000000Z"
            }
        }
    ]
}
```


<h3>- Lista de usuarios:</h3>

Trae una paginacion de todos los usuarios registrados

nota: Solo los usuarios con rol de admin pueden ver a otros usuarios

Ruta: /api/user

Metodo: GET

Parametros opcionales:
- id: para obtener la informacion de un usuario solamente (default null)
- page: para la paginacion (selecciona la pagina actual) (default 2)
- cantidad: para establecer la cantidad de items por pagina (default 20)

Ejemplo: 
```json
{
  "id": "3",
  "page": "2",
  "cantidad": "20"
}
```


Ejemplo Respuesta erronea: status(403) Si el usuario no esta autenticado o si no tiene permiso de admin
```json
{
    "message": "No autenticado|necesitas roles de admin",
    "exception": "Symfony\\Component\\HttpKernel\\Exception\\HttpException",
    "file": "/home/aldo/PhpstormProjects/UsuariosBack/vendor/laravel/framework/src/Illuminate/Foundation/Application.php",
    "line": 1067,
    "trace": [
        {
            "file": "/home/aldo/PhpstormProjects/UsuariosBack/vendor/laravel/framework/src/Illuminate/Foundation/helpers.php",
            "line": 44,
            "function": "abort",
            "class": "Illuminate\\Foundation\\Application",
    ...
```
Ejemplo Respuesta correcta: status(200)
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "first_name": "",
            "last_name": "",
            "username": "admin",
            "name": "Aldo",
            "email": "admin@usuarios.com.py",
            "email_verified_at": null,
            "status": "00",
            "created_at": "2020-06-11T00:05:27.000000Z",
            "updated_at": "2020-06-12T13:06:32.000000Z",
            "rols": [
                {
                    "id": 2,
                    "name": "admin",
                    "description": "rol administrador",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 1,
                        "rol_id": 2,
                        "created_at": "2020-06-12T13:06:32.000000Z",
                        "updated_at": "2020-06-12T13:06:32.000000Z"
                    }
                },
                {
                    "id": 1,
                    "name": "user",
                    "description": "rol por defecto",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 1,
                        "rol_id": 1,
                        "created_at": "2020-06-12T13:06:32.000000Z",
                        "updated_at": "2020-06-12T13:06:32.000000Z"
                    }
                }
            ]
        },
        {
            "id": 6,
            "first_name": "aldo",
            "last_name": "javier",
            "username": "aldinho",
            "name": "aldovico",
            "email": "user1@usuarios.com.py",
            "email_verified_at": null,
            "status": "00",
            "created_at": "2020-06-12T17:05:29.000000Z",
            "updated_at": "2020-06-12T17:23:31.000000Z",
            "rols": [
                {
                    "id": 1,
                    "name": "user",
                    "description": "rol por defecto",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 6,
                        "rol_id": 1,
                        "created_at": "2020-06-12T17:05:29.000000Z",
                        "updated_at": "2020-06-12T17:05:29.000000Z"
                    }
                }
            ]
        },
        {
            "id": 7,
            "first_name": "Aldinho",
            "last_name": "Javierovico",
            "username": "aldin",
            "name": "aldovicoooo",
            "email": "user3@user.com",
            "email_verified_at": null,
            "status": "00",
            "created_at": "2020-06-12T17:13:09.000000Z",
            "updated_at": "2020-06-12T17:13:09.000000Z",
            "rols": [
                {
                    "id": 1,
                    "name": "user",
                    "description": "rol por defecto",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 7,
                        "rol_id": 1,
                        "created_at": "2020-06-12T17:13:09.000000Z",
                        "updated_at": "2020-06-12T17:13:09.000000Z"
                    }
                }
            ]
        },
        {
            "id": 8,
            "first_name": "tresNombre",
            "last_name": "tresApellido",
            "username": "tresusername",
            "name": "tresname",
            "email": "tres@usuario.com",
            "email_verified_at": null,
            "status": "00",
            "created_at": "2020-06-12T17:14:15.000000Z",
            "updated_at": "2020-06-12T17:14:15.000000Z",
            "rols": [
                {
                    "id": 1,
                    "name": "user",
                    "description": "rol por defecto",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 8,
                        "rol_id": 1,
                        "created_at": "2020-06-12T17:14:16.000000Z",
                        "updated_at": "2020-06-12T17:14:16.000000Z"
                    }
                }
            ]
        },
        {
            "id": 10,
            "first_name": "aldo",
            "last_name": "javier",
            "username": "aldinho2",
            "name": "aldovico",
            "email": "user2@usuarios.com.py",
            "email_verified_at": null,
            "status": "00",
            "created_at": "2020-06-12T18:41:25.000000Z",
            "updated_at": "2020-06-12T18:41:25.000000Z",
            "rols": [
                {
                    "id": 1,
                    "name": "user",
                    "description": "rol por defecto",
                    "created_at": "2020-06-11T00:05:27.000000Z",
                    "updated_at": "2020-06-11T00:05:27.000000Z",
                    "pivot": {
                        "user_id": 10,
                        "rol_id": 1,
                        "created_at": "2020-06-12T18:41:25.000000Z",
                        "updated_at": "2020-06-12T18:41:25.000000Z"
                    }
                }
            ]
        }
    ],
    "first_page_url": "http://localhost:82/api/user?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:82/api/user?page=1",
    "next_page_url": null,
    "path": "http://localhost:82/api/user",
    "per_page": 20,
    "prev_page_url": null,
    "to": 5,
    "total": 5
}
```



<h3>- Editar usuarios:</h3>

Edita un usuario por su id

nota: Solo los usuarios con rol de admin pueden editar a otros usuarios

Ruta: /api/user/{id}

Metodo: PUT

- Parametros:
Los parametros son los mismos que el metodo de creacion de usuario, con la diferencia
que en este caso, todos los parametros son opcionales.
- Nota 2: tambien se pueden agregar o quitar roles al usuario con el parametro rols

Ejemplo: Cambio de username y password
```json
{
    "password":"user1",
    "username":"aldinho",
    "password_confirmation":"user1"
}
```

Ejemplo: agregar rol de admin y quitar rol de user
```json
{
    "params...": "...",
	"rols": {
		"admin":true,
		"user":false
	}
}
```

- Respuestas: Las posibles respuestas son identicas a las de listar usuarios


<h3>- Borrar usuario:</h3>

Borra un usuario conociendo su ID

nota: Solo los usuarios con rol de admin pueden borrar otros usuarios

Ruta: /api/user/{id}

Metodo: DELETE

- Parametros: NINGUNO

- Respuestas: Las posibles respuestas son identicas a las de listar usuarios


<h3>- Mostrar un usuario:</h3>

Muestra los datos de un usuario dado su ID

nota: Solo los usuarios con rol de admin pueden ver otros usuarios

Ruta: /api/user/{id}

Metodo: GET

- Parametros: NINGUNO

- Respuestas: un json con los datos del usuario
- Respuestas: error: un error 403

- Ejemplo de respuesta correcta 200:
```json
{
    "id": 10,
    "first_name": "aldo",
    "last_name": "javier",
    "username": "aldinho2",
    "name": "aldovico",
    "email": "user2@usuarios.com.py",
    "email_verified_at": null,
    "status": "00",
    "created_at": "2020-06-12T18:41:25.000000Z",
    "updated_at": "2020-06-12T18:41:25.000000Z",
    "rols": [
        {
            "id": 1,
            "name": "user",
            "description": "rol por defecto",
            "created_at": "2020-06-11T00:05:27.000000Z",
            "updated_at": "2020-06-11T00:05:27.000000Z",
            "pivot": {
                "user_id": 10,
                "rol_id": 1,
                "created_at": "2020-06-12T18:41:25.000000Z",
                "updated_at": "2020-06-12T18:41:25.000000Z"
            }
        }
    ]
}
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**

### Community Sponsors

<a href="https://op.gg"><img src="http://opgg-static.akamaized.net/icon/t.rectangle.png" width="150"></a>

- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
