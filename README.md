# 📝 Gestión de Tareas - Desafío Técnico Fullstack

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat&logo=vue.js&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)

Aplicación fullstack para gestionar tareas con **Laravel 10** (backend), **Vue 3** (frontend) y **Docker**. Incluye CRUD completo, relaciones de base de datos, filtros avanzados y una interfaz moderna.

---

## 🎯 Características

### Backend (Laravel)
- ✅ API RESTful con Resource Controllers
- ✅ Modelos con relaciones (1:N y N:M)
- ✅ Migraciones y seeders con datos de prueba
- ✅ Validación de requests personalizada
- ✅ Resources para transformación de datos
- ✅ Filtros por estado, prioridad y fechas
- ✅ CORS configurado para frontend

### Frontend (Vue.js)
- ✅ Vue 3 con Composition API
- ✅ Pinia para state management
- ✅ Rutas con Vue Router
- ✅ Componentes reutilizables
- ✅ Diseño responsive y moderno
- ✅ Filtros dinámicos en tiempo real
- ✅ Modales para crear/editar tareas
- ✅ Manejo global de errores

### Base de Datos
- ✅ MySQL 8.0 en Docker
- ✅ 3 tablas principales: `tareas`, `prioridades`, `etiquetas`
- ✅ Tabla pivote para relación N:M
- ✅ Datos de prueba precargados

---

## 🚀 Requisitos Previos

- **Docker** y **Docker Compose** instalados
- **Git** para clonar el repositorio
- Puertos **3306**, **8000** y **5173** disponibles

---

## 📦 Instalación Rápida

### 1. Clonar el repositorio

```bash
git clone <tu-repositorio>
cd flullstack_challenge
```

### 2. Configurar variables de entorno

```bash
# Backend
cp backend/.env.example backend/.env

# Frontend (ya está configurado en este proyecto)
# El archivo frontend/.env ya existe con VITE_API_URL=http://localhost:8000/api
```

### 3. Levantar el entorno con Docker

```bash
docker-compose up -d
```

Esto levantará 3 contenedores:
- **MySQL** → Puerto 3306
- **Backend (Laravel)** → Puerto 8000
- **Frontend (Vue)** → Puerto 5173

### 4. Configurar el backend

```bash
# Instalar dependencias de Laravel
docker-compose exec backend composer install

# Generar key de aplicación
docker-compose exec backend php artisan key:generate

# Ejecutar migraciones y seeders
docker-compose exec backend php artisan migrate:fresh --seed
```

### 5. Configurar el frontend

```bash
# Instalar dependencias de Vue
docker-compose exec frontend npm install
```

---

## 🎮 Uso de la Aplicación

### Acceder a la aplicación

