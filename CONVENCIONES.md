Guía de nomenclatura de tablas en SQL
1. General

    Todo en minúsculas
    Evita problemas de compatibilidad entre motores y mejora la legibilidad.
    ✅ usuarios
    ❌ Usuarios
    ❌ UsuariosSistema

    Sin caracteres especiales (ñ, tildes, espacios, guiones -).
    Solo usar letras, números y guion bajo _.

    Lenguaje consistente
    Usar siempre un mismo idioma para todos los nombres (ej.: todo en español si la base está en español).

2. Tablas con un solo concepto

    Usar nombre descriptivo en singular o plural (según convención definida, pero siempre consistente).

    Si el nombre es corto y claro, sin guion bajo.
    Ejemplos:
    ✅ usuarios
    ✅ archivosadjuntos
    ❌ archivosAdjuntos (camelCase no recomendado en SQL)

3. Tablas con varios conceptos compuestos

    Si son dos o más palabras que forman un único concepto, unir sin guion bajo.
    Ejemplo:
    ✅ archivosadjuntos (archivos adjuntos como concepto)

    Si son tablas puente (producto de normalización o relación N a N), usar guion bajo _ para separar entidades.
    Ejemplo:
    ✅ configuracion_anio_usuario
    ✅ pedido_producto
