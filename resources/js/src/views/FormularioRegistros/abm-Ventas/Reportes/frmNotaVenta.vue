<template>
  <div>
    <button @click="generatePDF">Generar PDF</button>
    <div id="contenido-pdf">
      <!-- Contenido HTML que deseas convertir a PDF -->
      <h1>Nota de Venta</h1>
      <p><strong>Cliente:</strong> Cliente de ejemplo {{ $store.state.app.NombreEmpresa }}</p>
      <!-- Otros detalles de la nota de venta -->
    </div>
  </div>
</template>

<script>

import jsPDF from 'jspdf';
import 'jspdf-autotable';

export default {
  data() {
    return {


    };
  },
  methods: {
    generatePDF() {
      // Crear un nuevo documento PDF
      const doc = new jsPDF();
      let me = this;
      // Agregar el logo de la empresa (reemplaza 'ruta_al_logo' con la ruta de tu imagen)
      const xLogo = 10; // Posición x de la imagen
      const yLogo = 10; // Posición y de la imagen
      const anchoLogo = 50; // Ancho de la imagen
      const altoLogo = 50; // Alto de la imagen
      const image = new Image();
      var imgData = 'data:image/png;base64,' + me.$store.state.app.LogoEmpresa;
      doc.addImage(imgData, 'PNG', 5, 5, 25, 25);


      doc.setFont('helvetica', 'neue')
      // doc.setFont('helvetica', 'bold');

      doc.setFontSize(18);
      // Configuración de la nota de venta
      const notaDeVenta = {
        numero: 'VE000001',
        fecha: '7 de noviembre de 2023',
        cliente: 'Ernesto Noco Ipavari',
        direccion: '123 Calle Principal',
        ciudad: 'Ciudad Ejemplo',
      };

      // Datos de los productos
      const productos = [
        { nombre: 'Producto 1', cantidad: 2, precio: 20 },
        { nombre: 'Producto 2', cantidad: 3, precio: 15.50 },
        { nombre: 'Producto 3', cantidad: 1, precio: 30 },
        { nombre: 'Producto 4', cantidad: 5, precio: 10 },
      ];

      // Crear una tabla para los productos
      const columns = ['Nombre', 'Cantidad', 'Precio', 'Total'];
      const rows = productos.map((producto) => [
        producto.nombre,
        producto.cantidad,
        `${producto.precio.toFixed(2)}`,
        `${(producto.cantidad * producto.precio).toFixed(2)}`,
      ]);

      // Agregar el encabezado de la nota de venta

      doc.setFontSize(22);
      doc.setFont('helvetica', 'neue')
      doc.text('Nota de Venta', 145, 10, 'center');
      doc.setFontSize(14);
      doc.setFont('helvetica', 'neue')


      doc.text('N°:', 125, 20);
      doc.setTextColor(110, 107, 123);
      doc.text(`${notaDeVenta.numero}`, 135, 20);
      doc.setTextColor(0);
      doc.setFont('helvetica', 'neue')
      doc.text(`Fecha: ${notaDeVenta.fecha}`, 125, 28);
      doc.setFont('helvetica', 'neue')
      doc.setTextColor(0)
      doc.text("Cliente:", 5, 52);
      doc.setTextColor(100)
      doc.setFont('helvetica', 'neue')
      doc.text(`${notaDeVenta.cliente}`, 25, 52);

      // doc.text(`Dirección: ${notaDeVenta.direccion}`, 10, 44);
      // doc.text(`Ciudad: ${notaDeVenta.ciudad}`, 10, 52);
      // Agregar la tabla de productos
      doc.autoTable({
        startY: 60,
        head: [columns],
        body: rows,
      });

      // Calcular el total
      const total = productos.reduce((acc, producto) => acc + producto.cantidad * producto.precio, 0);
      doc.setFont('helvetica', 'neue')
      doc.text(`Total Bs.: ${total.toFixed(2)}`, 145, doc.autoTable.previous.finalY + 10);

      doc.setFont('times', 'normal');
      doc.setFontSize(12);

      //// hasta aqui
      // Guardar el documento PDF
      // doc.save('nota_de_venta.pdf');
      // Guardar el documento PDF como un Data URI
      const dataUri = doc.output('datauristring');

      // Abrir el PDF en una nueva ventana o pestaña
      const newWindow = window.open();
      newWindow.document.write('<iframe width="100%" height="100%" src="' + dataUri + '"></iframe');
    },
  }
};

</script>

