# DataCare Solutions – Servicios Web (REST + SOAP)

Este proyecto implementa un sistema de Servicios Web usando Laravel 12, combinando:

- API REST (JSON)
- Servicio SOAP (XML + WSDL)
- Base de datos MySQL
- Cliente SOAP en PHP
- Panel administrativo (Filament)

El objetivo es demostrar la integración real de múltiples tecnologías de servicios web, tal como se solicita en un examen práctico integral.

---

## 1️⃣ Requisitos del sistema

Antes de iniciar, el sistema debe contar con:

- Linux (recomendado Arch / Ubuntu)
- PHP ≥ 8.2 (probado con PHP 8.4)
- Composer
- MySQL o MariaDB

### Extensiones PHP requeridas:

- `pdo`
- `pdo_mysql`
- `soap`
- `fileinfo`

### Verificar extensiones:

```bash
php -m | grep -E "pdo|mysql|soap|fileinfo"
```

---

## 2️⃣ Clonar o preparar el proyecto

Ubicarse en el directorio de trabajo:

```bash
cd ~/Documents
```

*(En tu caso real puede variar)*

### Si es desde repositorio:

```bash
git clone <url-del-repo>
cd datacare-solutions
```

### Si ya tenés el proyecto:

```bash
cd datacare-solutions
```

---

## 3️⃣ Instalar dependencias

```bash
composer install
```

Si Composer no está instalado:

```bash
sudo pacman -S composer
```

---

## 4️⃣ Configuración del entorno

### Copiar el archivo de entorno:

```bash
cp .env.example .env
```

### Generar la clave de la aplicación:

```bash
php artisan key:generate
```

### Editar .env:

```bash
micro .env
```

### Configuración mínima requerida:

```env
APP_NAME="DataCare Solutions"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=datacare
DB_USERNAME=datacare
DB_PASSWORD=SuperSeguro123!
```

---

## 5️⃣ Base de datos

### Crear la base de datos en MySQL:

```sql
CREATE DATABASE datacare;
```

### Ejecutar migraciones:

```bash
php artisan migrate
```

### (Opcional) Poblar datos de prueba:

```bash
php artisan db:seed
```

---

## 6️⃣ Limpiar cachés

*(importante en Laravel 12)*

```bash
php artisan optimize:clear
php artisan config:clear
```

---

## 7️⃣ Iniciar el servidor

```bash
php artisan serve
```

Servidor disponible en: `http://127.0.0.1:8000`

---

## 8️⃣ Verificación de rutas

Verificar que las rutas REST y SOAP estén activas:

```bash
php artisan route:list
```

Deberías ver:
- `api/patients`
- `soap/patients`

---

## 9️⃣ Probar el servicio SOAP (WSDL)

### Verificar el WSDL:

```bash
curl http://127.0.0.1:8000/soap/patients?wsdl
```

Debe devolver un XML con:
- `definitions`
- `portType`
- `binding`
- `service`

Si ves eso → **SOAP activo**.

---

## 🔟 Probar SOAP vía CURL

```bash
curl -X POST http://127.0.0.1:8000/soap/patients \
  -H "Content-Type: text/xml; charset=utf-8" \
  -H "SOAPAction: getPatients" \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tns="http://datacare.test/soap/patients">
  <soapenv:Body>
    <tns:getPatients/>
  </soapenv:Body>
</soapenv:Envelope>'
```

### Respuesta esperada:

```xml
<patients>
  <patients>Nombre Paciente 1</patients>
  <patients>Nombre Paciente 2</patients>
</patients>
```

---

## 1️⃣1️⃣ Cliente SOAP en PHP

### Ejecución:

```bash
php client-soap.php
```

### Salida esperada:

```
stdClass Object
(
    [patients] => Array
        (
            [0] => Nombre 1
            [1] => Nombre 2
        )
)
```

Esto confirma:
- WSDL correcto
- Método SOAP funcional
- Conexión a BD válida

---

## 1️⃣2️⃣ Panel administrativo

*(Opcional)*

Acceder a: `http://127.0.0.1:8000/admin`

Aquí se gestiona la información desde interfaz gráfica usando Filament.

---

## 1️⃣3️⃣ Conceptos clave para examen

Este proyecto demuestra:

- Diferencia entre REST vs SOAP
- Uso de WSDL
- Comunicación XML
- Manejo correcto de errores SOAP
- Consumo desde cliente PHP
- Integración con base de datos
- Arquitectura limpia en Laravel 12

---

## 1️⃣4️⃣ Nota final

⚠️ **Este proyecto no depende de datos específicos.**

El mismo patrón se puede reutilizar para:
- Pacientes
- Usuarios
- Productos
- Facturas
- Cualquier entidad

**Cambian los nombres, no la lógica.**
