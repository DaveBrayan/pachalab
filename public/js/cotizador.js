/**
 * PachaLab - Motor de Cotizaciones Referenciales Online y Generación de PDF
 */
(function() {
  'use strict';

  // 1. Convertir números a palabras en español
  function numeroAPalabras(numero) {
    const num = parseFloat(String(numero).replace(/,/g, ''));
    if (isNaN(num)) return 'Cero 00/100';

    const unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    const decenas = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    const decenasCompuestas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    if (num === 0) return 'cero 00/100';
    if (num === 100) return 'cien 00/100';

    let resultado = '';
    const entero = Math.floor(num);

    if (entero >= 1000) {
      const miles = Math.floor(entero / 1000);
      if (miles === 1) {
        resultado += 'mil ';
      } else {
        resultado += unidades[miles] + ' mil ';
      }
    }

    const resto = entero % 1000;
    if (resto >= 100) {
      if (resto === 100) {
        resultado += 'cien ';
      } else {
        resultado += centenas[Math.floor(resto / 100)] + ' ';
      }
    }

    const restoDecenas = resto % 100;
    if (restoDecenas >= 20) {
      resultado += decenasCompuestas[Math.floor(restoDecenas / 10)] + ' ';
      if (restoDecenas % 10 !== 0) {
        resultado += 'y ' + unidades[restoDecenas % 10] + ' ';
      }
    } else if (restoDecenas >= 10) {
      resultado += decenas[restoDecenas - 10] + ' ';
    } else if (restoDecenas > 0) {
      resultado += unidades[restoDecenas] + ' ';
    }

    return (resultado.trim().charAt(0).toUpperCase() + resultado.trim().slice(1)) + ' 00/100';
  }

  window.numeroAPalabras = numeroAPalabras;

  // 2. Base de datos de opciones según el módulo
  window.initCotizador = function(config) {
    const { tipo, fondoUrl, empresa = 'PachaLab - Pachabol' } = config;

    const tbody = document.getElementById('calc-tbody');
    const totalEl = document.getElementById('calc-total');
    const btnAdd = document.getElementById('btn-add-item');
    const btnPdf = document.getElementById('btn-generate-pdf');
    const template = document.getElementById('calc-row-template');

    if (!tbody || !btnAdd || !btnPdf) return;

    // Calcular subtotal de una fila
    function recalcularFila(tr) {
      const select = tr.querySelector('.item-select');
      const qtyInput = tr.querySelector('.item-qty');
      const priceTd = tr.querySelector('.col-price');
      const subtotalTd = tr.querySelector('.col-subtotal');

      if (!select) return;

      const selectedOpt = select.selectedOptions[0];
      let price = 0;

      if (selectedOpt && selectedOpt.value) {
        price = parseFloat(selectedOpt.dataset.precio || 0);

        // Actualizar columnas dinámicas según tipo
        if (tipo === 'equipos') {
          const carTd = tr.querySelector('.col-caracteristicas');
          const codTd = tr.querySelector('.col-codigo');
          if (carTd) carTd.textContent = selectedOpt.dataset.caracteristicas || '-';
          if (codTd) codTd.textContent = selectedOpt.dataset.codigo || '-';
        } else {
          const metTd = tr.querySelector('.col-metodologia');
          const uniTd = tr.querySelector('.col-unidad');
          if (metTd) metTd.textContent = selectedOpt.dataset.metodologia || '-';
          if (uniTd) uniTd.textContent = selectedOpt.dataset.unidad || '-';
        }
      } else {
        if (tipo === 'equipos') {
          const carTd = tr.querySelector('.col-caracteristicas');
          const codTd = tr.querySelector('.col-codigo');
          if (carTd) carTd.textContent = '-';
          if (codTd) codTd.textContent = '-';
        } else {
          const metTd = tr.querySelector('.col-metodologia');
          const uniTd = tr.querySelector('.col-unidad');
          if (metTd) metTd.textContent = '-';
          if (uniTd) uniTd.textContent = '-';
        }
      }

      const qty = parseFloat(qtyInput ? qtyInput.value : 1) || 0;
      const subtotal = price * qty;

      if (priceTd) priceTd.textContent = price.toFixed(2);
      if (subtotalTd) subtotalTd.textContent = subtotal.toFixed(2);

      recalcularTotal();
    }

    // Calcular total global
    function recalcularTotal() {
      let total = 0;
      tbody.querySelectorAll('tr').forEach(tr => {
        const subtotalTd = tr.querySelector('.col-subtotal');
        if (subtotalTd) {
          total += parseFloat(subtotalTd.textContent || 0) || 0;
        }
      });
      if (totalEl) {
        totalEl.textContent = total.toFixed(2);
      }
    }

    // Agregar nueva fila
    function agregarFila() {
      if (!template) return;
      const tempDiv = document.createElement('tbody');
      tempDiv.innerHTML = template.innerHTML.trim();
      const newTr = tempDiv.firstElementChild;
      tbody.appendChild(newTr);

      // Eventos de la nueva fila
      const select = newTr.querySelector('.item-select');
      const qtyInput = newTr.querySelector('.item-qty');
      const btnRemove = newTr.querySelector('.btn-remove-row');

      if (select) {
        select.addEventListener('change', () => recalcularFila(newTr));
      }
      if (qtyInput) {
        qtyInput.addEventListener('input', () => recalcularFila(newTr));
      }
      if (btnRemove) {
        btnRemove.addEventListener('click', () => {
          if (tbody.children.length > 1) {
            newTr.remove();
            recalcularTotal();
          } else {
            // Si solo queda una, la reiniciamos
            if (select) select.value = '';
            if (qtyInput) qtyInput.value = 1;
            recalcularFila(newTr);
          }
        });
      }

      if (window.lucide) lucide.createIcons();
    }

    // Eventos
    btnAdd.addEventListener('click', agregarFila);

    // Inicializar primera fila
    agregarFila();

    // Generar PDF con jsPDF y AutoTable
    btnPdf.addEventListener('click', async function() {
      try {
        const institucion = (document.getElementById('institucion') || {}).value || '-';
        const responsable = (document.getElementById('responsable') || {}).value || '';
        const departamento = (document.getElementById('departamento') || {}).value || '';
        const cargo = (document.getElementById('cargo') || {}).value || '';
        const telefono = (document.getElementById('telefono') || {}).value || '';
        const correo = (document.getElementById('correo') || {}).value || '';

        // Validaciones requeridas
        if (!responsable.trim()) {
          Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingrese el nombre del Responsable.' });
          document.getElementById('responsable').focus();
          return;
        }
        if (!departamento.trim()) {
          Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingrese el Departamento / Ciudad.' });
          document.getElementById('departamento').focus();
          return;
        }
        if (!telefono.trim()) {
          Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingrese el Teléfono / Celular de contacto.' });
          document.getElementById('telefono').focus();
          return;
        }
        if (!correo.trim()) {
          Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingrese el Correo electrónico.' });
          document.getElementById('correo').focus();
          return;
        }

        // Validar filas seleccionadas
        const rows = [];
        let itemsValidos = 0;

        tbody.querySelectorAll('tr').forEach(tr => {
          const select = tr.querySelector('.item-select');
          if (select && select.value) {
            itemsValidos++;
            const opt = select.selectedOptions[0];
            const qty = (tr.querySelector('.item-qty') || {}).value || 1;
            const precio = (tr.querySelector('.col-price') || {}).textContent || '0.00';
            const subtotal = (tr.querySelector('.col-subtotal') || {}).textContent || '0.00';

            if (tipo === 'equipos') {
              rows.push({
                equipo: opt.value,
                caracteristicas: opt.dataset.caracteristicas || '-',
                codigo: opt.dataset.codigo || '-',
                dias: qty,
                precio: precio,
                subtotal: subtotal
              });
            } else {
              rows.push({
                parametro: opt.value,
                metodologia: opt.dataset.metodologia || '-',
                unidad: opt.dataset.unidad || '-',
                cantidad: qty,
                precio: precio,
                subtotal: subtotal
              });
            }
          }
        });

        if (itemsValidos === 0) {
          Swal.fire({ icon: 'info', title: 'Seleccione un servicio', text: 'Por favor, agregue y seleccione al menos un parámetro o equipo en la lista.' });
          return;
        }

        // Mostrar spinner
        btnPdf.disabled = true;
        btnPdf.innerHTML = '<i data-lucide="loader-2" class="spin"></i> Procesando PDF...';
        if (window.lucide) lucide.createIcons();

        // Cargar librerías si faltan
        if (typeof window.jspdf === 'undefined') {
          await new Promise((res, rej) => {
            const s = document.createElement('script');
            s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            s.onload = res; s.onerror = rej;
            document.head.appendChild(s);
          });
        }
        if (typeof window.jspdf.jsPDF.prototype.autoTable === 'undefined') {
          await new Promise((res, rej) => {
            const s = document.createElement('script');
            s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js';
            s.onload = res; s.onerror = rej;
            document.head.appendChild(s);
          });
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'letter' });

        // Cargar imagen de fondo oficial
        if (fondoUrl) {
          try {
            const img = new Image();
            img.crossOrigin = 'Anonymous';
            img.src = fondoUrl;
            await new Promise((res, rej) => {
              img.onload = () => (img.width > 0 && img.height > 0) ? res() : rej();
              img.onerror = rej;
              setTimeout(rej, 4000);
            });
            doc.addImage({ imageData: img, x: 0, y: 0, width: 216, height: 279, compression: 'FAST' });
          } catch (e) {
            console.warn('Fondo de cotización omitido o cargado localmente:', e);
          }
        }

        // Número de cotización correlativo
        const numeroCotizacion = Math.floor(Math.random() * 50) + 50;
        const añoActual = new Date().getFullYear().toString().slice(-2);
        const numeroFormateado = String(numeroCotizacion).padStart(2, '0');
        const codigoCot = `${numeroFormateado}-${añoActual}-COT-REF`;

        doc.setProperties({
          title: `Cotización ${codigoCot} - ${empresa}`,
          subject: `Cotización de ${tipo === 'equipos' ? 'Alquiler de Equipos' : tipo}`,
          author: 'PachaLab - Pachabol'
        });

        const marginLeft = 20;
        let yPos = 38;

        // Título de la cotización
        doc.setFontSize(14);
        doc.setFont(undefined, 'bold');
        const text = `COTIZACIÓN N°: ${codigoCot}`;
        const textWidth = doc.getStringUnitWidth(text) * doc.getFontSize() / doc.internal.scaleFactor;
        const pageWidth = doc.internal.pageSize.getWidth();
        const textX = (pageWidth - textWidth) / 2;
        doc.text(text, textX, yPos);

        yPos += 8;
        doc.setFontSize(9);
        doc.setFont(undefined, 'normal');
        doc.setDrawColor(200, 200, 200);
        doc.line(marginLeft, yPos, 195, yPos);

        // Datos del cliente
        yPos += 5;
        doc.setFont(undefined, 'bold');
        doc.text('Institución/Empresa:', marginLeft, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(institucion, marginLeft + 42, yPos);
        doc.setFont(undefined, 'bold');
        doc.text('Atención a:', marginLeft + 95, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(responsable, marginLeft + 115, yPos);

        yPos += 5;
        doc.setFont(undefined, 'bold');
        doc.text('Departamento/Ciudad:', marginLeft, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(departamento, marginLeft + 42, yPos);
        doc.setFont(undefined, 'bold');
        doc.text('Cargo:', marginLeft + 95, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(cargo || '-', marginLeft + 115, yPos);

        yPos += 5;
        doc.setFont(undefined, 'bold');
        doc.text('Teléfono/celular:', marginLeft, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(telefono, marginLeft + 42, yPos);
        doc.setFont(undefined, 'bold');
        doc.text('Correo:', marginLeft + 95, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(correo, marginLeft + 115, yPos);

        yPos += 5;
        doc.setFont(undefined, 'bold');
        doc.text('Fecha de cotización:', marginLeft, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(new Date().toLocaleDateString('es-BO'), marginLeft + 42, yPos);
        doc.setFont(undefined, 'bold');
        doc.text('Cotizado:', marginLeft + 95, yPos);
        doc.setFont(undefined, 'normal');
        doc.text('Sistema PachaLab', marginLeft + 115, yPos);

        yPos += 8;
        doc.line(marginLeft, yPos, 195, yPos);

        // Sección 1: Propuesta Económica
        yPos += 5;
        doc.setFontSize(11);
        doc.setFont(undefined, 'bold');
        doc.text('1. PROPUESTA ECONÓMICA', marginLeft, yPos);

        yPos += 6;
        doc.setFontSize(9);
        doc.setFont(undefined, 'normal');
        doc.text('Desglose de costos y servicios solicitados:', marginLeft, yPos);

        yPos += 4;

        // Configuración de columnas para AutoTable
        let headers = [];
        let bodyRows = [];
        const totalNum = totalEl ? totalEl.textContent : '0.00';

        if (tipo === 'equipos') {
          headers = [
            { title: "EQUIPO", dataKey: "equipo" },
            { title: "CARACTERÍSTICAS", dataKey: "caracteristicas" },
            { title: "CÓDIGO", dataKey: "codigo" },
            { title: "DÍAS", dataKey: "dias" },
            { title: "P/U (Bs)", dataKey: "precio" },
            { title: "SUBTOTAL (Bs)", dataKey: "subtotal" }
          ];
          bodyRows = rows.map(r => ({ ...r }));
          bodyRows.push({
            equipo: "",
            caracteristicas: "",
            codigo: "",
            dias: "",
            precio: "TOTAL:",
            subtotal: totalNum
          });
        } else {
          headers = [
            { title: "PARÁMETRO", dataKey: "parametro" },
            { title: "METODOLOGÍA", dataKey: "metodologia" },
            { title: "UNIDAD", dataKey: "unidad" },
            { title: "CANTIDAD", dataKey: "cantidad" },
            { title: "P/U (Bs)", dataKey: "precio" },
            { title: "SUBTOTAL (Bs)", dataKey: "subtotal" }
          ];
          bodyRows = rows.map(r => ({ ...r }));
          bodyRows.push({
            parametro: "",
            metodologia: "",
            unidad: "",
            cantidad: "",
            precio: "TOTAL:",
            subtotal: totalNum
          });
        }

        doc.autoTable({
          columns: headers,
          body: bodyRows,
          startY: yPos,
          margin: { left: marginLeft, right: 20 },
          styles: {
            fontSize: 8,
            cellPadding: 2.5,
            overflow: 'linebreak',
            fillColor: [255, 255, 255],
            textColor: [10, 10, 10],
            lineColor: [220, 220, 220],
            lineWidth: 0.2
          },
          columnStyles: tipo === 'equipos' ? {
            equipo: { halign: 'left' },
            caracteristicas: { halign: 'left' },
            codigo: { halign: 'center' },
            dias: { halign: 'center' },
            precio: { halign: 'right' },
            subtotal: { halign: 'right' }
          } : {
            parametro: { halign: 'left' },
            metodologia: { halign: 'left' },
            unidad: { halign: 'center' },
            cantidad: { halign: 'center' },
            precio: { halign: 'right' },
            subtotal: { halign: 'right' }
          },
          headStyles: {
            fillColor: [22, 141, 8],
            textColor: 255,
            fontStyle: 'bold',
            halign: 'center'
          },
          alternateRowStyles: {
            fillColor: [248, 251, 246]
          },
          didParseCell: function(data) {
            // Alinear precios y subtotales estrictamente a la derecha en todas las páginas, cabeceras y celdas
            if (data.column.dataKey === 'precio' || data.column.dataKey === 'subtotal') {
              data.cell.styles.halign = 'right';
            }
            // Última fila resaltada como total
            if (data.row.index === bodyRows.length - 1) {
              data.cell.styles.fontStyle = 'bold';
              data.cell.styles.textColor = [9, 91, 18];
              data.cell.styles.fillColor = [241, 249, 236];
              if (data.column.dataKey === 'precio' || data.column.dataKey === 'subtotal') {
                data.cell.styles.halign = 'right';
              }
            }
          }
        });

        yPos = doc.lastAutoTable.finalY + 8;

        // Total en palabras
        doc.setFontSize(9);
        doc.setFont(undefined, 'bold');
        doc.text('Son: ' + numeroAPalabras(totalNum) + ' Bolivianos.', marginLeft, yPos);

        // Sección 2: Términos y Condiciones
        yPos += 9;
        doc.setFontSize(10);
        doc.setFont(undefined, 'bold');
        doc.text('2. TÉRMINOS Y CONDICIONES', marginLeft, yPos);

        yPos += 5;
        doc.setFontSize(8.5);
        doc.setFont(undefined, 'normal');
        doc.text('• Esta cotización es referencial y tiene una validez de 3 días calendario.', marginLeft, yPos);
        yPos += 4.5;
        doc.text('• Para confirmar y programar el servicio, comunicarse con los responsables del área.', marginLeft, yPos);
        yPos += 4.5;
        doc.text('• Incluye emisión de informes técnicos avalados por profesionales certificados.', marginLeft, yPos);

        // Sección 3: Contactos y Responsable
        yPos += 9;
        doc.setFontSize(10);
        doc.setFont(undefined, 'bold');
        doc.text('3. CONTACTOS', marginLeft, yPos);

        yPos += 5;
        doc.setFontSize(8.5);
        doc.setFont(undefined, 'normal');
        doc.text('Cualquier consulta o coordinación comunicarse con la responsable del área:', marginLeft, yPos);

        yPos += 14;
        function centerPdfText(txt, y, isBold = false) {
          doc.setFont(undefined, isBold ? 'bold' : 'normal');
          const tWidth = doc.getStringUnitWidth(txt) * doc.getFontSize() / doc.internal.scaleFactor;
          const pWidth = doc.internal.pageSize.getWidth();
          doc.text(txt, (pWidth - tWidth) / 2, y);
          return y + 4.5;
        }

        yPos = centerPdfText('Ing. Sonia Mamani Chino', yPos, true);
        yPos = centerPdfText('GERENTE DE LABORATORIO · PACHABOL SRL', yPos, true);
        yPos = centerPdfText('laboratorio@pachabol.com', yPos);
        yPos = centerPdfText('Teléf./WhatsApp: +591 76358189 · La Paz - Bolivia', yPos);

        // Guardar archivo y notificar
        const nombreArchivo = `${codigoCot}_${empresa.replace(/[^a-zA-Z0-9]/g, '_')}_${new Date().toISOString().slice(0, 10)}.pdf`;
        doc.save(nombreArchivo);

        Swal.fire({
          icon: 'success',
          title: '¡Cotización Generada con Éxito!',
          html: `<p>Se ha descargado el documento oficial <strong>${nombreArchivo}</strong>.</p>
                 <p style="font-size:0.9rem; color:#666;">Total cotizado: <strong>${totalNum} Bs</strong></p>`,
          showCancelButton: true,
          confirmButtonColor: '#168d08',
          cancelButtonColor: '#052c20',
          confirmButtonText: '<i data-lucide="message-square"></i> Enviar por WhatsApp',
          cancelButtonText: 'Cerrar'
        }).then((result) => {
          if (result.isConfirmed) {
            const servicioNombre = tipo === 'equipos'
              ? 'Alquiler de Equipos'
              : (tipo === 'ambiental' ? 'Monitoreo Ambiental' : 'Monitoreo Ocupacional');
            const mensajeWa = `*SOLICITUD DE COTIZACIÓN N° ${codigoCot}*\n\n` +
              `*Cliente/Empresa:* ${institucion}\n` +
              `*Responsable:* ${responsable} (${cargo || '-'})\n` +
              `*Ciudad:* ${departamento}\n` +
              `*Teléfono:* ${telefono}\n` +
              `*Correo:* ${correo}\n\n` +
              `*Servicio:* Cotización Referencial de ${servicioNombre}\n` +
              `*Total Estimado:* ${totalNum} Bs\n\n` +
              `He generado la cotización referencial en la web y deseo coordinar el servicio formal.`;

            const isMobile = /iPhone|Android|iPad/i.test(navigator.userAgent);
            const waBase = isMobile ? 'https://api.whatsapp.com/send?phone=' : 'https://web.whatsapp.com/send?phone=';
            window.open(`${waBase}59176358189&text=${encodeURIComponent(mensajeWa)}`, '_blank');
          }
        });

      } catch (err) {
        console.error('Error al generar PDF:', err);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Ocurrió un inconveniente al generar el PDF: ' + err.message });
      } finally {
        btnPdf.disabled = false;
        btnPdf.innerHTML = '<i data-lucide="file-down"></i> Generar Cotización en PDF <i data-lucide="arrow-right"></i>';
        if (window.lucide) lucide.createIcons();
      }
    });
  };
})();
