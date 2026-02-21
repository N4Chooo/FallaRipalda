#  Proyecto Falla Ripalda Sogueros

Bienvenido al repositorio del proyecto. Esta aplicación es una "Falla" web que consta de una arquitectura con **Symfony** en el backend y **Angular** en el frontend, utilizando **Docker** para la gestión de la base de datos.

##  Tecnologías

* **Backend:** Symfony (PHP)
* **Frontend:** Angular (TypeScript)
* **Base de Datos:** MySQL / MariaDB
* **Infraestructura:** Docker & Docker Compose

---

##  Requisitos Previos

Asegúrate de tener instalado en tu máquina:

* [Git](https://git-scm.com/)
* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org/) (incluye NPM)
* [Docker Desktop](https://www.docker.com/products/docker-desktop)
* [Symfony CLI](https://symfony.com/download)
* [Angular CLI](https://angular.io/cli) (Instalar con `npm install -g @angular/cli`)

---

##  Guía de Instalación

Sigue estos pasos estrictamente en orden para configurar el entorno.

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DE_LA_CARPETA>

2. Instalar dependencias del Backend
Navega a la carpeta del servidor e instala las dependencias de PHP:

Bash
cd back
composer install
3. Instalar dependencias del Frontend
En una nueva terminal (o volviendo atrás), navega a la carpeta del cliente e instala las dependencias de Node:

Bash
cd ../front  # O desde la raíz: cd front
npm install

 Base de Datos y Docker
Para que la aplicación funcione, necesitamos levantar la base de datos y configurarla correctamente.

1. Levantar contenedores
Asegúrate de estar en la raíz del proyecto (o donde esté tu archivo docker-compose.yml) y ejecuta:

Bash
docker compose up -d
2. Configurar variables de entorno
Ve a la carpeta back. Renombra el archivo .env.example a .env.local o .env y configura la conexión a la base de datos para que coincida con la configuración de tu Docker:

Fragmento de código
# Ejemplo en back/.env
DATABASE_URL="mysql://usuario:password@127.0.0.1:3307/nombre_bbdd?serverVersion=..."
3. Crear la Base de Datos
Dentro de la carpeta back, ejecuta el siguiente comando para crear la base de datos vacía:

Bash
php bin/console doctrine:database:create

4. Importar y Actualizar el Esquema
Si tienes un archivo SQL para importar datos iniciales, importalos.

Una vez importada la base de datos, ejecuta el comando para forzar la actualización del esquema:

Bash
php bin/console doctrine:schema:update --dump-sql --force

 Ejecutar la Aplicación
Necesitarás dos terminales abiertas simultáneamente.

Terminal 1: Backend (Symfony)
Dentro de la carpeta back:

Bash
symfony serve
El backend se ejecutará generalmente en http://localhost:8000

Terminal 2: Frontend (Angular)
Dentro de la carpeta front:

Bash
ng serve
El frontend estará disponible en http://localhost:4200

 Solución de Problemas
Error de Puertos: Si Docker falla, asegúrate de que el puerto 3307 no esté siendo usado por otro servicio de MySQL local.
