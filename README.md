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

> Nota: la propiedad blockWidth es importante por que representa el número de caracteres
> máximo que puede entrar en una linea de un papel termico, el valor de esta propiedad se usa
> para alinear correctamente los textos, imágenes o qr. Por defecto su valor es de 42, debido a que es
> el mas común, pero para ticketeras de 72 mm se tiene que configurar 48, importante ir probando cual seria
> el valor mas acertado.

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

Para representar una imágen creamos una instancia de la clase SmgImageBlock mediante su método build()
y pasando como argumento obligatorio la ruta absoluta local a la imagen en la pc donde esta instalado PukaHTTP.
Si la imágen no existe en esa ruta, entonces la impresión del bloque de imagen sera ignorada,
esto con el objetivo de no afectar a los demás bloques de diseño.

```injectablephp
$imageBlock = SmgImageBlock::build("/home/socamaru/Descargas/logos/gato.png");
$printObject = SmgPrintObject::build()->block($imageBlock);
```

Opcionalmente, se puede personalizar propiedades como el
tipo de escalado de imagen , ancho , altura y alineación.

```injectablephp
$imageBlock = SmgImageBlock::build("/home/socamaru/Descargas/logos/gato.png")
    ->width(240)
    ->height(400)
    ->size(290)
    ->center()
    ->aling(SmgJustify::CENTER)
    ->left()
    ->aling(SmgJustify::LEFT)
    ->right()
    ->aling(SmgJustify::RIGHT)
    ->scale(SmgScale::SMOOTH);
    
$printObject = SmgPrintObject::build()->block($imageBlock);
```

Importante mencionar que que si la imagen no esta correctamente alineado,
puede deberse a que el parametro blockWidth no tiene un valor acertado.
El valor de blockWidth por defecto es de 42 caracteres por linea, para papeles termicos de 72 mm
el tamaño deseado seria 48 esto se puede configurar en las propiedades de configuración del
objeto de impresión.

```injectablephp
$imageBlock = SmgImageBlock::build("/home/socamaru/Descargas/logos/gato.png")->center();
...
$config = SmgPrintObjectConfig::instance()
    ->blockWidth(48); // 48 para papeles termicos de 72 mm
$printObject = SmgPrintObject::build($config) // !Importante pasar el objeto $config al metodo build del SmgPrintObject
    ->block($imageBlock);
```

### Código Qr

Para representar un código qr, se be instanciar un objeto SmgQrBlock mediante su método estatico build()
y pasando como argumento obligatorio el stringQr (data).

```injectablephp
$qrBlock = SmgQrBlock::build("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|");
...
$config = SmgPrintObjectConfig::instance()->blockWidth(48);
$printObject = SmgPrintObject::build($config)->block($qrBlock);
```

Igual que las imágenes, el qr tambien se puede personalizar la alineación, el tamaño y su escalado.
Debido a que el código qr debe ser cuadrado, se implementa un método size() para configurar su ancho y altura
con el mismo valor.

```injectablephp
$qrBlock = SmgQrBlock::build("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|")
    ->center()
    ->size(290)
    ->scale(SmgScale::SMOOTH);
...
$config = SmgPrintObjectConfig::instance()->blockWidth(48);
$printObject = SmgPrintObject::build($config)->block($qrBlock);
```

#### Configuración propiedades Qr

Opcionalmente se puede configurar el nivel de corrección de error, y el tipo de QR.

```injectablephp
$qrConfig = SmgQrConfig::instance()->low()->native();
$qrBlock = SmgQrBlock::build("20450523381|01|F001|00000006|0|9.00|30/09/2019|6|sdfsdfsdf|", $qrConfig)
    ->center()
    ->size(290)
    ->scale(SmgScale::SMOOTH);
$config = SmgPrintObjectConfig::instance()->blockWidth(48);
$printObject = SmgPrintObject::build($config)->block($qrBlock);
```

Los niveles de corrección de error permitidos son low, medium, high y quartile.
Por defecto, si no se configura, es quartile.

```injectablephp
$qrConfig = SmgQrConfig::instance()
    ->low()
    ->medium()
    ->high()
    ->quartile();
...
```

##### ¿Qr Type?

El tipo de qr es una propiedad especial que indica como debe ser tratado el Qr,
existen dos formas, "native" y "img", "native" significa que el qr sera tratado de forma nativa
por la impresora termica y "img" índica que el qr sera tratado previamente como imagen y luego
imprimirse como imagen.

###### ¿Cual escoger?

Por defecto el tipo es "img", ya que asegura que se respetara la propiedad blockWidth para alinear
correctamente el qr. Existen ticketeras que no son compatibles con los comandos de alineación,
es por eso que SweetTicketDesign se encarga de tratar el qr como imagen para redimensionarlo y alinearlo y enviarlo
en formato imagen a la impresora termica. Asegurando la correcta alineación del qr en cualquier ticketera (siempre y cuando
la impresora termica soporte imágenes).

```injectablephp
$qrConfig = SmgQrConfig::instance()->likeImg() // valor por defecto
...
```

Si se configura como "native", entonces sera la misma ticketera encargada de generar y alinear el qr.
esto no asegura la correcta impresión del código qr en algunas ticketeras, ya que cada impresora termica interpreta el código
qr de forma distinta. Esto quizas sea util si la impresora termica no soporta imágenes, pero puede que si soporte impresión de
código qr de forma nativa.

```injectablephp
$qrConfig = SmgQrConfig::instance()->native()
...
```

Otra diferencias son:

- La propiedad "scale" solo funciona si el Qr Type es "img".
- La propiedad "size" varia de 1 a 16 si el Qr Type es "native", siendo 16 el tamaño maximo posible.
- En cambio si es "img", la propiedad "size", no tiene limite, siendo 16 un tamaño muy pequeño y 290 un
  tamaño aceptable (similar a size=16 en nativo.).
