
# Larafolio

>Este maravilloso porfolio, desarrollado en el paquete de laravel Breeze, esta construido utilizando la metodologia de trabajo TDD o Test Driven Development (desarrollo dirigido por pruebas) es una práctica de programación en la que se comienzan escribiendo las pruebas en primer lugar, escribiendo el código fuente a continuación, pasando correctamente la prueba y terminando con la refactorización del código escrito.
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

  ### Notification: 
 El trait "Notification" contiene un método llamado "notify", que acepta dos parámetros opcionales: "$message" y "$event". El método "notify" utiliza la función "dispatchBrowserEvent" de Livewire para emitir un evento al navegador con el nombre proporcionado en "$event" (por defecto, el evento se llama "notify") y un arreglo asociativo que contiene el mensaje de la notificación.
  
  

  ```php
   public function notify($message = '', $event = 'notify')
    {
        $this->dispatchBrowserEvent($event, ['message' => $message]);
    }
  ```



>El evento que reciba como parametro el metodo notify, condiciona al tipo de alerta de SweetAlert que se mostrara.Dentro de resources\js\app.js se encuentran las escuchas del evento de SweetAlert:


 
   
 ```javascript
   window.addEventListener('notify', event => {
        GeneralSwal.fire({
            icon: 'success',
            title: event.detail.message
        })
    })
 ```
   

  
Ese es el evento que ejecuta con el valor por defecto del parametro "$event", y a continuacion, por ejemplo si en vez de ser "notify", recibiera al evento"deleteMessage".
 


  
 ```javascript
    window.addEventListener('deleteMessage', event => {
        Swal.fire({
            confirmButtonColor: '#3f3f46',
            icon: 'success',
            title: event.detail.message,
        });
    });
 ```
  

>Se mostrara una notificacion orientada a eliminacion de algun dato, de esa forma este trait, logra administrar el uso de sweet alert de manera dinamica.
  
  

  ### ShowProjects:
  Esta diseñado para que los usuarios puedan ver más proyectos a medida que interactúan con la interfaz. El trait "ShowProjects" te permite implementar fácilmente esta funcionalidad en varios componentes Livewire sin tener que repetir el mismo código en cada uno de ellos.

  **Variables y Metodos**:


El trait contiene las siguientes propiedades y métodos:

 ```php
     public int $counter = 3;
  ```



>$counter: Esta propiedad es un contador que determina cuántos proyectos se muestran actualmente en la lista. Por defecto, se inicializa con el valor 3, lo que significa que se mostrarán inicialmente 3 proyectos.


 
   
 ```php
     public function getTotalProperty()
    {
        return Project::count();
    }
 ```
    
>getTotalProperty(): Este método calcula y devuelve el total de proyectos en la base de datos utilizando el modelo "Project". Es una forma conveniente de obtener el número total de proyectos disponibles.
 


  
 ```php
      public function showMore()
    {
        if ($this->counter < $this->total) {
            $this->counter += 3;
        }
    }
 ```
  

>showMore(): Este método aumenta el valor de "$counter" en 3 si hay más proyectos disponibles para mostrar. Esto permite cargar y mostrar más proyectos en la lista cuando el usuario hace clic en un botón "Mostrar más".
  
  
```php
  public function showLess()
    {
        //$this->counter = 3;
        $this->reset('counter');
    }
```
>showLess(): Este método reinicia el contador "$counter" a 3, lo que vuelve a mostrar solo los primeros 3 proyectos en la lista. Esto se puede utilizar para retroceder a la visualización original después de que se han cargado más proyectos.




  ### Slideover:
  
Un "Slideover" es una interfaz donde se muestra contenido adicional o formularios en una capa superpuesta que se puede abrir o cerrar, típicamente utilizando animaciones de transición.

Este trait contiene propiedades y métodos que permiten controlar la apertura y el contenido de un "Slideover". Veamos cada parte del trait:

```php
     public $openSlideover = false;
  ```



>$openSlideover: Esta propiedad booleana indica si el "Slideover" está abierto o cerrado. Por defecto, se inicializa como "false", lo que significa que el "Slideover" está cerrado.


 
   
 ```php
     public $addNewItem = false;
 ```
    
>$addNewItem: Esta propiedad booleana indica si el "Slideover" debe mostrarse en modo de agregar un nuevo elemento. Esta propiedad puede ser útil para adaptar el contenido del "Slideover" según la acción que el usuario desea realizar.

