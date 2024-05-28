document.addEventListener('DOMContentLoaded', () => {
    const reporteForm = document.getElementById('reporte-form');
    const reporteResultado = document.getElementById('reporte-resultado');

    reporteForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(reporteForm);
        const fechaInicio = formData.get('fecha_inicio');
        const fechaFin = formData.get('fecha_fin');

        // Realizar una solicitud AJAX para obtener el reporte de ventas
        fetch('reporte.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar los resultados del reporte en la página
            let html = '<h4>Resultados del Reporte</h4>';
            if (data.length > 0) {
                html += '<table class="table table-striped">';
                html += '<thead><tr><th>ID Venta</th><th>Producto</th><th>Cantidad</th><th>Total</th><th>Fecha</th></tr></thead>';
                html += '<tbody>';
                data.forEach(venta => {
                    html += `<tr>
                                <td>${venta.id}</td>
                                <td>${venta.nombre_producto}</td>
                                <td>${venta.cantidad}</td>
                                <td>${venta.total}</td>
                                <td>${venta.fecha}</td>
                             </tr>`;
                });
                html += '</tbody></table>';
            } else {
                html += '<p>No se encontraron ventas en el período seleccionado.</p>';
            }
            reporteResultado.innerHTML = html;
        })
        .catch(error => {
            console.error('Error al generar el reporte:', error);
            showAlert('Error al generar el reporte', 'danger');
        });
    });
});
