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
- ✅ Filtros por estado, prioridad, etiquetas y fechas

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
- Puertos **3306**, **8000**, **5173** y **8080** disponibles

---

## 📦 Instalación Rápida

### 1. Clonar el repositorio

```bash
git clone https://github.com/Yosecc/fullstack_challenge
cd flullstack_challenge
```

### 2. Configurar variables de entorno

```bash
# Backend
cp backend/.env.example backend/.env

# Credenciales de base de datos
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tareas_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 3. Levantar el entorno con Docker

```bash
docker-compose up --build
```

Esto levantará 4 contenedores:
- **MySQL** → Puerto 3306
- **Backend (Laravel)** → Puerto 8000 (se configura automáticamente)
- **Frontend (Vue)** → Puerto 5173
- **Adminer** → Puerto 8080

---

## 🎮 Uso de la Aplicación

### Acceder a la aplicación

- **Frontend**: [http://localhost:5173](http://localhost:5173)
- **Backend API**: [http://localhost:8000/api](http://localhost:8000/api)
- **Adminer (Base de Datos)**: [http://localhost:8080](http://localhost:8080)

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

## 🎨 Características Adicionales (Bonus)

### ✅ Implementadas

1. **Diseño Visual Moderno**
   - Tailwind CSS v3.4 para estilosUtilIty-first
   - Diseño responsive (mobile-first)
   - Paleta de colores consistente
   - Componentes estilizados con clases de Tailwind

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



---