```php
    public function openSlide($addNewItem = false)
    {
        $this->addNewItem = $addNewItem;
        $this->openSlideover = true;
    }
 ```
 
 >openSlide($addNewItem = false): Este método se encarga de abrir el "Slideover". Puede aceptar un parámetro opcional "$addNewItem", que indica si el "Slideover" debe mostrarse en modo de agregar un nuevo elemento. Cuando se invoca este método, se establece la propiedad "$addNewItem" según el valor proporcionado y se cambia el estado de "$openSlideover" a "true", lo que hace que el "Slideover" se muestre en la interfaz.



  ### WithImageFile:
  Este trait está diseñado para simplificar la lógica relacionada con la carga y validación de archivos de imagen, y también proporciona métodos para verificar y eliminar archivos temporales.
  
  Veamos cada parte del trait:
  
 ```php
   public $imageFile = null;
 ```
>$imageFile: Esta propiedad representa el archivo de imagen que se está manejando. Inicialmente se establece en "null", lo que indica que no hay ningún archivo seleccionado.


  ```php
     public function updatedImageFile()
    {
        $this->verifyTemporaryUrl();

        $this->validate([
            'imageFile' => 'image|max:1024',
        ]);
    }
 ```
>updatedImageFile(): Este método se ejecuta automáticamente cuando se actualiza la propiedad "$imageFile", lo que sucede cuando un usuario selecciona un archivo de imagen en un formulario. Dentro de este método, se verifica si el archivo tiene una URL temporal válida y luego se valida el archivo según las reglas especificadas, en este caso, que sea una imagen y que no exceda un tamaño máximo de 1024 kilobytes.
 
 
  ```php
        private function verifyTemporaryUrl()
    {
        try {
            $this->imageFile->temporaryUrl();
        } catch (\RuntimeException $exception) {
            $this->reset('imageFile');
        }
    }
 ```
>verifyTemporaryUrl(): Este método verifica si el archivo de imagen tiene una URL temporal válida. Si no es así, significa que el archivo no se ha cargado correctamente, por lo que se restablece la propiedad "$imageFile" a "null".
 
 
  ```php
    private function deleteFile($disk, $filename)
    {
        if ($filename && Storage::disk($disk)->exists($filename)) {
            Storage::disk($disk)->delete($filename);
        }
    }
 ```
>deleteFile($disk, $filename): Este método elimina un archivo de imagen dado su nombre de archivo y el disco de almacenamiento. Se utiliza para eliminar archivos existentes en el caso de que se necesite reemplazarlos o eliminarlos de forma definitiva.

Habiendo abordado los traits principales utilizados, podemos comenza explicar los componentes de livewire que componen la aplicacion.

## Componentes base de la aplicacion

   >La aplicacion esta basada en una serie de secciones componentes de livewire, cada componente de livewire esta a su vez enlazado a una vista.

* **Navigation**: Esta seccion constade 3 componentes de livewire,uno principal y otros dos complementarios del mismo.
     * Navigation.php: Este componente es el componente principal del sistema de navegación. Es responsable de manejar la lista de elementos de navegación (Navitem) que se mostrarán en la vista. Contiene métodos para cargar los elementos iniciales, actualizar los elementos existentes, agregar nuevos elementos y eliminar elementos. Utiliza dos traits llamados Notification y Slideover para manejar notificaciones y mostrar un "slideover" (una especie de componente emergente) respectivamente. También se comunica con otros componentes a través de eventos y escucha eventos de otros componentes.

     * Item.php: Este componente representa un único elemento de navegación (Navitem). Es responsable de manejar la creación y edición de un elemento individual. Tiene un conjunto de reglas de validación que garantizan que los datos ingresados sean válidos antes de guardar el elemento. Cuando se guarda un nuevo elemento, emite un evento para notificar al componente Navigation que se ha agregado un elemento nuevo y también emite un evento para notificar al componente FooterLink que los elementos han sido actualizados.

     * FooterLink.php: Este componente es responsable de renderizar los enlaces de navegación en el footer (pie de página). Escucha el evento itemsHaveBeenUpdated que es emitido por el componente Navigation y recupera los elementos actualizados de la base de datos para renderizarlos en la vista.

**Relaciones entre los componentes:**

Navigation utiliza el componente Item para crear y editar elementos de navegación.

