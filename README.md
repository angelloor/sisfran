# SISFRAN asas

## Descripción de la Aplicación

La Aplicación Integral de Control de Inventario y Asistencia (SISFRAN) es una solución flexible diseñada para optimizar la gestión de recursos y personal en la empresa. Esta Aplicación tiene como objetivo principal proporcionar un control exhaustivo y eficiente del inventario, facilitando la verificación de existencias, la gestión de activos y la generación automatizada de actas digitales.

## Características de la Aplicación SISFRAN:

### Control de Inventario:

- **Gestión de Existencias**: Permite llevar un registro detallado y actualizado de todos los artículos y recursos disponibles en la empresa.
- **Control de Activos**: Facilita el seguimiento y la administración de los activos fijos, asegurando su correcta utilización y mantenimiento.
- **Generación de Actas Digitales**: Automatiza la creación de actas, documentando movimientos y cambios en el inventario, lo que mejora la transparencia y la trazabilidad.

### Módulo de Credenciales Digitales:

- **Generación de Actas de Credenciales**: Produce actas de las credenciales de manera automatizada siguiendo el estándar ISO FO-01 (DG-SM-AD-09), asegurando que los documentos cumplen con las normativas y requisitos internacionales.
- **Verificación y Control**: Permite la validación rápida y precisa de las credenciales, mejorando la seguridad y la eficiencia en los procesos administrativos.

### Control de Asistencia:

- **Registro de Asistencia**: Gestiona la asistencia del personal, permitiendo un seguimiento preciso de las horas trabajadas.
- **Informes y Estadísticas**: Genera reportes detallados sobre la asistencia, facilitando la toma de decisiones y la planificación de recursos humanos.

## Tecnologías usadas

### Desarrollo

- StarUML (Diagramación de Base de datos)
- Visual Studio Code (Editor de código)
- Servidor WAMP Versión 3.2.3
  - Apache 2.4.46
  - MySQL 8.0.21
  - PHP 7.3.21
- DevTools de Google Chrome para debugging
- Git (Para el control de versiones del Software)

### Producción

- Cpanel (servicio de administración de Hosting para servicios web)
- File Manager (Administración de archivos dentro del Hosting)
- phpMyAdmin (Administración de base de datos dentro del Hosting)

## Metodología

Para el desarrollo de la Aplicación Integral de Control de Inventario y Asistencia (SISFRAN), se empleó SCRUM como metodología ágil que permite adaptarse a los cambios y requerimientos del proyecto de manera eficiente. Esta metodología se caracterizó por una interacción periódica pero limitada con la empresa, asegurando que cada iteración del desarrollo estuviera alineada con las necesidades reales de los usuarios finales. A continuación, se detalla el enfoque seguido:

1. **Recolección Inicial de Información**

   La primera fase del proyecto consistió en la recolección de información y requerimientos. Dado que las interacciones con la empresa fueron limitadas, se llevaron a cabo sesiones de reuniones intensivas y bien planificadas con los representantes clave de la organización. Durante estas sesiones, se identificaron las necesidades esenciales y se establecieron los objetivos principales de la Aplicación.

2. **Desarrollo Iterativo e Incremental**

   Se adoptó un enfoque iterativo e incremental, típico de metodologías ágiles como Scrum, para desarrollar la Aplicación. Este enfoque permitió desarrollar la Aplicación en pequeños incrementos funcionales, cada uno de los cuales fue revisado y evaluado con la empresa. Las fases del desarrollo fueron las siguientes:

   - **Planificación de Iteraciones**: Al inicio de cada iteración, se definieron claramente las funcionalidades a desarrollar basadas en las prioridades establecidas durante la recolección inicial de información.
   - **Desarrollo de Prototipos**: Se crearon prototipos funcionales que permitieron a la empresa visualizar y probar las características de la Aplicación en desarrollo.
   - **Feedback y Retroalimentación**: Tras cada iteración, se realizaron demostraciones de la Aplicación a la empresa, recopilando feedback crucial que permitió ajustar y mejorar las funcionalidades antes de la siguiente iteración.

3. **Arquitectura de la Aplicación: Modelo-Vista-Controlador (MVC)**

   La arquitectura del proyecto se basó en el patrón de diseño Modelo-Vista-Controlador (MVC), lo que facilitó la separación de las preocupaciones y mejoró la mantenibilidad y escalabilidad del código. La implementación de esta arquitectura se detalló de la siguiente manera:

   - **Modelo (Model)**: Representa la lógica de negocio y los datos de la Aplicación. En el contexto de SISFRAN, el modelo maneja todas las operaciones relacionadas con el inventario, las credenciales digitales, la asistencia.
   - **Vista (View)**: Es la interfaz de usuario de la Aplicación. Se desarrollaron vistas intuitivas y amigables que permiten a los usuarios interactuar fácilmente con la Aplicación y acceder a la información necesaria.
   - **Controlador (Controller)**: Actúa como intermediario entre el modelo y la vista. Los controladores gestionan las entradas del usuario, procesan las solicitudes, y determinan las vistas adecuadas para presentar la información.

