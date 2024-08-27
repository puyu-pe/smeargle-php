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

### Ejemplo :bookmark_tabs:

```injectablephp
$printer = ["name" => "192.168.18.39", "type" => "ethernet"];
$printConfig = SmgPrintObjectConfig::instance()->info("printer", $printer);
$jsonString = SmgPrintObject::build($printConfig)
    ->text("hello word.")
    ->toJson();
send_data($jsonString); // ejm. send data to local server PukaHTTP
```

## Bloques de texto :heavy_check_mark:

Con componentes de texto, se puede crear diseños para tablas o simples
fragmentos de texto con la posibilidad de manipular la disposición de
cada elemento mediante configuraciones de estilo.

### Ejemplos

- Prueba de impresión

```injectablephp
$testPrintConfig = SmgTextBlockConfig::instance()
    ->styleForColumn(0, Smg::span(2))
    ->styleForColumn(1, Smg::maxSpan());

$test = new SmgVerticalLayout($testPrintConfig);
$test
    ->title("Servicio de impresión PUKA - PUYU")
    ->toCenter("Esta es una prueba de impresión")
    ->line("*")
    ->row(new SmgRow(["name_system:", "192.168.18.39"]))
    ->row(new SmgRow(["port:", "9100"]))
    ->row(new SmgRow(["blockWidth:", "48"]))
    ->line()
    ->toCenter("Gracias, que tenga  un buen dia.");

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printObjectConfig)->block($test)->toJson();
send_data($jsonString); // ejm. send data to local server PukaHTTP
```

- Tabla de 3 columnas

```injectablephp
$styles = new SmgMapStyles();
$styles->set(1, SmgStyle::builder()->center());
$styles->set(2, SmgStyle::builder()->right());
$styles->set("title", SmgStyle::builder()->center()->bold()->fontSize(2)->maxSpan());
$styles->set("totalStr", SmgStyle::builder()->right()->maxSpan()->bold()->span(4));
$styles->set("totalPrice", SmgStyle::builder()->right()->maxSpan()->bold());

$header = new SmgRow(["Name", "Units", "Price"]);
$body = array_map(function ($item) {
    return new SmgRow([$item["name"], $item["units"], $item["price"]]);
}, $items);
$footer = new SmgRow([
    new SmgCell("Total:", "totalStr"),
    new SmgCell($total, "totalPrice")
]);

$tableConfig = SmgTextBlockConfig::instance()->styles($styles)->separator("|");
$table = SmgTextBlock::build($tableConfig)
    ->text("Tabla de precios", "title")
    ->row($header)
    ->line()
    ->rows($body)
    ->line()
    ->row($footer);

$printObjectConfig = SmgPrintObjectConfig::instance()->blockWidth(48)->openDrawer();
$jsonString = SmgPrintObject::build($printObjectConfig)->block($table)->toJson();
send_data($jsonString); // ejm. send data to local server PukaHTTP
```

## Imagenes :heavy_check_mark:


## Qr :heavy_check_mark:
