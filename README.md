# 🏛️ Sistema de Gestión de PQR — Fundación Sersocial IPS

Sistema web y API REST para la gestión integral de **Peticiones, Quejas, Reclamos y Sugerencias (PQR)**, desarrollado como prueba práctica para el cargo de **Analista de Desarrollo Tecnológico** en la Fundación Sersocial IPS.

> 📢 **Aclaración sobre el Stack Tecnológico**
>
> De acuerdo con la autorización previa del equipo evaluador / reclutador, la solución fue implementada utilizando **PHP 8.3 / Laravel 13 / Jetstream / Livewire 3 / MySQL / Tailwind CSS**, en reemplazo del stack Python/Django sugerido inicialmente en el documento de la prueba, dando cumplimiento a la totalidad del alcance funcional, arquitectura, pruebas y entregables requeridos.

---

## 🔗 Enlaces Rápidos a Entregables Obligatorios

| Entregable | Enlace |
|:---|:---|
| 📦 **Repositorio GitHub** | [PQRSSERSOCIAL](https://github.com/ahurtados0614/PQRSSERSOCIAL) |
| 📋 **Tablero Kanban** | [Trello — Fundación Sersocial IPS – PQR](https://trello.com/invite/b/6aa436da1b1f284cabc19f95/ATTIabaa2b8900d097e91a924e24bb31ab5a5DCF3315/fundacion-sersocial-ips-pqrs) |
| 🗄️ **Diagrama Entidad-Relación (DER)** | [Modelo DER en Lucidchart](https://lucid.app/lucidchart/cc00b79e-c76a-4b8a-bad1-97d075059ec1/edit?viewport_loc=-558%2C-1032%2C2510%2C1078%2C0_0&invitationId=inv_d1510c32-fc47-4373-b9ee-86a9af052ef0) |
| 🔄 **Diagrama de Flujo del Proceso** | [Flujo PQR en Lucidchart](https://lucid.app/lucidchart/faa769b3-31df-4994-b21d-330e75181a46/edit?viewport_loc=-1470%2C-290%2C2014%2C1078%2C0_0&invitationId=inv_391da0d8-0e35-4ef2-b98d-a53d182c8f81) |
| 👥 **Diagrama de Actores e Interacción** | [Actores en Lucidchart](https://lucid.app/lucidchart/faa769b3-31df-4994-b21d-330e75181a46/edit?viewport_loc=-114%2C301%2C1457%2C780%2C9kju9ZdyBcU4&invitationId=inv_391da0d8-0e35-4ef2-b98d-a53d182c8f81) |
| 🔌 **Colección Postman** | `postman/PQR.postman_collection.json` |

---

## ⭐ Tabla de Cumplimiento de Bonificaciones Extra (+35 Pts)

| Criterio Bonus | Estado | Detalle de la Implementación | Puntos |
|:---|:---:|:---|:---:|
| **Autenticación y Roles** | ✅ Completado | Control de acceso y sesiones mediante **Laravel Jetstream y Sanctum**. Separación de vistas y permisos para la administración. | **+10** |
| **Despliegue Documentado** | ✅ Completado | Guía paso a paso para servidor Linux/VPS con **Nginx + PHP 8.3-FPM**, sirviendo directamente el directorio `/public`. | **+5** |
| **Calidad Extra** | ✅ Completado | Pruebas automatizadas con **PHPUnit**, Seeders con datos demo y **Colección Postman** lista para importar. | **+5** |
| **API Externa / Integración** | ✅ Completado | Integración de servicio de **notificaciones por correo (SMTP)** para confirmaciones de radicado y avisos de gestión. | **+5** |
| **Uso Transparente de IA** | ✅ Completado | Declaración explícita sobre el uso de herramientas de IA y su alcance técnico en el proyecto. | **+10** |

**Total de bonificaciones adicionales: +35 puntos**

---

## 📋 Resumen del Sistema y Funcionalidades

El sistema cubre la totalidad del MVP exigido en la prueba técnica.

### Funcionalidades principales

- 📝 **Registro Público de PQR:** creación de solicitudes con asignación automática de código de radicado.
- 🔎 **Consulta por Radicado:** buscador público para verificar el estado de una PQR.
- 🖥️ **Panel de Administración:** listado con filtros por tipo, estado y prioridad, detalle de solicitud, gestión de estado y módulo de estadísticas.
- 🕐 **Historial de Seguimiento:** comentarios y trazabilidad de cambios de estado.
- ➕ **Agregados de Valor:** cálculo automático de fechas límite de respuesta, semaforización visual de vencimiento y asignación de agentes responsables.

---

# 🛠️ Tecnologías Utilizadas

| Tecnología | Versión / Implementación |
|:---|:---|
| **PHP** | 8.3 |
| **Framework Backend** | Laravel 13.17 |
| **Autenticación y UI** | Laravel Jetstream 5.5 + Livewire 3.6 |
| **Base de Datos** | MySQL 8.0 |
| **Servidor Web** | Nginx + PHP 8.3-FPM |
| **Pruebas Automatizadas** | PHPUnit 12.5 |
| **Estilos & Asset Bundling** | Tailwind CSS + Vite |
| **Herramientas de Integración** | Postman |

---

# 🏗️ Decisiones de Arquitectura

Se adoptó una arquitectura basada en **MVC (Modelo-Vista-Controlador)**, complementada con una capa de **Services** y **Form Requests** para separar responsabilidades y mantener una estructura organizada.

### Componentes principales

1. **Modelos y Persistencia — `app/Models/`**

   Definición de las entidades `Pqrs`, `Seguimientos`, `Solicitantes`, `Roles` y `User`, utilizando relaciones de Eloquent.

2. **Validación de Datos — `app/Http/Requests/`**

   Encapsulamiento de las reglas de validación para mantenerlas aisladas de los controladores.

3. **Capa de Servicios — `app/Services/`**

   Centralización de lógica de negocio reutilizable, incluyendo envío de correos y operaciones transaccionales.

4. **Formateo de API — `app/Http/Resources/`**

   Estandarización de las respuestas JSON de los endpoints de la API REST.

5. **Constantes y Enums — `app/Constants/`**

   Centralización de estados y tipos de PQR para facilitar el mantenimiento y evitar valores repetidos.

---

# 📁 Estructura del Proyecto

```text
PQRSSERSOCIAL/
   └──pqr/
      │
      ├── app/
      │   ├── Constants/          # Definición de estados y tipos
      │   ├── Http/
      │   │   ├── Controllers/    # Controladores Web y API REST
      │   │   ├── Requests/       # Validaciones (Form Requests)
      │   │   └── Resources/      # Formateadores JSON de API
      │   ├── Models/             # Modelos (Pqrs, Tracking, User, etc.)
      │   └── Services/           # Servicios (correo, gestión, etc.)
      │
      ├── database/
      │   ├── factories/          # Factorías de datos de prueba
      │   ├── migrations/         # Migraciones de base de datos
      │   └── seeders/            # Seeders de base de datos
      │
      ├── postman/
      │   └── PQR.postman_collection.json
      │
      ├── public/                 # Punto de entrada de la aplicación
      ├── resources/
      │   └── views/              # Vistas Blade / componentes Livewire
      ├── routes/
      │   ├── api.php             # Endpoints de la API
      │   └── web.php             # Rutas del panel web y cliente
      └── tests/                  
            └──Feature            # Pruebas automatizadas
```

---

# ⚙️ Requisitos Mínimos del Servidor

Antes de realizar el despliegue, el servidor debe contar con los siguientes componentes:

| Componente | Requisito |
|:---|:---|
| **PHP** | 8.3 con extensiones `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl` y `fpm` |
| **Servidor Web** | Nginx 1.18+ |
| **Base de Datos** | MySQL 8.0+ / MariaDB 10.5+ |
| **Composer** | 2.x |
| **Node.js** | v18+ |
| **NPM** | v9+ |
| **Control de versiones** | Git |

---

# 🚀 Despliegue en Servidor / Entorno de Producción

Sigue el siguiente procedimiento para clonar y levantar la aplicación en un servidor Linux.

## 1. Clonar el repositorio

Clonar la rama `main` dentro del directorio web del servidor:

```bash
cd /var/www/html/laravel/PQRSSERSOCIAL

git clone -b main https://github.com/ahurtados0614/PQRSSERSOCIAL.git pqrs

cd pqrs
```

---

## 2. Instalar dependencias de PHP

```bash
composer install
```

Para un entorno de producción se recomienda:

```bash
composer install --no-dev --optimize-autoloader
```

---

## 3. Configurar las variables de entorno

Crear el archivo `.env` a partir del archivo de ejemplo:

```bash
cp .env.example .env
```

Generar la clave de aplicación:

```bash
php artisan key:generate
```

Configurar los datos de conexión a la base de datos:

```env
APP_URL=tu_url_configurada_en_hots

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pqrs_db
DB_USERNAME=tu_usuario_db
DB_PASSWORD=tu_password_db

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo
MAIL_PASSWORD=tu_pasword_gmail_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_correo
MAIL_FROM_NAME="${APP_NAME}"
```

También se deben configurar las variables correspondientes al entorno de producción, correo electrónico y demás servicios utilizados por la aplicación.

---

## 4. Compilar los recursos Frontend

Instalar las dependencias de Node.js:

```bash
npm install
```

Compilar los recursos para producción:

```bash
npm run build
```

---

## 5. Inicializar la base de datos

Ejecutar las migraciones y seeders:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ **Nota:** `migrate:fresh` elimina todas las tablas existentes de la base de datos. Debe utilizarse únicamente cuando se desea reconstruir completamente la base de datos, por ejemplo durante una instalación inicial o entorno de pruebas.
>
> Para una actualización de una instalación existente, utilizar:
>
> ```bash
> php artisan migrate --force
> ```

---

## 6. Configurar permisos

Garantizar que el usuario del servidor web tenga permisos de escritura sobre los directorios requeridos:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 7. Crear el enlace de almacenamiento

Si la aplicación utiliza archivos almacenados públicamente:

```bash
php artisan storage:link
```

---

## 8. Optimizar la aplicación

Para producción:

```bash
php artisan optimize
```

---

# 👤 Usuarios y Credenciales Demo

Al ejecutar:

```bash
php artisan migrate:fresh --seed
```

el sistema registra automáticamente los siguientes usuarios de prueba:

| Rol | ID | Nombre | Correo electrónico | Contraseña |
|:---|:---:|:---|:---|:---|
| Administrador | 1 | Administrador | `admin@example.com` | `12345678` |
| Gestor PQRS | 2 | Gestor PQRS | `gestor@example.com` | `12345678` |
| Supervisor PQRS | 3 | Supervisor PQRS | `supervisor@example.com` | `12345678` |

> 🔐 **Recomendación:** las credenciales anteriores corresponden exclusivamente a datos demo. En un entorno productivo deben reemplazarse inmediatamente.

---

# 🌐 Configuración del Servidor Nginx

La aplicación debe ser servida desde el directorio `public` de Laravel.

Archivo de configuración:

```text
/etc/nginx/sites-available/pqrs
```

Configuración:

```nginx
server {
    listen 80;
    server_name pqrs.test;

    root /var/www/html/laravel/PQRSSERSOCIAL/pqrs/public;
    index index.php index.html;

    access_log /var/log/nginx/pqrs.access.log;
    error_log /var/log/nginx/pqrs.error.log;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTP_PROXY "";

        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;

        fastcgi_read_timeout 60s;
    }

    location ~ /\. {
        deny all;
    }
}
```

### Habilitar el sitio

Crear el enlace simbólico:

```bash
sudo ln -s /etc/nginx/sites-available/pqrs /etc/nginx/sites-enabled/pqrs
```

Validar la configuración:

```bash
sudo nginx -t
```

Si la configuración es correcta:

```bash
sudo systemctl reload nginx
```

Reiniciar PHP-FPM cuando sea necesario:

```bash
sudo systemctl restart php8.3-fpm
```

### Configuración del dominio local

Para realizar pruebas utilizando `pqrs.test`, agregar al archivo `/etc/hosts`:

```text
127.0.0.1 pqrs.test
```

---

# 🔌 API REST

La aplicación dispone de una API REST para la consulta y gestión de las PQR.

## Endpoints disponibles

| Método | Endpoint | Descripción |
|:---:|:---|:---|
| `GET` | `/api/pqr` | Listar PQR con filtros (`type`, `status`, `priority`) |
| `POST` | `/api/pqr` | Crear una nueva PQR |
| `GET` | `/api/pqr/{id}` | Ver detalle de una PQR |
| `PATCH` | `/api/pqr/{id}/estado` | Cambiar estado / prioridad |
| `POST` | `/api/pqr/{id}/seguimiento` | Agregar entrada de seguimiento |
| `GET` | `/api/pqr/{id}/seguimiento` | Obtener historial de seguimiento |
| `GET` | `/api/pqr/buscar?radicado={num}` | Consulta pública por número de radicado |

---

# 📮 Colección Postman

El proyecto incluye una colección de Postman para facilitar las pruebas de la API.

La colección se encuentra en:

```text
postman/PQR.postman_collection.json
```

### Importar la colección

1. Abrir **Postman**.
2. Seleccionar **Import**.
3. Importar el archivo:

```text
postman/PQR.postman_collection.json
```
[CLIC AQUI para ir al enlace del workspace de POSTMAN](https://www.postman.com/altimetry-pilot-53501146-s-team/fundacin-sersocial-ips-pqrs/request/fjte5el/obtener-csrf?sideView=agentMode) 

4. Configurar la variable de entorno:

```text
{{base_url}}
```

Por ejemplo:

```text
http://pqrs.test
```

o:

```text
http://127.0.0.1:8000
```

5. Ejecutar las solicitudes disponibles para validar los endpoints de la API.

---

# 🧪 Pruebas Automatizadas

El proyecto cuenta con suites de pruebas unitarias y de integración para verificar el funcionamiento del sistema.

## Ejecutar todas las pruebas

```bash
php artisan test
```
## Ejecutar prueba de manera individual (únicamente la clase de prueba especificada)

#### Registrar una nueva PQR
```bash
php artisan test --filter=PqrTest
```
#### Rastreo PQR por No. Radicado
```bash
php artisan test --filter=PqrTrackingTest
```
#### listado filtrado de PQRs
```bash
php artisan test --filter=PqrIndexTest
```
#### listado de PQRs por tipo
```bash
php artisan test --filter=PqrStatByTypeTest
```
#### listado de PQRs por estado y mes del año actual
```bash
php artisan test --filter=PqrStatByStatusTest
```
## Funcionalidades evaluadas

- ✅ Registro de PQR y asignación de código único de radicado.
- ✅ Validaciones de entrada mediante Form Requests.
- ✅ Validación de campos requeridos y correos electrónicos.
- ✅ Consulta del estado de una PQR mediante el número de radicado.
- ✅ Transición de estados.
- ✅ Registro de entradas en la traza de seguimiento.
- ✅ Respuestas en formato JSON de la API RESTful.

---

# 🤖 Declaración sobre el Uso de Inteligencia Artificial (IA)

En cumplimiento con el requisito de transparencia establecido para la evaluación, se declara el uso de herramientas de inteligencia artificial como apoyo durante el desarrollo del proyecto.

### Herramientas utilizadas

- **ChatGPT**
- **Gemini**

### Alcance de su utilización

**🎨 Ajustes de UI**

Apoyo en la maquetación de vistas adaptativas y estilizado mediante Tailwind CSS y componentes Blade.

**⚙️ Optimización Backend**

Recomendaciones relacionadas con la estructuración de consultas mediante Eloquent ORM y formateo de respuestas mediante API Resources.

**📚 Documentación Técnica**

Apoyo en la organización y formateo del archivo `README.md`, así como en la estructuración del flujo de despliegue mediante Nginx.

> La implementación, integración, validación y toma de decisiones técnicas sobre el proyecto corresponden al desarrollador.

---

# 👨‍💻 Autor

Proyecto desarrollado para la evaluación técnica del cargo de:

**Analista de Desarrollo Tecnológico**  
**Fundación Sersocial IPS**

---

<div align="center">

**🏛️ Sistema de Gestión de PQR — Fundación Sersocial IPS**

</div>