4. **Validación y Pruebas**

   - **Pruebas Unitarias**: Se realizaron pruebas unitarias durante cada iteración para asegurar que las funcionalidades individuales de la Aplicación funcionaran correctamente.
   - **Pruebas de Integración**: Estas pruebas aseguraron que los diferentes módulos de la Aplicación interactuaran correctamente entre sí.
   - **Pruebas de Aceptación del Usuario (UAT)**: Al final de cada iteración, se llevaron a cabo pruebas de aceptación del usuario para validar que la Aplicación cumpliera con los requisitos y expectativas de la empresa.

## Requerimientos Mínimos

### Servidor

El servidor se lo puede implementar tanto en Windows como en Linux, lo único importante aquí es tener en cuenta las versiones de las tecnologías usadas para no tener problemas con la compatibilidad.

- Core i3
- 4GB RAM
- 50GB de almacenamiento

### Usuario

El usuario tendrá que entrar a una URL desde un navegador donde se encontrará publicada la aplicación.

- Core i3
- 4GB RAM
- 256GB de almacenamiento

## Instalación dentro del Servidor

La Aplicación tiene que ser publicada dentro del directorio `public_html` del servidor contratado. Por ejemplo, para hosting con el File Manager, el directorio es el siguiente:

/home/sisfranc/public_html/

En esta ubicación debe ser copiado el proyecto tal como se muestra.

### Cargar Base de Datos

Para subir la base de datos, primero debe ser creada utilizando herramientas de cPanel (phpMyAdmin):

1. Ir a la opción MySQL® Databases en cPanel, dentro de la categoría de bases de datos. Esta opción permite crear bases de datos, usuarios, asignar privilegios, etc.
2. Después de crear la base de datos, usuario y asignarle los privilegios, procedemos a entrar en phpMyAdmin para cargar el script de producción. Para esto, accedemos a la opción de phpMyAdmin en cPanel en la categoría de bases de datos.

   - Una vez ingresado, seleccionamos la base de datos, vamos a la opción de importar, seleccionamos el script de producción y le damos clic en el botón de importar que está al final.

3. Ya realizado esto, nos queda configurar las variables de conexión dentro del proyecto. Para esto, nos dirigimos al File Manager y entramos a nuestro proyecto en la siguiente ruta:

/home/sisfranc/public_html/src/lib/connections/ConnectionData.php

4. Modificamos el archivo con las correspondientes credenciales de la base de datos, y listo.

## Conclusión

- La metodología de desarrollo adoptada para el proyecto SISFRAN, combinando interacciones estratégicas con la empresa y un enfoque iterativo basado en la arquitectura MVC, resultó en una Aplicación robusta, flexible y alineada con las necesidades reales de la organización. Esta estrategia no solo permitió adaptarse rápidamente a los cambios y retroalimentación, sino que también aseguró una alta calidad en el producto final.
- La Aplicación Integral de Control de Inventario y Asistencia (SISFRAN) está diseñada para funcionar eficientemente con requerimientos tecnológicos accesibles, tanto en entornos Windows como Linux. Las especificaciones mínimas, que incluyen un procesador Core i3, 4 GB de RAM y 50 GB de almacenamiento para el servidor, aseguran una implementación sin contratiempos y un rendimiento óptimo.
- La facilidad de acceso mediante una URL desde cualquier navegador y la compatibilidad con infraestructuras modestas garantizan que SISFRAN pueda ser adoptado rápidamente por la empresa. En resumen, SISFRAN ofrece una solución integral y eficiente, adecuada para cualquier organización que busque mejorar su gestión de inventario y control de asistencia con recursos tecnológicos básicos.
- La Aplicación Integral de Control de Inventario y Asistencia (SISFRAN) ha demostrado ser una solución versátil y eficiente que puede ser instalada en un entorno de hosting compartido utilizando cPanel. Esta capacidad de implementación facilita la accesibilidad y reduce costos, permitiendo a las empresas beneficiarse de sus funcionalidades avanzadas sin necesidad de invertir en infraestructura dedicada.

AIzaSyDuFNTu49oRZu6CoSfW10ocnPQjAvuxlQY
