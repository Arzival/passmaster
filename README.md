# PassMaster Backend

Este proyecto es el backend para **PassMaster**, una aplicación que permite gestionar contraseñas de manera segura. Está construido con **Laravel 11** y utiliza **PHP 8.3**.

## Tabla de Contenidos
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Características](#características)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [API Endpoints](#api-endpoints)
- [Contribución](#contribución)

---

## Requisitos

Antes de instalar este proyecto, asegúrate de tener los siguientes requisitos:

- **PHP 8.3** o superior.
- **Composer**.
- **MySQL** o cualquier otra base de datos compatible con Laravel.
- Un servidor web como **Apache** o **Nginx**.

---

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/Arzival/passmaster.git
   cd passmaster
   ```

2. Instalar dependencias de PHP usando Composer:
   ```bash
   composer install
   ```

3. Configurar las variables de entorno:
   - Renombra el archivo `.env.example` a `.env`.
   - Actualiza los valores con tus credenciales de base de datos y configuración:

     ```env
     APP_NAME=PassMaster
     APP_ENV=local
     APP_KEY=base64:GENERATE_KEY_AQUI
     APP_DEBUG=true
     APP_URL=http://passmaster.test

     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=passmaster
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. Generar una clave de aplicación:
   ```bash
   php artisan key:generate
   ```

5. Ejecutar migraciones para crear las tablas necesarias en la base de datos:
   ```bash
   php artisan migrate
   ```

6. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

   El backend estará disponible en [http://localhost:8000](http://localhost:8000).

---

## Configuración

Este proyecto utiliza un archivo `.env` para manejar la configuración del entorno. Aquí algunos valores importantes:

- `APP_KEY`: La clave de aplicación generada automáticamente.
- `DB_*`: Configuración de la base de datos.
- `APP_URL`: URL del backend para asegurar que las rutas generadas sean correctas.

---

## Características

1. **Autenticación**:
   - Registro, inicio de sesión y autenticación mediante tokens API.

2. **Gestión de Contraseñas**:
   - Generar, guardar y recuperar contraseñas cifradas con una palabra secreta.

3. **Cifrado Seguro**:
   - Utiliza `AES-256-CBC` para cifrar contraseñas.

4. **Soporte para Multiplataforma**:
   - Acceso desde cualquier frontend conectado al backend.

---

## Estructura del Proyecto

```plaintext
├── app/
│   ├── Console/          # Comandos personalizados de Artisan
│   ├── Exceptions/       # Manejo de excepciones
│   ├── Http/
│   │   ├── Controllers/  # Controladores de las rutas
│   │   ├── Middleware/   # Middleware para manejar peticiones
│   │   └── Requests/     # Validaciones de solicitudes HTTP
│   ├── Models/           # Modelos Eloquent
│   └── Providers/        # Proveedores de servicios
├── database/
│   ├── migrations/       # Migraciones de la base de datos
│   ├── seeders/          # Seeders para datos de prueba
├── routes/
│   ├── api.php           # Rutas para el API
│   └── web.php           # Rutas para la web
├── storage/              # Archivos generados, logs, etc.
├── .env                  # Configuración del entorno
├── artisan               # Script principal de Artisan
├── composer.json         # Dependencias de PHP
└── phpunit.xml           # Configuración de pruebas
```

---

## API Endpoints

### Autenticación
- **POST /api/register**: Registrar un nuevo usuario.
- **POST /api/login**: Iniciar sesión y obtener un token de acceso.

### Contraseñas
- **POST /api/get-sistems**: Obtener el listado de los sistemas que registró el usuario.
- **POST /api/save-password**: Guardar el usuario y contraseña del sistema.
- **POST /api/register-secret-word**: Guardar la palabra secreta asociada al usuario.
- **POST /api/suggest-password**: Generar una contraseña segura.
- **POST /api/get-password**: Obtener una contraseña desencriptada.

---

## Contribución

1. Haz un **fork** del repositorio.
2. Crea una nueva rama:
   ```bash
   git checkout -b feature/nueva-funcionalidad
   ```
3. Realiza los cambios y haz un commit:
   ```bash
   git commit -m "Agrega nueva funcionalidad"
   ```
4. Haz un push a la rama:
   ```bash
   git push origin feature/nueva-funcionalidad
   ```
5. Abre un **Pull Request**.

---

Gracias por tu interés en contribuir a **PassMaster**.