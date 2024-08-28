```textmate
   ▄▄▄▄▄   █▀▄▀█ ▄███▄   ██   █▄▄▄▄   ▄▀  █     ▄███▄   
  █     ▀▄ █ █ █ █▀   ▀  █ █  █  ▄▀ ▄▀    █     █▀   ▀  
▄  ▀▀▀▀▄   █ ▄ █ ██▄▄    █▄▄█ █▀▀▌  █ ▀▄  █     ██▄▄    
 ▀▄▄▄▄▀    █   █ █▄   ▄▀ █  █ █  █  █   █ ███▄  █▄   ▄▀ 
              █  ▀███▀      █   █    ███      ▀ ▀███▀   
             ▀             █   ▀                        
                          ▀                             
```

Smeargle es un conjunto de utilidades y clases escrita en php según las especificaciones en formato json
de [SweetTicketDesign](https://github.com/puyu-pe/SweetTicketDesign/tree/develop)
para el diseño de tickets que seran emitidas a ticketeras termicas
con la ayuda de [PukaHTTP](https://github.com/puyu-pe/puka-http).

## Indice :card_index_dividers:

1. [Comenzando](#comenzando-rocket)
2. [Bloques de texto](#bloques-de-texto-heavy_check_mark)
3. [Imagenes](#imagenes-heavy_check_mark)
4. [Qr](#qr-heavy_check_mark)

## Comenzando :rocket:

### Instalación :hammer_and_wrench:

```shell
composer require puyu-pe/smeargle 
```

## ¿Cómo funciona? :bookmark_tabs:

Smeargle es un conjunto de clases y utilidades para la generación de un objecto json
que representa un documento de impresión para [PukaHTTP](https://github.com/puyu-pe/puka-http).
El objecto json esta construido segun la api de [SweetTicketDesign](https://github.com/puyu-pe/SweetTicketDesign/tree/develop).

### La clase SmgPrintObject

SmgPrintObject representa un objeto de impresión que puede ser enviado a PukaHTTP.
Para crear una instancia de esta clase se debe llamar a su método estatico build.

```injectablephp
$printObject = SmgPrintObject::build();
```

Con una instancia de SmgPrintObject podemos agregar texto basico sin estilos o bloques de diseño.

```injectablephp
$printObject = SmgPrintObject::build();
$printObject->text("hello word")
$printObject->text("otro texto en la siguiente linea")
$printObject->block($textBlock)
$printObject->block($imageBlock)
$printObject->block($qrBlock)
```

Se puede pasar una instancia de SmgPrintObjectConfig al metodo estatico build, para definir
algunos metadatos o configuraciones opcionales adicionales.

```injectablephp
$config = SmgPrintObjectConfig::instance()
    ->blockWidth(48) // Configura el numero de caracteres por linea del papel termico
    ->normalize() // indica si se debe normalizar todo el contenido de impresión
    ->info("key", "value") // agrega metadatos en formato clave valor
    ->info("printer", $printer) 
    ->info("time", 2) 
    ->openDrawer() // Habilita abrir gaveta de dinero al finalizar el trabajo de impresión;
    
$printObject = SmgPrintObject::build($config);
```

Opcionalmente se puede configurar algunos parametros para abrir la gaveta de dinero
, por lo general esto no es necesario, ya que con sus valores por defecto es suficiente
en la gran mayoria de casos.

```injectablephp
$customOpenDrawer SmgDrawer::builder()
    ->pin(SmgDrawerPin::_2)
    ->t2(120)
    ->t2(240);
$config = SmgPrintObjectConfig::instance()
    ...
    ->openDrawer($customOpenDrawer);
    ...
$printObject = SmgPrintObject::build($config);
```

Siempre, al finalizar el trabajo de impresión se realiza un corte automático con
feed 4 y de forma parcial. Sin embargo también se puede personalizar esto según las necesidades
, pero con los valores por defecto se cubre una gran mayoria de casos de uso.

```injectablephp
...
$config = SmgPrintObjectConfig::instance()
    ->cut(SmgCutProperty::builder()->mode(SmgCutMode::FULL)->feed(2))
...
$printObject = SmgPrintObject::build($config);
```

## Bloques de diseño :art:

Los bloques de diseño representan componentes complejos en un documento de impresión,
con componentes de texto se puede representar diferentes tipos de disposición de texto
en un documento de impresión, con componentes de imágenes se puede personalizar la ubicación y la forma
en la que se debe mostrar la imagen en el documento de impresión. Lo mismo con componentes QR para personalizar
su tamaño o nivel de error.

### Texto con SmgVerticalLayout

SmgVerticalLayout es un envoltorio para la clase SmgTextBlock que agrega utilidades
para un diseño de texto mas flexible en disposición vertical. SmgTextBlock es una clase con metodos mas complejos
y con casos de uso mas genericos, por lo que su uso no se documentara en esta sección.

Por ejemplo para representar un texto que se debe imprimir al centro de la hoja;

```injectablephp
$layout = SmgVerticalLayout()->build()
    ->toCenter("texto al centro");
```

Despues de definir un bloque de díseño, se debe adjuntar al objeto de impresión usando el método
block() de alguna instancia de SmgPrintObject, de lo contrario no se tomara en cuenta a la hora
de enviar los el objeto de impresión a PukaHTTP.

Por ejemplo, para considera el anterior bloque SmgVerticalLayout ($layout) en el objeto de impresión:

```injectablephp
$layout = SmgVerticalLayout()->build()
    ->toCenter("texto al centro");
...

$printObject = SmgPrintObject::build()->block($layout);
```

### Estilos con SmgStyle

SmgStyle es un objeto de estilo que representa un conjunto de propiedades de diseño
de un texto, imagen o qr. Para crear un
objeto de estilo se tiene que invocar al método builder() de la clase SmgStyle y
configurar las propiedades necesarias a partir de ahi.

```injectablephp
$boldStyle = SmgStyle()->builder()->bold();
$boldCenterStyle = SmgStyle()->builder()->bold()->center();
$boldCenterStyleMaxSpan = SmgStyle()->builder()->bold()->center()->maxSpan();
$otherStyle = SmgStyle()->builder()->bgInverted()->pad("*"); 
...
```

Alternativamente, la clase Smg trae varios metodos compuestos que facilitan la creación de estilos

```injectablephp
$style = Smg::centerBoldMaxSpan()->pad("*");
$title = Smg::title(); // igual a SmgStyle::builder()->center()->bold()->fontSize(2)->maxSpan()
$subtitle = Smg::subtitle(); // igual a SmgStyle::builder()->left()->bold()->maxSpan()
```

### SmgVerticalLayout con estilos

En la mayoria de métodos de SmgVerticalLayout se puede configurar un objeto de estilo
por ejemplo si se quiere representar un texto que se debe imprimir al centro y en negrita
usariamos:

```injectablephp
$layout = SmgVerticalLayout::build()
    ->toCenter("al centro", Smg::bold());
...
```

Otros métodos utiles que trae SmgVerticalLayout son:

```injectablephp
$layout = SmgVerticalLayout()->build()
    ->toLeft("texto a la izquierda")
    ->toLeft("izquierda con estilo", Smg::bgInverted())
    ->toRight("texto a la derecha")
    ->toRight("derecha con estilo", Smg::pad(*))
    ->title("title");
    ->title("title adicional", Smg::bgInverted()->pad(*));
    ->custom("customizable", Smg::fontWidth(2)->right()->bold()->normalize()->span(2))
    ->line("*")
    ->subtitle("")
    ->line("*", Smg::bold())
    ->line()
    ->row(new SmgRow(["colum1", "column2"]))
    ->simpleRow(["colum1", "column2"])
    ->simpleRow(["colum1", "column2"], Smg::bold())
    ->rows(new SmgRow(["colum1", "column2"]), new SmgRow(["column1"]))
...

$printObject = SmgPrintObject::build()->block($layout);
```

### Mas ejemplos

A continuación se muestra como se representaria diseños basicos como
una prueba de impresión o una tabla de productos.

#### Prueba de impresión

```injectablephp
$testPrintConfig = SmgTextBlockConfig::instance()
    ->styleForColumn(0, Smg::span(2)) // style for column 1
    ->styleForColumn(1, Smg::maxSpan()); // style for column 2

$test = new SmgVerticalLayout($testPrintConfig);
$test
    ->title("Servicio de impresión PUKA - PUYU")
    ->toCenter("Esta es una prueba de impresión")
    ->line("*")
    ->simpleRow(["name_system:", "192.168.18.39"])
    ->simpleRow(["port:", "9100"])
    ->simpleRow(["blockWidth:", "48"])
    ->line()
    ->toCenter("Gracias, que tenga  un buen dia.");

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printObjectConfig)->block($test)->toJson();
send_data($jsonString); // ejm. send data to local server PukaHTTP
```

#### Tabla de productos

```injectablephp
$header = new SmgRow(["header1", "header2", "header3"], Smg::bold());

$body = array_map(function ($product) {
    return new SmgRow([$product["name"], $product["units"], $product["price"]]);
}, $products);

$footer = new SmgRow();
$footer->add("total:", Smg::bold()->right()->span(4));
$footer->add("450.47");

$tablePrintConfig = SmgTextBlockConfig::instance()
    ->separator("|")
    ->styleForColumn(0, Smg::left())
    ->styleForColumn(1, Smg::center())
    ->styleForColumn(2, Smg::right());

$table = new SmgVerticalLayout($tablePrintConfig);
$table
    ->title("Tabla de ejemplo")
    ->line("*")
    ->row($header)
    ->line()
    ->rows($body)
    ->line()
    ->row($footer);

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printObjectConfig)->block($table)->toJson();
send_data($jsonString); // ejm. send data to local server PukaHTTP
```

### Imágenes

```injectablephp

```

### Qr

```injectablephp

```

## Bloques de texto :heavy_check_mark:

Con componentes de texto, se puede crear diseños para tablas o simples
fragmentos de texto con la posibilidad de manipular la disposición de
cada elemento mediante configuraciones de estilo.

### Ejemplos

- Prueba de impresión

## Imagenes :heavy_check_mark:

## Qr :heavy_check_mark:
