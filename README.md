<main>
#Larafolio

  Este maravilloso porfolio, desarrollado en el paquete de laravel Breeze, esta construido utilizando la metodolia de trabajo TDD o Test Driven Development (desarrollo dirigido por pruebas) es una práctica de programación en la que se comienzan escribiendo las pruebas en primer lugar, escribiendo el código fuente a continuación, pasando correctamente la prueba y terminando con la refactorización del código escrito.
  Este proyecto fue desarrollado en laravel 10, aplicando tecnologias como livewire, alpinejs, tailwindcss.
 



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Caracteristicas principales

  Este proyecto posee funcionalidades de privilegio para el administrador, asegurando su capacidad de editar el contenido del porfolio de manera dinamica:

- Login exclusivo para administrador.
- Acceso para el administrador(luego de haberse logueado), a botones de accion, los cuales permiten desplegar formularios de manipulacionde informacion.
- Entorno con dos bases de datos, una dedicada a la poduccion y otra exclusiva para el testing.
- Formularios con los que el administrador podra editar, crear o eliminar secciones de la pagina.
- Capacidad de que el visitante descargue el archivo pdf de mi curricullum.

## Traits

 En el contexto de Laravel, un "trait" es un mecanismo de reutilización de código que permite la composición horizontal de clases. Es una característica de la programación orientada a objetos que permite compartir métodos entre diferentes clases sin necesidad de utilizar la herencia tradicional.

Los traits en Laravel se utilizan principalmente para compartir comportamientos comunes entre varias clases. En lugar de extender una clase base para heredar sus métodos, podemos definir un trait que contiene esos métodos y luego incluir ese trait en las clases que necesiten esos comportamientos.

En este porfolio, se utilizan una serie de traits, reautilizando la misma logica en varios de los componentes.

  - Notification: el trait "Notification" contiene un método llamado "notify", que acepta dos parámetros opcionales: "$message" y "$event". El método "notify" utiliza la función "dispatchBrowserEvent" de Livewire para emitir un evento al navegador con el nombre proporcionado en "$event" (por defecto, el evento se llama "notify") y un arreglo asociativo que contiene el mensaje de la notificación.
  
  

  ```php


   public function notify($message = '', $event = 'notify')
    {
        $this->dispatchBrowserEvent($event, ['message' => $message]);
    }



  ```
  
    El evento que reciba como parametro el metodo notify, condiciona al tipo de alerta de SweetAlert que se mostrara.
   Dentro de resources\js\app.js se encuentran las escuchas del evento de SweetAlert:

   ```javascript

    window.addEventListener('notify', event => {
        GeneralSwal.fire({
            icon: 'success',
            title: event.detail.message
        })
    })

   ```

   Ese es el evento que ejecuta con el valor por defecto del parametro "$event", y a continuacion, por ejemplo si en vez de ser "notify", recibiera al evento "deleteMessage".


   ```javascript
   
        window.addEventListener('deleteMessage', event => {
            Swal.fire({
                confirmButtonColor: '#3f3f46',
                icon: 'success',
                title: event.detail.message,
            });
        });

   ```

     Se mostrara una notificacion orientada a eliminacion de algun dato, de esa forma este trait, logra administrar el uso de sweet alert de manera dinamica.
  
  

  - ShowProjects: Esta diseñado para que los usuarios puedan ver más proyectos a medida que interactúan con la interfaz. El trait "ShowProjects" te permite implementar fácilmente esta funcionalidad en varios componentes Livewire sin tener que repetir el mismo código en cada uno de ellos.

       ## Varablesy Metodos

<div style="margin-bottom: 10px;">
    <h3 style="margin: 0; font-size: 18px; color: #333;">$counter:</h3>
    <p style="margin: 0; color: #666;">Esta propiedad es un contador que determina cuántos proyectos se muestran actualmente en la lista. Por defecto, se inicializa con el valor 3, lo que significa que se mostrarán inicialmente 3 proyectos.</p>
</div>

<div style="margin-bottom: 10px;">
    <h3 style="margin: 0; font-size: 18px; color: #333;">getTotalProperty():</h3>
    <p style="margin: 0; color: #666;">Este método calcula y devuelve el total de proyectos en la base de datos utilizando el modelo "Project". Es una forma conveniente de obtener el número total de proyectos disponibles.</p>
</div>

<div style="margin-bottom: 10px;">
    <h3 style="margin: 0; font-size: 18px; color: #333;">showMore():</h3>
    <p style="margin: 0; color: #666;">Este método aumenta el valor de "$counter" en 3 si hay más proyectos disponibles para mostrar. Esto permite cargar y mostrar más proyectos en la lista cuando el usuario hace clic en un botón "Mostrar más".</p>
</div>

<div style="margin-bottom: 10px;">
    <h3 style="margin: 0; font-size: 18px; color: #333;">showLess():</h3>
    <p style="margin: 0; color: #666;">Este método reinicia el contador "$counter" a 3, lo que vuelve a mostrar solo los primeros 3 proyectos en la lista. Esto se puede utilizar para retroceder a la visualización original después de que se han cargado más proyectos.</p>
</div>



  - Slideover:.

  - WithImageFile:.



## Componentes base de la aplicacion

   La aplicacion esta basada en una serie de componentes de livewire.

- Navigation:.
- Hero.
- Projects.
- Contact.

  En versiones futuras del porfolio, se agregaran secciones, como "Certifications"(acceso a mis certificaciones de cursos), "Blog"(un area donde los visitantes podran dejar comentarios), "Docs"(un area donde desarrollare una suerte de documentacion sobre sobre laravel).



<main />