```php
   class Navigation extends Component
{
    use Notification, Slideover;

    public $items;

    protected $listeners = ['deleteItem', 'itemAdded' => 'updateDataAfterAddItem'];

    protected $rules = [
        'items.*.label' => 'required|max:20',
        'items.*.link'  => 'required|max:40',
    ];

    public function mount()
    {
        $this->items = Navitem::all();
    }

    public function updateDataAfterAddItem()
    {
        $this->mount();
        $this->reset('openSlideover');
    }

    public function edit()
    {
        $this->validate();

        foreach ($this->items as $item) {
            $item->save();
        }

        $this->reset('openSlideover');
        $this->emitTo('navigation.footer-link', 'itemsHaveBeenUpdated');
        $this->notify(__('Menu items updated successfully!'));
    }

    public function deleteItem(Navitem $item)
    {
        $item->delete();
        $this->mount();
        $this->emitTo('navigation.footer-link', 'itemsHaveBeenUpdated');
        $this->notify(__('Menu item has been deleted.'), 'deleteMessage');
    }

    public function render()
    {
        return view('livewire.navigation.navigation');
    }
}

```
>El componente navigation utiliza los trait Notification(notificar las acciones o errores) y SlideOver(acceso alos formularios), la variable $items sera el la peticion del hook mount(),el metodo updateDataAfterAddItem(), sera un evento que llamarael componente Item, a la hora de haber antes de guardar la informacion.

 ```php
  class Item extends Component
{
    use Notification;

    public Navitem $item;

    protected $rules = [
        'item.label' => 'required|max:20',
        'item.link'  => 'required|max:40'
    ];

    public function mount()
    {
        $this->item = new Navitem();
    }

    public function save()
    {
        $this->validate();
        $this->item->save();
        $this->emitTo('navigation.navigation', 'itemAdded');
        $this->emitTo('navigation.footer-link', 'itemsHaveBeenUpdated');
        $this->mount();
        $this->notify(__('Item created successfully!'));
    }

    public function render()
    {
        return view('livewire.navigation.item');
    }
}

 ```
>Item emite eventos para notificar a Navigation y FooterLink cuando se crea o edita un elemento, para que ambos componentes actualicen sus datos. 

```php
class FooterLink extends Component
{
    protected $listeners = ['itemsHaveBeenUpdated' => 'render'];

    public function render()
    {
        $items = Navitem::get();
        return view('livewire.navigation.footer-link', ['items' => $items]);
    }
}



```
> Aqui podemos ver que dentro del componente Navigation los metodos edit(), como el metodo deleteItem(), llaman a traves del metodo emiTo(), a este evento del componente FooterLink llamado 'itemsHasBeenUpdated', el cual no hace mas que eejeeturar el metodo render del componente, dentro del cual tan se instancia la variable $items, la cual permite reflejar loscambios en los enlaces, en el componente de footer. 
    
* **Hero:**
 Hero es el nombre de  una seccion de mi porfolio,la cual esta dividida, es dos componenetes, Image y Info, abordare,conceptualmente a cada uno de ellos:
    * Image: Este componente se encarga de mostrar la imagen de un héroe (imagen destacada) en la interfaz. Conceptualmente, su objetivo es cargar y mostrar una imagen asociada a la información personal almacenada en la base de datos. Los aspectos clave de este componente son:
      * Carga de imagen predeterminada: Si no se encuentra una imagen personalizada en la base de datos, el componente mostrará una imagen predeterminada llamada 'default-hero.jpg'.
      * Manejo de eventos: Escucha el evento 'heroImageUpdated', que es emitido por otro componente (posiblemente 'Info') cuando se actualiza la imagen del Hero. En respuesta a este evento, el componente recarga su imagen.

  * Info: Este componente se encarga de la gestión de la información personal y la imagen del héroe. Conceptualmente, su función es permitir la edición de información personal, incluyendo título, descripción y un archivo de currículum (CV), así como la gestión de la imagen del héroe. Los aspectos clave de este componente son:

    * Edición y validación: Permite la edición de la información personal (título y descripción) y realiza validaciones para asegurarse de que los datos ingresados sean válidos.
    * Subida de archivos: Utiliza el trait WithFileUploads para permitir la subida de archivos, tanto el CV como la imagen del héroe. Realiza validaciones en los formatos y tamaños de los archivos.
    * Actualización de información: Al realizar la edición y actualización, el componente se encarga de manejar la subida de nuevos archivos (CV e imagen del héroe) y de eliminar los archivos anteriores si se reemplazan con nuevos archivos.
    * Comunicación con el componente Image: Después de actualizar la imagen del héroe, emite el evento 'heroImageUpdated', que es escuchado por el componente 'Image', asegurando que la nueva imagen se muestre correctamente en la interfaz.
 


