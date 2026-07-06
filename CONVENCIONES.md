# Convención de nomenclatura del proyecto Yii2

## 1. Base de datos

### Tablas

* Utilizar nombres en minúsculas.
* Utilizar snake_case para nombres compuestos.
* Utilizar nombres descriptivos.
* Utilizar singular para representar una entidad.

Ejemplos:


usuario
biopsia
informe_complementario
archivo_adjunto
tipo_estudio


---

### Tablas de relación (N a N)

* Utilizar el prefijo `rel_`.
* Separar entidades mediante guion bajo (`_`).

Ejemplos:

rel_usuario_rol
rel_biopsia_estudio
rel_pedido_producto


---

### Claves primarias

* Utilizar siempre el nombre `id`.

Ejemplos:

id


---

### Claves foráneas

* Utilizar el prefijo `id_` seguido del nombre de la tabla referenciada.

Ejemplos:


id_usuario
id_biopsia
id_estudio
id_informe_complementario


---

### Columnas

* Utilizar nombres descriptivos.
* Utilizar snake_case.
* Evitar abreviaturas ambiguas.

Ejemplos:


nombre
apellido
descripcion
fecha_creacion
fecha_actualizacion
numero_protocolo
fecha_informe


---

### Índices y restricciones

Utilizar los siguientes prefijos:


idx_ → Índices
fk_  → Claves foráneas
uk_  → Restricciones únicas


Ejemplos:


idx_usuario_nombre
fk_biopsia_estado
uk_usuario_documento


---

## 2. Código PHP (Yii2)

### Modelos

Utilizar PascalCase.

Ejemplos:


Usuario
Biopsia
InformeComplementario
ArchivoAdjunto
TipoEstudio


---

### Controladores

Utilizar PascalCase y finalizar con `Controller`.

Ejemplos:


UsuarioController
BiopsiaController
InformeComplementarioController


---

### Variables

Utilizar camelCase.

Ejemplos:


$usuario
$biopsia
$informeComplementario
$archivoAdjunto
$idBiopsia


---

## 3. Vistas

### Carpetas de vistas

* Utilizar minúsculas.
* Sin espacios.
* Sin camelCase.

Ejemplos:


usuario
biopsia
informecomplementario
archivoadjunto


---

### Archivos de vistas

Utilizar minúsculas.

Ejemplos:


index.php
view.php
create.php
update.php
form.php
pdf.php
documentopdf.php


---

### Vistas parciales

Utilizar el prefijo `_`.

Ejemplos:


_form.php
_filtros.php
_datos.php
_encabezado.php


---

## 4. Consideraciones generales

* Utilizar siempre el mismo idioma en todo el proyecto.
* No utilizar tildes, ñ, espacios ni caracteres especiales.
* Evitar palabras reservadas de SQL.
* Mantener la consistencia por encima de preferencias personales.
* Las nuevas funcionalidades deberán ajustarse a esta convención. Los módulos existentes podrán adaptarse gradualmente durante tareas de mantenimiento o refactorización.

```
```
Elemento	Convención
Tablas SQL	snake_case
Columnas SQL	snake_case
Modelos	PascalCase
Controladores	PascalCase
Variables PHP	camelCase
Carpetas de vistas Yii2	kebab-case (informe-complementario)
Archivos de vistas	snake_case (documento_pdf.php)
Vistas parciales	_snake_case (_datos_paciente.php)