- **Frontend**: [http://localhost:5173](http://localhost:5173)
- **Backend API**: [http://localhost:8000/api](http://localhost:8000/api)

### Endpoints de la API

#### Tareas

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/tareas` | Listar todas las tareas (con filtros opcionales) |
| GET | `/api/tareas/{id}` | Ver una tarea específica |
| POST | `/api/tareas` | Crear nueva tarea |
| PUT | `/api/tareas/{id}` | Actualizar tarea |
| DELETE | `/api/tareas/{id}` | Eliminar tarea |

#### Recursos auxiliares

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/prioridades` | Listar todas las prioridades |
| GET | `/api/etiquetas` | Listar todas las etiquetas |

### Filtros disponibles (Query Parameters)

```
GET /api/tareas?estado=pendiente
GET /api/tareas?prioridad_id=1
GET /api/tareas?fecha_desde=2024-01-01&fecha_hasta=2024-12-31
GET /api/tareas?estado=en_progreso&prioridad_id=3
```

### Ejemplo de request para crear tarea

```json
POST /api/tareas
Content-Type: application/json

{
  "titulo": "Nueva tarea",
  "descripcion": "Descripción detallada de la tarea",
  "estado": "pendiente",
  "fecha_vencimiento": "2024-12-31",
  "prioridad_id": 2,
  "etiquetas": [1, 2]
}
```

---

## 📁 Estructura del Proyecto

```
flullstack_challenge/
├── backend/                      # Laravel API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── TareaController.php
│   │   │   │   ├── PrioridadController.php
│   │   │   │   └── EtiquetaController.php
│   │   │   ├── Requests/
│   │   │   │   ├── StoreTareaRequest.php
│   │   │   │   └── UpdateTareaRequest.php
│   │   │   └── Resources/
│   │   │       ├── TareaResource.php
│   │   │       ├── PrioridadResource.php
│   │   │       └── EtiquetaResource.php
│   │   └── Models/
│   │       ├── Tarea.php
│   │       ├── Prioridad.php
│   │       └── Etiqueta.php
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── 2024_01_01_000001_create_prioridades_table.php
│   │   │   ├── 2024_01_01_000002_create_etiquetas_table.php
│   │   │   ├── 2024_01_01_000003_create_tareas_table.php
│   │   │   └── 2024_01_01_000004_create_etiqueta_tarea_table.php
│   │   └── seeders/
│   │       └── DatabaseSeeder.php
│   ├── routes/
│   │   └── api.php
│   ├── config/
│   │   └── cors.php
│   ├── Dockerfile
│   └── .env.example
│
├── frontend/                     # Vue.js SPA
│   ├── src/
│   │   ├── components/
│   │   │   ├── TareaCard.vue
│   │   │   └── TareaModal.vue
│   │   ├── views/
│   │   │   └── HomeView.vue
│   │   ├── stores/
│   │   │   └── tareas.js
│   │   ├── services/
│   │   │   └── api.js
│   │   ├── router/
│   │   │   └── index.js
│   │   ├── assets/
│   │   │   └── main.css
│   │   ├── App.vue
│   │   └── main.js
│   ├── Dockerfile
│   ├── package.json
│   ├── vite.config.js
│   └── .env
│
├── docker-compose.yml
├── .gitignore
└── README.md
```

---

## 🗄️ Esquema de Base de Datos

### Tabla: `prioridades`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT (PK) | Autoincremental |
| prioridad | ENUM | BAJA, MEDIA, ALTA |

### Tabla: `etiquetas`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT (PK) | Autoincremental |
| etiqueta | ENUM | DEV, QA, RRHH |

### Tabla: `tareas`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT (PK) | Autoincremental |
| titulo | VARCHAR | Título de la tarea |
| descripcion | TEXT | Descripción detallada |
| estado | ENUM | pendiente, en_progreso, completada |
| fecha_vencimiento | DATE | Fecha límite (nullable) |
| prioridad_id | INT (FK) | Relación con prioridades |

### Tabla: `etiqueta_tarea` (Pivote)
| Campo | Tipo | Descripción |
|-------|------|-------------|
| tarea_id | INT (FK) | Relación con tareas |
| etiqueta_id | INT (FK) | Relación con etiquetas |

---

## 🛠️ Comandos Útiles

### Docker

```bash
# Ver logs de todos los servicios
docker-compose logs -f

# Ver logs del backend
docker-compose logs -f backend

# Ver logs del frontend
docker-compose logs -f frontend

# Reiniciar servicios
docker-compose restart

# Detener servicios
docker-compose down

# Detener y eliminar volúmenes (⚠️ elimina la BD)
docker-compose down -v
```

### Laravel (Backend)

```bash
# Entrar al contenedor
docker-compose exec backend bash

# Refrescar base de datos
php artisan migrate:fresh --seed

# Crear nuevo modelo con migración
php artisan make:model NombreModelo -m

# Crear nuevo controller
php artisan make:controller NombreController --resource

# Ver rutas disponibles
php artisan route:list
```

### Vue (Frontend)

```bash
# Entrar al contenedor
docker-compose exec frontend sh

# Instalar nueva dependencia
npm install nombre-paquete

# Build de producción
npm run build
```

---

## 🎨 Características Adicionales (Bonus)

### ✅ Implementadas

1. **Diseño Visual Moderno**
   - CSS personalizado con variables CSS
   - Diseño responsive (mobile-first)
   - Paleta de colores consistente
   - Gradientes y sombras elegantes

2. **Manejo de Errores**
   - Interceptores de Axios
   - Mensajes de error en frontend
   - Validaciones en backend con Form Requests

3. **Validaciones**
   - Validación de formularios en tiempo real
   - Mensajes personalizados en español
   - Validación de datos en el backend

4. **Arquitectura en Capas**
   - Servicios API separados
   - Store de Pinia para estado global
   - Controllers con Resources en Laravel
   - Form Requests para validación

5. **Filtros Avanzados**
   - Filtro por estado
   - Filtro por prioridad
   - Filtro por rango de fechas
   - Combinación de múltiples filtros

### 🚀 Posibles Mejoras Futuras

- [ ] Autenticación con Laravel Sanctum
- [ ] Paginación en lista de tareas
- [ ] Búsqueda por texto
- [ ] Pruebas automatizadas (PHPUnit, Vitest)
- [ ] Notificaciones en tiempo real
- [ ] Drag & drop para reordenar tareas
- [ ] Exportar tareas a PDF/Excel
- [ ] Dashboard con estadísticas

---

## 🐛 Solución de Problemas

### Error: Puerto 3306 ya está en uso

Si tienes MySQL corriendo localmente:

```bash
# Windows
net stop mysql

# O cambiar el puerto en docker-compose.yml
ports:
  - "3307:3306"  # Usa el puerto 3307 en host
```

### Error: Frontend no se conecta al backend

Verifica que el archivo `frontend/.env` tenga:

```
VITE_API_URL=http://localhost:8000/api
```

Y reinicia el contenedor:

```bash
docker-compose restart frontend
```

### Error: Migraciones fallan

```bash
# Asegúrate de que MySQL esté listo
docker-compose exec backend php artisan migrate:fresh --seed
```

---

## 👨‍💻 Autor

Desarrollado como parte del desafío técnico fullstack.

---

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

---

## 🙏 Agradecimientos

Gracias por revisar este proyecto. Si tienes preguntas o sugerencias, no dudes en contactarme.

---

**¡Disfruta gestionando tus tareas! 🎉**
