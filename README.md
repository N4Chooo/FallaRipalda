#  Proyecto Falla Ripalda Sogueros

Bienvenido al repositorio del proyecto. Esta aplicación es una "Falla" web que consta de una arquitectura con **Symfony** en el backend y **Angular** en el frontend, utilizando **Docker** para la gestión de la base de datos.

### WEB FUNCIONAL:
<img width="450" height="450" alt="image" src="https://github.com/user-attachments/assets/a7b290fc-aeed-4305-931a-a8b5e637820d" />
## falla-ripalda.vercel.app

### INSTRUCCIONES PARA USAR LA APP LOCAL

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

# 1. Clonar el repositorio
<pre>
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DE_LA_CARPETA>
</pre>

#  2. Instalar dependencias del Backend
Navega a la carpeta del servidor e instala las dependencias de PHP:

<pre>
cd back
composer install
</pre>

# 3. Instalar dependencias del Frontend
En una nueva terminal (o volviendo atrás), navega a la carpeta del cliente e instala las dependencias de Node:

<pre>
cd ../front  # O desde la raíz: cd front
npm install
</pre>

# 4. Base de Datos y Docker:
El backend y la bbdd han sido desplegadas y ya esta todo configurado.


# 5. Ejecutar la Aplicación
Necesitarás una terminal abierta.


###  5.2 Terminal : Frontend (Angular)
Dentro de la carpeta front:

<pre>
ng serve
</pre>
El frontend estará disponible en http://localhost:4200



# 6. Solución de Problemas
Contacta con cualquier integrante para solucionar errores
