<h1><img src="./src/Disk/public/56x56.png">  Lochlite CMS</h1>
<p>Este no es un software de código abierto. Lochlite le otorga una licencia personal limitada y revocable para administrar su sitio web. Consulte nuestros términos de servicio, licencia y privacidad para obtener más detalles.</p>

<p>Lochlite CMS es un moderno software de gestión de contenidos basado en tecnología PWA, con él tu sitio web cuenta con un panel de control administrativo, panel de usuario, sistema de inicio de sesión fiable y un moderno sistema de enrutamiento que permite la navegación sin recargar la página. Esta es su mejor oportunidad para adelantarse a la competencia con un sitio web robusto en la línea de las grandes empresas.</p>


<h3>Idioma</h3>
<p>Anteriormente, Lochlite CMS tenía una licencia más restrictiva, esto está cambiando lentamente. Actualmente Lochlite está haciendo que los recursos estén disponibles por temporadas, estando disponible en este primer momento solo la versión en portugués de Brasil, aun así, puedes comenzar a usarlo.</p>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/BR.svg" /> Actual &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/US.svg" /> Próxima &nbsp;&nbsp;&nbsp;&nbsp;    </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/ES.svg" /> septiembre/2022 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/JP.svg" /> marzo/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/FR.svg" /> mayo/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>

<h3>Requisito técnico mínimo</h3>

```html
   Servidor web con las siguientes características:
   - PHP 8.1
   - MySQL 5.7 (recomendado 8.0) o MariaDB 10.0
   - Almacenamiento mínimo de 20 GB
   - Memoria RAM mínima de 1,5 GB
   - Procesador de doble núcleo o superior con soporte para tareas en segundo plano
   - Servicio de correo electrónico (envío y recepción)
   - Administrador de archivos
```

<h3>Comenzar desde cero con un kit de inicio</h3>
<p>Actualmente necesita un desarrollador de PHP para instalar este software o tener un conocimiento técnico moderado. Si no está seguro de si puede instalarlo o algo no va bien, envíe un correo electrónico a <a href="mailto:drcg@lochlite.com"><strong> drcg@lochlite.com </strong></a> y nosotros lo guiará a través del proceso.</p>

<b>Las instrucciones a continuación deben seguirse usando su computadora personal/corporativa y no directamente en el servidor. En la siguiente sección, verá cómo colocar Lochlite CMS en el servidor web.</b>

   1. <h5>Instala Composer en tu dispositivo</h5>
      <p>Siga las instrucciones <a href="https://getcomposer.org/doc/00-intro.md">de esta página</a> y continúe con el siguiente paso.</p>

   2. <h5>Descargar Lochlite CMS</h5>
      <p>Abra el símbolo del sistema en la carpeta de su elección, pegue el texto resaltado a continuación y presione Entrar.</p>

      ```html
      composer create-project lochlite/cms-install lochlite 
      ```
      
      <p>Este proceso puede tardar unos minutos, no lo interrumpa, espere hasta que el símbolo del sistema se desbloquee para nuevos comandos.</p>
      
   3. <h5>Configurar la base de datos</h5>
      <p>En el paso anterior, el sistema creó una carpeta llamada 'lochlite'. Ingrese a la carpeta 'lochlite' y busque un archivo llamado 'env' o '.env'.</p>
      <p>Una vez que encuentre el archivo 'env', ábralo en un editor de texto, edite el fragmento a continuación con los detalles correspondientes para su base de datos y guarde los cambios.</p>
      
      ```html
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=database_name
       DB_USERNAME=database_username
       DB_PASSWORD=database_password 
      ```
      <p>Si no tiene una base de datos o no sabe cuáles son los detalles de la base de datos, comuníquese con su empresa de alojamiento o departamento de TI para obtener más detalles.</p>
   
   4. <h5>Haciendo los ajustes finales</h5>
      <p>Regrese al símbolo del sistema abierto en el paso 1, pegue el texto resaltado a continuación y presione enter.</p>
 
      ```html
      cd lochlite; php artisan migrate --force && php artisan db:seed --force 
      ```
      <p>Este proceso puede tardar unos minutos, no lo interrumpa, espere hasta que el símbolo del sistema se desbloquee para nuevos comandos.</p>
      
<p>Si no se produjeron errores en los pasos anteriores, está listo para poner su sitio en línea y comenzar a crear sus páginas y artículos.</p>    

<h3>Poner en un servidor web</h3>
<p>Los pasos descritos en la sección anterior <strong>deben realizarse en su computadora local y no directamente en el servidor</strong>, para colocar Lochlite CMS en un servidor web de manera segura, se requieren algunos pasos adicionales.</p>    

         
