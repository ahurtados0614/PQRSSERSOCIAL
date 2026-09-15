# Sistema PQRS

Sistema web para la gestión de **Peticiones, Quejas, Reclamos y Sugerencias (PQRS)**, desarrollado como parte de una prueba técnica para el cargo de **Analista de Desarrollo Tecnológico**.

La aplicación permite a los ciudadanos registrar y consultar sus PQRS mediante un código de seguimiento, mientras que los usuarios administrativos pueden gestionar, actualizar y responder las solicitudes.

---

## 📋 Descripción

El sistema tiene como objetivo centralizar el registro, seguimiento y gestión de PQRS, facilitando tanto la interacción del ciudadano como la administración interna de las solicitudes.

### Funcionalidades principales

* Registro público de PQRS.
* Generación automática de código único de seguimiento.
* Consulta pública del estado de una PQRS.
* Gestión administrativa de PQRS.
* Asignación de PQRS a usuarios administrativos.
* Actualización del estado de las solicitudes.
* Registro de respuesta.
* Cálculo de fecha límite de respuesta.
* Semaforización según el tiempo transcurrido y fecha límite.
* Priorización de solicitudes.
* Notificaciones por correo electrónico.
* API REST para consulta y gestión de PQRS.
* Validación de datos mediante Form Requests.
* Migraciones y seeders para facilitar la instalación.
* Pruebas automatizadas sobre funcionalidades principales.

---

# 📊 Etapa de análisis y diseño

Como parte del desarrollo de la solución se realizó una etapa inicial de **análisis, levantamiento de requerimientos y diseño**, con el propósito de comprender los requerimientos de la prueba técnica, organizar el trabajo y definir la estructura funcional y técnica del sistema.

Esta etapa permitió establecer la relación entre los requerimientos identificados, las historias de usuario, las tareas técnicas y los componentes necesarios para la implementación del sistema PQRS.

## 📋 Levantamiento de requerimientos y tablero de gestión

Para la planificación y seguimiento del desarrollo se utilizó un **tablero Kanban**, mediante el cual se organizaron las actividades correspondientes a las diferentes etapas del proyecto:

* Análisis de requerimientos.
* Diseño de la solución.
* Desarrollo.
* Integración.
* Pruebas.
* Documentación.
* Entrega final.

### Historial de ajustes del tablero Kanban

El tablero Kanban fue modificado progresivamente durante la etapa de análisis y planificación del proyecto. Los cambios realizados permitieron ajustar la estructura inicial del backlog a los requisitos establecidos en la prueba técnica, identificar las funcionalidades obligatorias, organizar las historias de usuario y diferenciar las actividades de análisis, desarrollo, integración, pruebas y entrega.

Estos ajustes hacen parte del proceso de refinamiento del proyecto y buscan mantener la **trazabilidad entre los requisitos de la prueba, las historias de usuario y las tareas técnicas necesarias para su implementación**.

**Tablero de gestión del proyecto:**

