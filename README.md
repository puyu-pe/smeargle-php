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

### Api :bookmark_tabs:

###

```injectablephp

```

## Bloques de texto :heavy_check_mark:

Con componentes de texto, se puede crear diseños para tablas o simples
fragmentos de texto con la posibilidad de manipular la disposición de
cada elemento mediante configuraciones de estilo.

### Ejemplos

- Prueba de impresión

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

- Tabla de productos

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

## Imagenes :heavy_check_mark:

## Qr :heavy_check_mark:
