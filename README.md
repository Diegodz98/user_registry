# User Registry Module

## Descripción

El módulo **User Registry** proporciona una serie de funcionalidades para la gestión de registros de usuarios dentro de un sistema basado en Drupal. Su propósito principal es permitir el registro y administración de usuarios mediante un conjunto de campos específicos, incluyendo nombre completo, correo electrónico, DNI y fecha de nacimiento.

## Instalación

1. Copia la carpeta del módulo en el directorio `/modules/custom/` de tu instalación de Drupal.
2. Verifique nombre de carpeta del mosulo sea user_registry
3. Habilita el módulo desde la interfaz de administración de Drupal o mediante Drush:
   ```bash
   drush en user_registry
4. Puede empezar con la revisión tomando las rutas solicitadas en la prueba https://docs.google.com/document/d/1ZzUSLyVoW9zn2Dk90brK9mtfezJQriji_bEb4UC3_L8/edit?tab=t.0#heading=h.ywr6lwetrvbp
5. Para poder reflejar la personalización de los labels se tiene que borrar caché

### Funcionalidades clave:

1. **Registro de Usuario**:
   - El módulo permite registrar y almacenar información relevante de los usuarios en una entidad personalizada. Los campos incluyen:
     - Nombre completo
     - Correo electrónico
     - DNI (número de identificación nacional)
     - Fecha de nacimiento

2. **Validación de Datos**:
   - Se implementaron validaciones para asegurar que los datos proporcionados en el registro sean correctos:
     - Validación del DNI para asegurar que sea único y numérico.
     - Validación del formato de correo electrónico y de la fecha de nacimiento.

3. **Consultas mediante DNI**:
   - Se ha desarrollado un endpoint REST que permite consultar la información de un usuario a partir de su DNI. Este endpoint devuelve un JSON con la información del usuario registrado, o un mensaje de error si no se encuentra.

4. **Paginación**:
   - Se ha añadido soporte de paginación en la interfaz de administración para la lista de registros de usuarios. Si hay más de 10 registros, la lista se paginará automáticamente, facilitando la navegación a través de los registros.


## Requisitos

Este módulo está diseñado para ser utilizado con Drupal 10 o superior. Asegúrate de tener instalada una versión de Drupal compatible.

