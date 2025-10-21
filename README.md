# conserflow.ERP
# ConserFlow.ERP

Sistema de gestión empresarial (ERP) desarrollado con **Laravel 12**, **Vue 3**, **Vite** y **MySQL**.  
Permite a los usuarios crear solicitudes internas (vacaciones, soporte técnico, materiales) y administrarlas desde un panel de control.

---

## Tecnologías

- PHP 8.1+
- Laravel 12
- Vue.js 3 + Vite
- MySQL 8+
- XAMPP
- Composer
- Axios
- Git

---

## Requisitos del sistema

- **XAMPP** con:
  - PHP 8.1+
  - MySQL activo
  - phpMyAdmin disponible
- **Node.js** 16+ y npm o Yarn
- **Composer**
- **Git**

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/germer-bit/conserflow.ERP.git
cd conserflow.ERP

#Importar el archivo SQL
#Base de datos ya lista para usarse en la raiz del proyecto
#se encuentra el archivo conserflow.ERP ahi se encuentra toda la información
#para que funcione la aplicación

Usando phpMyAdmin


Selecciona la base de datos recién creada.

Ve a la pestaña Importar.

Presiona Elegir archivo y selecciona conserflow.ERP.sql.

Haz clic en Ir.

Esto cargará todas las tablas y datos en la base.


##Intalación de dependencias
npm install 

#Migrar base datos
php artisan migrate

#Correr servicio
composer run dev

#Datos de prueba
en 
databese/seeders/UsersTableSeeder.php
encontrara los datos para ingresar, datos de prueba