* **Projects:**
  La secccion Projects esta constituida por un componenete livewire principal, complementado por algunos componenetes de blade. 
 Este componenete es Project, tiene un propósito específico dentro de la aplicación: gestionar la información relacionada con los proyectos. Conceptualmente, este componente se encarga de crear, editar, eliminar y mostrar proyectos, incluyendo detalles como el nombre del proyecto, descripción, imágenes, enlaces a videos, URLs y enlaces a repositorios. A continuación, desglosaré las características y responsabilidades clave de este componente: 
    * Gestión de proyectos: El componente permite la gestión completa de proyectos, incluyendo la creación de nuevos proyectos, edición de proyectos existentes y eliminación de proyectos. Esto se hace a través de métodos como create(), save(), deleteProject() y loadProject().

  * Validación de datos: Se aplica una serie de reglas de validación definidas en la propiedad $rules para asegurar que los datos ingresados para cada proyecto sean válidos antes de guardarlos. Esto garantiza que los datos cumplan con ciertos criterios (longitud, formatos, etc.).

  * Manejo de archivos: El componente utiliza el trait WithFileUploads para permitir la subida de imágenes relacionadas con cada proyecto. Las imágenes de los proyectos se almacenan en el sistema de archivos y se gestionan de acuerdo con las reglas definidas.

  * Notificaciones: Se utiliza el trait Notification para mostrar notificaciones al usuario en diferentes escenarios, como cuando se guarda un proyecto exitosamente o cuando se elimina un proyecto.

  * Comunicación con otros componentes: El componente emite y escucha eventos. Por ejemplo, emite un evento 'deleteProject' cuando se elimina un proyecto, y escucha eventos externos (no se proporciona el detalle del componente externo aquí) como parte de la interacción con otros componentes.

   * Mostrar lista de proyectos: El componente también se encarga de cargar y mostrar una lista de proyectos. El método render() obtiene los proyectos desde la base de datos y los pasa a la vista para su renderización.



* **Contact:**
  La seccion Contact; esta constituida pordos componenetes de livewire, Contact, y SocialLink.
   El componente Contact junto con su componente complementario SocialLink tienen la función de gestionar la sección de contacto en tu portafolio, incluyendo la información de contacto y los enlaces a tus redes sociales. Aquí está una explicación conceptual de cada componente:
   
  * Contact.php: Este componente se encarga de manejar la información de contacto, especialmente el correo electrónico. Su objetivo es permitir la edición y actualización del correo electrónico de contacto que se muestra en tu portafolio. Aquí están sus características clave:

  * Carga de información: El componente carga la información de contacto (incluyendo el correo electrónico) desde la base de datos. Si no existe ninguna información, crea una nueva instancia de la clase PersonalInformation.
  * Edición de correo electrónico: Permite al usuario editar el correo electrónico de contacto y aplica reglas de validación para asegurarse de que se proporcione un correo electrónico válido.
  * Notificaciones: Utiliza el trait Notification para mostrar notificaciones al usuario cuando se actualiza el correo electrónico de contacto con éxito.
  * SocialLink.php: Este componente es complementario al componente Contact y se encarga de gestionar los enlaces a tus redes sociales. Aquí están sus características clave:

  * Carga de enlaces: El componente carga los enlaces a las redes sociales desde la base de datos y los muestra en la interfaz.
Creación y edición de enlaces: Permite al usuario crear nuevos enlaces a redes sociales o editar los enlaces existentes. Aplica reglas de validación para asegurarse de que los enlaces sean válidos, incluyendo el formato del icono (utilizando clases de FontAwesome).
  * Eliminación de enlaces: Permite al usuario eliminar enlaces a redes sociales. Cuando se elimina un enlace, se emite un evento que también se escucha en el componente Contact, lo que podría actualizar la información de contacto relacionada con las redes sociales en el futuro.
  
  * **Relación conceptual entre los componentes:**

    * Dependencia y comunicación: El componente SocialLink depende del componente Contact en el sentido de que interactúa con la misma información de contacto (correo electrónico). Ambos componentes utilizan el trait Slideover para mostrar un componente emergente en la interfaz. Además, SocialLink emite un evento llamado 'deleteSocialLink' que es escuchado por Contact.
    * Separación de responsabilidades: Contact se enfoca en la gestión del correo electrónico de contacto, mientras que SocialLink se enfoca en la gestión de los enlaces a redes sociales. Cada componente tiene su propósito específico.
    * Notificaciones compartidas: Ambos componentes utilizan el trait Notification para mostrar notificaciones al usuario después de realizar acciones exitosas o eliminar elementos.



En conjunto, estos componentes trabajan juntos para proporcionar una sección de contacto en tu portafolio que incluye la información de contacto (correo electrónico) y enlaces a tus redes sociales. Cada componente tiene su propio conjunto de responsabilidades, pero comparten información y notificaciones relevantes.

  ***En versiones futuras del porfolio, se agregaran secciones, como "Certifications"(acceso a mis certificaciones de cursos), "Blog"(un area donde los visitantes podran acceder a ariculos propios, y  dejar comentarios), "Docs"(un area donde desarrollare una suerte de documentacion personal sobre laravel).***



## Acerca del testing 

   >El testing de este proyecto esta orientado mas a los tenting de "Features", de hecho en esta version del proyecto(quizas en version futuras mas perfeccionadas sea diferente) no hay incorporados test unitarios, es decir, el testing va mas orientado, a comprobar si tal compoentes efectivamente se renderiza en pantalla, o si hay cierta informacion en el base de datos, caracteristicas orientadas a los permisos de administrador, resrecto al acceso a la interfaz de edicion de la aplicacion.
   