* [Tablero Fundación Sersocial IPS – PQRS](https://trello.com/invite/b/6aa436da1b1f284cabc19f95/ATTIabaa2b8900d097e91a924e24bb31ab5a5DCF3315/fundacion-sersocial-ips-pqrs)

---

## 🗄️ Diagrama Entidad-Relación (DER)

Como parte del diseño de la solución se elaboró un **Diagrama Entidad-Relación (DER)** para representar la estructura de datos del sistema, sus entidades principales y las relaciones existentes entre ellas.

El diagrama sirvió como referencia para definir la estructura de la base de datos y posteriormente implementar las migraciones de Laravel.

**Diagrama:**

* [Diagrama Entidad-Relación](https://lucid.app/lucidchart/cc00b79e-c76a-4b8a-bad1-97d075059ec1/edit?viewport_loc=-558%2C-1032%2C2510%2C1078%2C0_0&invitationId=inv_d1510c32-fc47-4373-b9ee-86a9af052ef0)

---

## 🔄 Diagrama de flujo del proceso

Se elaboró un diagrama de flujo para representar el proceso general de gestión de una PQRS, desde su registro por parte del ciudadano hasta las actividades de seguimiento, gestión, respuesta y cierre.

Este diagrama permite visualizar el flujo funcional del sistema y facilita la comprensión de las diferentes etapas por las que puede pasar una solicitud.

**Diagramas:**

* [Diagrama de flujo del proceso](https://lucid.app/lucidchart/faa769b3-31df-4994-b21d-330e75181a46/edit?viewport_loc=-1470%2C-290%2C2014%2C1078%2C0_0&invitationId=inv_391da0d8-0e35-4ef2-b98d-a53d182c8f81)
* [Diagrama de actores e interacción](https://lucid.app/lucidchart/faa769b3-31df-4994-b21d-330e75181a46/edit?viewport_loc=-114%2C301%2C1457%2C780%2C9kju9ZdyBcU4&invitationId=inv_391da0d8-0e35-4ef2-b98d-a53d182c8f81)

---

# 🛠️ Tecnologías utilizadas

* **PHP**
* **Laravel**
* **MySQL**
* **Blade**
* **Bootstrap 5**
* **JavaScript**
* **Vite**
* **REST API**
* **Postman**
* **Git / GitHub**

---

# 🏗️ Decisiones de arquitectura

Se implementa una arquitectura basada principalmente en el patrón **MVC (Model-View-Controller)** proporcionado por Laravel.

La solución busca mantener un equilibrio entre funcionalidad, claridad y facilidad de mantenimiento, evitando incorporar tecnologías o patrones innecesarios para el alcance de la prueba.

## Laravel

Laravel fue seleccionado porque proporciona:

* Arquitectura MVC.
* Sistema de rutas.
* Controladores.
* Eloquent ORM.
* Migraciones y seeders.
* Validación mediante Form Requests.
* Middleware y autenticación.
* Sistema de correo y notificaciones.
* Soporte para APIs REST.
* Herramientas para pruebas automatizadas.

## MySQL

MySQL se utiliza como motor de base de datos debido a que el sistema maneja información estructurada y relaciones entre entidades.

Entre sus principales ventajas para este proyecto se encuentran:

* Integridad referencial.
* Relaciones entre tablas.
* Índices.
* Buen rendimiento para este tipo de aplicación.
* Compatibilidad con Laravel.
* Facilidad de administración y despliegue.

## Organización de la aplicación

La aplicación utiliza:

* **Models:** representación y acceso a los datos.
* **Views:** interfaces desarrolladas con Blade y Bootstrap.
* **Controllers:** manejo del flujo de las solicitudes.
* **Form Requests:** validación de información recibida.
* **Services:** encapsulación de lógica de negocio cuando esta requiere reutilización o crecimiento.
* **API Resources:** estandarización de respuestas de la API.
* **Mail / Notifications:** envío de notificaciones relacionadas con cambios en las PQRS.
* **Constants:** definición centralizada de tipos y estados de las PQRS.

El criterio principal de arquitectura es mantener una solución **simple, mantenible, escalable y adecuada al alcance de la prueba técnica**.

---

# 📁 Estructura principal del proyecto

```text
app/
├── Constants/
│   ├── PqrsStatus.php
│   └── PqrsType.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── PqrsController.php
│   │   └── TrackingController.php
│   │
│   ├── Requests/
│   └── Resources/
│
├── Mail/
│
├── Models/
│   ├── Pqrs.php
│   └── User.php
│
└── Services/

database/
├── migrations/
└── seeders/

resources/
└── views/

routes/
├── api.php
└── web.php

tests/
├── Feature/
└── Unit/

docs/
├── MANUAL_INSTALACION.md
└── ...
```

---

# ⚙️ Requisitos

Antes de instalar el proyecto se debe contar con:

* PHP 8.2 o superior.
* Composer.
* MySQL.
* Node.js y npm.
* Git.
* Un servidor local compatible con PHP, por ejemplo:

  * XAMPP.
  * Laragon.
  * Laravel Herd.
  * Servidor PHP integrado.

---

# 📥 Instalación

## 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DEL_PROYECTO>
```

## 2. Instalar dependencias de PHP

```bash
composer install
```

## 3. Instalar dependencias de frontend

```bash
npm install
```

## 4. Crear archivo de configuración

Copiar el archivo `.env.example`:

```bash
cp .env.example .env
```

En Windows también puede realizarse manualmente copiando `.env.example` y renombrándolo como `.env`.

## 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

## 6. Configurar la base de datos

Crear una base de datos MySQL y configurar las variables correspondientes en el archivo `.env`.

Ejemplo:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pqrs
DB_USERNAME=root
DB_PASSWORD=
```

## 7. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Los seeders permiten crear los datos iniciales necesarios para realizar pruebas del sistema.

## 8. Compilar los recursos frontend

Para desarrollo:

```bash
npm run dev
```

Para generar los recursos de producción:

```bash
npm run build
```

## 9. Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

---

# 👤 Usuario administrativo

El proyecto incluye un usuario administrativo creado mediante los seeders.

Las credenciales de prueba deben consultarse en la configuración de los seeders o en el manual de instalación.

> **Importante:** Las credenciales incluidas son únicamente para el entorno de prueba y desarrollo.

---

# 🗃️ Base de datos

La entidad principal del sistema es `pqrs`.

Entre los principales datos almacenados se encuentran:

| Campo           | Descripción                      |
| --------------- | -------------------------------- |
| `id`            | Identificador interno            |
| `tracking_code` | Código único para seguimiento    |
| `type`          | Tipo de PQRS                     |
| `status`        | Estado actual                    |
| `name`          | Nombre del solicitante           |
| `email`         | Correo del solicitante           |
| `phone`         | Teléfono del solicitante         |
| `subject`       | Asunto                           |
| `description`   | Descripción de la solicitud      |
| `response`      | Respuesta de la entidad          |
| `assigned_to`   | Usuario administrativo encargado |
| `due_date`      | Fecha límite de respuesta        |
| `responded_at`  | Fecha de respuesta               |
| `created_at`    | Fecha de creación                |
| `updated_at`    | Fecha de actualización           |

Las estructuras de base de datos se gestionan mediante **migrations**, permitiendo reproducir la estructura de la aplicación en diferentes entornos.

---

# 🔎 Seguimiento de PQRS

Cada PQRS registrada obtiene automáticamente un **código único de seguimiento**.

Este código permite al ciudadano consultar públicamente información relacionada con su solicitud, incluyendo:

* Código de seguimiento.
* Tipo de PQRS.
* Estado actual.
* Fecha de registro.
* Fecha límite de respuesta.
* Información de respuesta cuando corresponda.

El seguimiento no requiere acceso al panel administrativo.

---

# 🚦 Semaforización y prioridad

El sistema incorpora un mecanismo de semaforización para facilitar la identificación visual de las PQRS según el tiempo disponible para su atención.

La prioridad se determina considerando principalmente:

* Fecha de creación.
* Fecha límite de respuesta.
* Estado actual.
* Tiempo restante para atender la solicitud.

Las PQRS con mayor urgencia deben visualizarse primero en el panel administrativo.

La regla exacta de cálculo y clasificación se encuentra implementada de acuerdo con los requisitos establecidos para la prueba técnica.

---

# 📧 Notificaciones por correo

Cuando una PQRS es gestionada y su estado es actualizado, el sistema puede enviar una notificación al correo electrónico registrado por el ciudadano.

La notificación permite informar sobre cambios relevantes relacionados con la solicitud, especialmente:

* Cambio de estado.
* Respuesta registrada.
* Finalización de la gestión.

Para utilizar el envío de correos se deben configurar correctamente las variables SMTP en el archivo `.env`.

Ejemplo:

```env
MAIL_MAILER=smtp
MAIL_HOST=<SERVIDOR_SMTP>
MAIL_PORT=<PUERTO>
MAIL_USERNAME=<USUARIO>
MAIL_PASSWORD=<CONTRASEÑA>
MAIL_ENCRYPTION=<ENCRYPTION>
MAIL_FROM_ADDRESS=<CORREO>
MAIL_FROM_NAME="${APP_NAME}"
```

---

# 🔌 API REST

El sistema dispone de endpoints REST para facilitar la integración con otros sistemas.

## Crear una PQRS

```http
POST /api/pqrs
```

Permite registrar una nueva PQRS mediante la API.

## Consultar una PQRS

```http
GET /api/pqrs/{tracking_code}
```

Permite consultar una PQRS utilizando su código de seguimiento.

## Listar PQRS

```http
GET /api/pqrs
```

Permite consultar las PQRS disponibles según las reglas de acceso implementadas.

## Actualizar estado

```http
PATCH /api/pqrs/{id}/status
```

Permite actualizar el estado de una PQRS.

Las respuestas de la API utilizan una estructura JSON consistente mediante **API Resources**.

---

# 📮 Postman

La colección de Postman se encuentra dentro del proyecto y contiene las solicitudes necesarias para probar los principales endpoints de la API.

Ubicación:

```text
postman/
└── PQRS.postman_collection.json
```

La colección utiliza una variable para facilitar el cambio entre ambientes:

```text
{{base_url}}
```

Ejemplo:

```text
{{base_url}}/api/pqrs
```

Para realizar las pruebas:

1. Importar la colección en Postman.
2. Configurar `base_url`.
3. Ejecutar las solicitudes disponibles.
4. Verificar códigos HTTP y respuestas JSON.

---

# 🧪 Pruebas

El proyecto incluye pruebas automatizadas para validar las funcionalidades principales.

Las pruebas se encuentran organizadas principalmente en:

```text
tests/
├── Feature/
└── Unit/
```

Para ejecutar las pruebas:

```bash
php artisan test
```

También es posible ejecutar:

```bash
vendor/bin/phpunit
```

Las pruebas contemplan, entre otros aspectos:

* Registro de PQRS.
* Validación de información.
* Generación del código de seguimiento.
* Consulta pública.
* Cálculo de fecha límite.
* Acceso administrativo.
* Actualización de estados.
* Funcionamiento de endpoints API.

---

# 🔐 Seguridad

Se aplican diferentes mecanismos proporcionados por Laravel para proteger la aplicación:

* Validación de datos de entrada.
* Autenticación para el panel administrativo.
* Middleware para proteger rutas administrativas.
* Protección CSRF en formularios web.
* Uso de Eloquent ORM para interacción con la base de datos.
* Variables sensibles almacenadas mediante `.env`.
* Restricción de acceso a funcionalidades administrativas.
* Validación de datos recibidos por la API.

Las credenciales y configuraciones sensibles no deben almacenarse directamente en el repositorio.

---

# 📚 Documentación adicional

La documentación complementaria se encuentra en la carpeta:

```text
docs/
```

Actualmente contempla:

```text
docs/
└── MANUAL_INSTALACION.md
```

El manual de instalación contiene información adicional para configurar y ejecutar el proyecto en un entorno local.

---

# 🌱 Seeders

Los seeders permiten generar información inicial para facilitar las pruebas del sistema.

Para ejecutar nuevamente la base de datos con los datos de prueba:

```bash
php artisan migrate:fresh --seed
```

> Este comando elimina las tablas existentes y vuelve a ejecutar todas las migraciones y seeders. Debe utilizarse únicamente en ambientes de desarrollo o prueba.

---

# 🧹 Código y mantenimiento

El proyecto busca mantener una estructura organizada y fácil de comprender.

Se siguen principalmente los siguientes criterios:

* Separación de responsabilidades.
* Reutilización de componentes.
* Validaciones fuera de los controladores cuando corresponde.
* Uso de constantes para valores definidos del dominio.
* Uso de relaciones Eloquent.
* Controladores enfocados en coordinar las operaciones.
* Evitar duplicación de lógica.
* Mantener una estructura sencilla acorde con el alcance del proyecto.

---

# 🚀 Ejecución rápida

Después de realizar la configuración inicial, los comandos principales para trabajar con el proyecto son:

```bash
php artisan serve
```

En otra terminal:

```bash
npm run dev
```

Para ejecutar las pruebas:

```bash
php artisan test
```

---

# 📦 Entrega del proyecto

La entrega contempla:

* Código fuente.
* Migraciones.
* Seeders.
* Modelos.
* Controladores.
* Vistas.
* API REST.
* Colección Postman.
* Pruebas automatizadas.
* Manual de instalación.
* Documentación técnica.
* README.
* Evidencias de análisis y diseño.

---

# 📄 Licencia

Este proyecto fue desarrollado con fines académicos y de evaluación técnica.

---

# 👨‍💻 Autor

**Proyecto desarrollado como parte de una prueba técnica para el cargo de Analista de Desarrollo Tecnológico.**
