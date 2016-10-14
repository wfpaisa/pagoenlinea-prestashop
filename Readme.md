# Pago En Línea
Modulo de pagos en linea para prestashop 1.6, este modulo es una copia de Bank wire el cual se a limpiado para una mejor compresión, ademas facilita la integración con pasarelas de pago externas.

## Instalar
Descargar y descomprimir en la carpeta de modulos, luego renombrar la carpeta raiz por -> 'pagoenlinea'

### Modificar el estado por defecto del pedido antes de comprobar
Para esto debemos modificar el valor de una variable en dos archivos, haciendo que coincida:
- En `controllers/front/validation.php` la variable `$estado_pendiente` (guarda la orden per sale un error de confirmación)
- En `pagoenlinea.php` función hookPaymentReturn la valirable `$estado_pendiente`  (verifica es estado de la orden e imprime el archivo payment_return.tpl)

### Cambiar el estado de la orden
Los datos son redirigidos al archivo: `pages/confirmation.php` siente libre de modificar los datos para que coincidan con los datos retornados de la pasarela