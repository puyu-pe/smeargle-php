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
$styles = new SmgMapStyles();
$styles->set(0, SmgStyle::builder()->span(2)); // styles for column 0
$styles->set(1, SmgStyle::builder()->maxSpan()); // styles for column 1

$testPrintConfig = SmgTextBlockConfig::instance()->styles($styles);
$testPrintBlock = SmgTextBlock::build($testPrintConfig)
    ->text("Servicio de impresión PUKA  PUYU", SmgStyle::builder()->center()->maxSpan()->fontSize(2)->bold())
    ->text("Esta es una prueba de impresión.", SmgStyle::builder()->center()->maxSpan())
    ->line("*")
    ->row(new SmgRow(["printer:", "192.168.18.39"]), new SmgRow(["type:", "ethernet"]))
    ->line()
    ->text("Gracias que tenga un buen dia.", SmgStyle::builder()->center()->maxSpan());

$printConfig = SmgPrintObjectConfig::instance()->blockWidth(48);
$jsonString = SmgPrintObject::build($printConfig)->block($testPrintBlock)->toJson();
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
