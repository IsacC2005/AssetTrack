# AssetTrack: Gestión de Activos de Precisión

![AssetTrack Banner](https://foto.png)

**AssetTrack** es una plataforma de código abierto diseñada para el control total de los activos de una empresa. Desarrollada con Laravel y Filament, ofrece una interfaz administrativa de alta fidelidad para gestionar infraestructura, personal y mantenimiento con precisión quirúrgica.

---

## 🚀 Funcionalidades Principales

* **Gestión de Inventario:** Registro detallado de equipos (computadoras, teléfonos, vehículos, etc.).
* **Estructura Organizativa:** Control de departamentos y empleados.
* **Asignaciones Inteligentes:** Vinculación directa de activos a empleados responsables.
* **Mantenimiento Preventivo:** Configuración de frecuencias de mantenimiento por dispositivo.
* **Control de Costos y Rentabilidad:** Cálculo automático basado en el valor de adquisición del equipo.
* **Flujo de aprobación:** El técnico cotiza, el administrador aprueba.
* **Lógica de Descarte:** Si el costo del mantenimiento supera el valor del equipo, el sistema sugiere su baja/desecho.
* **Ciclo de Vida:** Gestión de equipos obsoletos por antigüedad.


## 🛠️ Stack Tecnológico

* **Framework:** Laravel 10+
* **Panel Administrativo:** Filament V3
* **Base de Datos:** MySQL / PostgreSQL
* **Estilos:** Tailwind CSS

---

## 💻 Instalación

1. **Clonar el repositorio:**

```bash
https://github.com/IsacC2005/AssetTrack/
cd AssetTrack
```

2. **Instalar dependencias:**

```bash
composer install
npm install && npm run build
```

3. **Configurar el entorno:**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Ejecutar migraciones y seeders:**

```bash
php artisan migrate --seed
```

5. **Configurar shield:**

```bash
php artisan shield:setup
```

6. **Acceder al panel:** Sirve el proyecto y entra a http://localhost:8000/admin.

---

## 📋 Flujo de Mantenimiento (Lógica de Negocio)

* **Programación:** El sistema detecta equipos que requieren revisión según su frecuencia.
* **Asignación:** Un administrador asigna la tarea a un empleado de mantenimiento.
* **Cotización:** El técnico ingresa el costo estimado del servicio.
* **Validación de Rentabilidad:** Si **Costo Mantenimiento** < **Precio del Equipo**: Se procede a aprobación. Si **Costo Mantenimiento** > **Precio del Equipo**: El sistema bloquea el proceso y recomienda desechar el activo.

### 📄 Licencia
Este proyecto es de código abierto bajo la licencia MIT.