<div align="center" width="100%">
  <img width="30%" src="logo.png" alt="imagen smeargle"/>
</div>

```textmate
   ▄▄▄▄▄   █▀▄▀█ ▄███▄   ██   █▄▄▄▄   ▄▀  █     ▄███▄   
  █     ▀▄ █ █ █ █▀   ▀  █ █  █  ▄▀ ▄▀    █     █▀   ▀  
▄  ▀▀▀▀▄   █ ▄ █ ██▄▄    █▄▄█ █▀▀▌  █ ▀▄  █     ██▄▄    
 ▀▄▄▄▄▀    █   █ █▄   ▄▀ █  █ █  █  █   █ ███▄  █▄   ▄▀ 
              █  ▀███▀      █   █    ███      ▀ ▀███▀   
             ▀             █   ▀                        
                          ▀                             
```

![Packagist License](https://img.shields.io/packagist/l/puyu-pe/smeargle-php)
![Packagist Version](https://img.shields.io/packagist/v/puyu-pe/smeargle-php)
![Packagist Stars](https://img.shields.io/packagist/stars/puyu-pe/smeargle-php)

[Smeargle](https://www.youtube.com/watch?v=Y9DENCQMSgQ) es un conjunto de utilidades y clases escrita en php según las especificaciones en formato
json de [SweetTicketDesign](https://github.com/puyu-pe/SweetTicketDesign/tree/develop)
para el diseño de tickets que seran emitidas a ticketeras termicas
con la ayuda de [PukaHTTP](https://github.com/puyu-pe/puka-http).

## Indice :card_index_dividers:

1. [¿Cómo funciona?](#funcionamiento-bookmark_tabs)
2. [Utilidades](#utilidades-toolbox)
3. [Bloques de texto](#textos-y-tablas-con-estilos)
4. [Imágenes](#imágenes)
5. [Código QR](#código-qr)

## Comenzando :rocket:

Agregar la libreria mediante composer.

```shell
composer require puyu-pe/smeargle-php
```

![Packagist Downloads](https://img.shields.io/packagist/dt/puyu-pe/smeargle-php)
![GitHub Release Date](https://img.shields.io/github/release-date/puyu-pe/smeargle-php)

## Funcionamiento :bookmark_tabs:

Smeargle es un conjunto de clases y utilidades para la generación de un objecto json
que representa un documento de impresión para [PukaHTTP](https://github.com/puyu-pe/puka-http).
El objecto json esta construido segun la api de [SweetTicketDesign](https://github.com/puyu-pe/SweetTicketDesign/tree/develop).

### Core de la libreria

Los componentes principales de la libreria son 4, según las especificaciones de
SweetTicketDesign.

```json
{
    "properties": {
    },
    "data": {
    },
    "openDrawer": {
    },
    "styles": {
    }
}
```

Para cada uno de los componentes principales existen sus respectivas clases
SmgProperties (properties), SmgTextBlock - SmgImageBlock - SmgQrBlock (data),
SmgDrawer (opendrawer) y SmgMapStyles (styles).

```php
$styles = SmgMapStyles::builder()
    ->addGlobalStyle(Smg::normalize())
    ->set("centerBoldStyleClass", Smg::centerBold());

$properties = SmgProperties::builder()
    ->setBlockWidth(48);

$text = SmgTextBlock::builder()
    ->addText("hello world. áéíóú")
    ->addCell(SmgCell::build("title", "centerBoldStyleClass"));
$image = SmgImageBlock::builder()->setPath("/home/images/logo.png");
$qr = SmgQrBlock::builder()->setData("dfadsf|sadfsadf|dsfasdf|dafsa|fadsfsa");
```

El objeto json que representa a todos los componentes se le denomina
SmgPrintObject, una instancia de esta clase ayuda a registrar cada componente
en el objeto de impresión.

```php
$printObject = SmgPrintObject::builder()
    ->setStyles($styles)
    ->setProperties($properties)
    ->openDrawer()
    ->addBlock($text)
    ->addBlock($qr)
    ->addBlock($image);
```

El metodo toJson() del objeto SmgPrintObject genera el json string que es
lo que finalmente se enviará a PukaHTTP

```
echo json_encode(json_decode($printObject->toJson(), true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
```

Diseñar con smeargle puro implica crear primeramente los estilos asociados
a clases para luego diseñar la disposición de los textos, images y qr en base a estas clases.
El objeto SmgPrintObject es el que finalmmente ayuda a integrar cada uno de los 4 componentes
representando de esta manera un objeto de impresión.

```php
$printObject = SmgPrintObject::builder()
    ->setStyles($styles)         // styles
    ->setProperties($properties) // properties
    ->openDrawer()               // openDrawer
    ->addText("hello world")     // data
    ->addBlock($text)            // data
    ->addBlock($qr)              // data
    ->addBlock($image);          // data
    ->toJson();                  // json string to send PukaHTTP
```

Jugar con los 4 componentes permite crear varios diseños de impresión,
sin embargo sigue siendo algo complejo de administrar. Es por ello
que smeargle-php trae incluido una serie de utilidades para diseñar
de forma mas descriptiva y sencilla los documentos de impresión.

## Utilidades :toolbox:

Jugar con los 4 componentes permite crear varios diseños de impresión,
sin embargo sigue siendo algo complejo de administrar. Es por ello
que smeargle-php trae incluido una serie de utilidades para diseñar
de forma mas descriptiva y sencilla los documentos de impresión.

* **Smg**, shortcuts para styles y properties
* **SmgStylizedRow**, representa una fila de impresión con estilos y generación de clases automáticas.
* **SmgTextLayout**, mejora el modo de diseño de bloques de texto y tambien aprovecha la generación de clases automáticas
* **SmgTicket**, incluye una serie de metodos para mejorar el mecanismo de diseño de los documentos de impresión.

### La clase SmgTicket

SmgTicket pretende ser una plantilla generica para el diseño de tickets
Se puede crear una instancia de la clase SmgTicket con su método estatico builder().

```php
$ticket = SmgTicket::builder()
```

Opcionalmente se puede pasar un objeto properties y un conjunto de estilos.

```php
$properties = SmgProperties::builder()->setBlockWidth(48);
$styles = new SmgMapStyles();
$styles->addGlobalStyle(Smg::normalize(true));
$ticket1 = SmgTicket::builder($properties, $styles)
$ticket2 = SmgTicket::builder($properties);
$ticket3 = SmgTicket::builder(null, $styles);
```

Con una instancia de SmgProperties se configura el blockWidth que es una representación
abstracta del número de caracteres máximo con tamaño de fuente pequeña,
que puede contener una linea en el papel termico. Es importante establecer
este valor, de acuerdo al ancho del papel termico, por lo general sus valores suelen
ser 42 y 48 para la mayoria de papeles termicos.

Opcionalmente también se pude personalizar el método de corte que se realiza
siempre al finalizar el trabajo de impresión.

```php
$properties = SmgProperties::builder()
    ->setCut(SmgCutProperty::builder()
        ->feed(2)
        ->mode(SmgCutMode::FULL))
    ->setBlockWidth(48);
```

También se puede configurar estilos globales validos en todo el objeto de impresión,
esto puede ser util si en caso sea necesario normalizar todo el documento de impresión
o aplicar algun estilo global por defecto.

```php
$styles = SmgMapStyles::builder()
    ->addGlobalStyle(Smg::normalize(true))
    ->addGlobalStyle(Smg::center());
```

### Textos y tablas con estilos.

Utilizando una instancia de la clase SmgTicket podemos diseñar bloques de texto
que ocupen todo una linea del documento de impresión o tambien se puede dividir la linea
en columnas, para representar columnas se necesita una instancia de SmgStylizedRow.

```php
$ticket = SmgTicket::builder()
    ->addText("title", Smg::title())
    ->addRow(SmgStylizedRow::build()
        ->add("column1", Smg::leftBold())
        ->add("column2", Smg::centerBold()))
    ->addLine('*')
    ->addLine('-')
    ->addLine();
```

### Imágenes

Para representar una imágen creamos una instancia de la clase SmgImageBlock mediante su método estatico builder(),
utilizando esta instancia se puede configurar una ruta local a la imagen.

```php
$imageBlock = SmgImageBlock::builder()->setPath("/home/images/logo.png");
```

Los estilos configurables para las imágenes, son width, height, scale, align

```php
$imageBlock = SmgImageBlock::builder()->setPath("/home/images/logo.png");
$ticket = SmgTicket::builder($properties, $styles)
    ->addImage($img, Smg::width(290)->height(290)->scale(SmgScale::SMOOTH)->center())
```

Importante mencionar que que si la imagen no esta correctamente alineada,
puede deberse a que el parametro blockWidth no tiene un valor acertado.
El valor de blockWidth por defecto es de 42 caracteres por linea, para papeles termicos de 72 mm
el tamaño deseado seria 48.

### Código Qr

Para representar un código qr, se debe instanciar un objeto SmgQrBlock mediante 
su método estatico builder() y se configurar el stringQr mediante el método setData().

```php
$qr = SmgQrBlock::builder()->setData("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|");
```

Igual que las imágenes, tambien es posible configurar estilos
para un objeto qr como width, height, scale y align.

```php
$qr = SmgQrBlock::builder()->setData("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|");
$ticketJson = SmgTicket::builder()
    ->addQrCode($qr, Smg::width(290)
        ->height(290)
        ->scale(SmgScale::SMOOTH)
        ->center())
    ->toJson();
```

#### Configuración propiedades Qr

Opcionalmente se puede configurar el nivel de corrección de error, y el tipo de QR.

```php
$qr = SmgQrBlock::builder()
    ->setData("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|")
    ->setCorrectionLevel(SmgQrErrorLevel::H)
    ->setQrType(SmgQrType::NATIVE);
```

Los niveles de corrección de error permitidos son low, medium, high y quartile.
Por defecto, si no se configura, es quartile.

```php
$qr = SmgQrBlock::builder()
    ->setCorrectionLevel(SmgQrErrorLevel::L)
    ->setCorrectionLevel(SmgQrErrorLevel::M)
    ->setCorrectionLevel(SmgQrErrorLevel::H)
    ->setCorrectionLevel(SmgQrErrorLevel::Q);
...
```

##### ¿Qr Type?

El tipo de qr es una propiedad especial que indica como debe ser tratado el Qr,
existen dos formas, "native" y "img". El modo "native" significa que el qr sera tratado de forma nativa
por la impresora termica y "img" índica que el qr sera tratado previamente como imagen y luego
imprimirse como imagen.

###### ¿Cual escoger?

Por defecto el tipo es "img", ya que asegura que se respetara la propiedad blockWidth para alinear
correctamente el qr. Existen ticketeras que no son compatibles con los comandos de alineación,
es por eso que SweetTicketDesign se encarga de tratar el qr como imagen para redimensionarlo y alinearlo y enviarlo
en formato imagen a la impresora termica. Asegurando la correcta alineación del qr en cualquier ticketera (siempre y cuando
la impresora termica soporte imágenes).

```php
$qr = SmgQrBlock::builder()->setQrType(SmgQrType::IMG) // por defecto;
```

Si se configura como "native", entonces sera la misma ticketera encargada de generar y alinear el qr.
esto no asegura la correcta impresión del código qr en algunas ticketeras, ya que cada impresora termica interpreta el código
qr de forma distinta. Esto quizas sea util si la impresora termica no soporta imágenes, pero puede que si soporte impresión de
código qr de forma nativa.

```php
$qr = SmgQrBlock::builder()->setQrType(SmgQrType::NATIVE);
```

Otra diferencias son:

- La propiedad "scale" solo funciona si el Qr Type es "img".
- La propiedad "size" varia de 1 a 16 si el Qr Type es "native", siendo 16 el tamaño maximo posible.
- En cambio si es "img", la propiedad "size", no tiene limite, siendo 16 un tamaño muy pequeño y 290 un
  tamaño aceptable (similar a size=16 en nativo.).
