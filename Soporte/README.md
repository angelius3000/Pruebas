# Módulo Soporte (Sistema de tickets)

Este es un sistema ligero de tickets para uso interno IT, integrado al proyecto existente.

## Características MVP

- Creación de ticket por solicitante con asunto, descripción, categoría, activo, impacto y urgencia.
- Bandeja con DataTables, filtros de estado, prioridad, texto, "Asignados a mí" y "Sin asignar".
- Detalle de ticket con conversación, respuestas públicas e internas.
- Asignación a técnico, cambio de estado y cierre desde la interfaz.
- Prioridad calculada automáticamente; override posible en el backend (no implementado UI aún).
- Folio automático IT-YYYY-###### con reinicio anual.
- Adjuntos en formulario (no guardados aún).
- Envío de notificaciones SMTP para creación, asignación y cambios de estado relevantes.
- Auditoría básica en tabla `audit_log`.
- Roles: solicitante, técnico, admin. Control de acceso a páginas.
- Administración básica de usuarios/categorías/activos (sólo esqueletos).

## Estructura de carpetas

```
Soporte/
  index.php        -> dashboard
  list.php         -> listado de tickets
  new_ticket.php   -> formulario de creación
  detail.php       -> vista de ticket
  admin_*.php      -> páginas de administración (pendiente)
App/Datatables/Soporte-tickets-grid-data.php
App/Server/SoporteCreateTicket.php
App/Server/SoporteAddMessage.php
App/Server/SoporteUpdateTicket.php
```

## Base de datos

Ver `sql/soporte_schema.sql` para la definición de tablas y datos semilla.

Ejecute:
```sql
SOURCE sql/soporte_schema.sql;
```

El script crea además la tabla auxiliar `ticket_folio_counter` para generación de folios.

## Configuración

Las variables de entorno (ejemplo en `.env.example`) permiten definir la conexión de 
Base de Datos y SMTP.

- **DB_HOST**, **DB_NAME**, **DB_USER**, **DB_PASS** etc.
- **SMTP_HOST**, **SMTP_PORT**, **SMTP_USER**, **SMTP_PASS**, **SMTP_FROM**.

`Connections/ConDB.php` se ha modificado para leer dichas variables cuando están disponibles.

## Seguridad

- Login obligatorio (usa el sistema existente).
- Control de acceso en cada página según rol y `secciones`.
- CSRF no añadido en este MVP; usar tokens en próximos pasos.
- Sanitización básica de entradas y uso de consultas preparadas.
- Adjuntos serán validados/guardados fuera del webroot en desarrollos futuros.
- Rate limit aún no implementado.

## Próximos pasos

- CRUD completo en administración (usuarios, categorías, activos).
- Subida y gestión de adjuntos configurada (whitelist, tamaño).
- Reportes y export CSV sobre categorías/estado/prioridad.
- Audit log más exhaustivo y reglas de prioridad override con UI.
- Mejoras de UI: plantillas de descripción, vistas específicas para técnicos.
- Manejo de notificaciones por correo según reglas especificadas.


```markdown
```