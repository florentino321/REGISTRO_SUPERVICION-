document.addEventListener('DOMContentLoaded', () => {
    const modalRegistro = new bootstrap.Modal(document.getElementById('modalRegistro'));
    const modalVer = new bootstrap.Modal(document.getElementById('modalVer'));
    const formRegistro = document.getElementById('formRegistro');
    const selectorAccion = document.getElementById('selector-accion');
    const selectorAE = document.getElementById('selector-ae');
    const selectorZP = document.getElementById('selector-zp');
    const selectorZD = document.getElementById('selector-zd');
    const contenidoVer = document.getElementById('contenidoVer');

    // Función genérica para cargar selectores dependientes
    const cargarDependiente = async (url, selector, idSeleccionado = null, placeholder = "Seleccione...") => {
        selector.innerHTML = '<option value="">Cargando...</option>';
        try {
            const response = await fetch(url);
            const data = await response.json();
            selector.innerHTML = `<option value="">${placeholder}</option>`;
            data.forEach(item => {
                const option = document.createElement('option');
                // Buscamos la primera y segunda propiedad del objeto (ID y Nombre)
                const keys = Object.keys(item);
                option.value = item[keys[0]];
                option.textContent = item[keys[1]];
                if (idSeleccionado && option.value == idSeleccionado) option.selected = true;
                selector.appendChild(option);
            });
        } catch (error) {
            selector.innerHTML = '<option value="">Error al cargar</option>';
        }
    };

    // Eventos de Cambio
    selectorAccion.addEventListener('change', () => {
        if (selectorAccion.value) cargarDependiente(`api.php?action=get_ae&id_accion=${selectorAccion.value}`, selectorAE);
        else selectorAE.innerHTML = '<option value="">Seleccione acción primero</option>';
    });

    selectorZP.addEventListener('change', () => {
        if (selectorZP.value) cargarDependiente(`api.php?action=get_distritos&id_zp=${selectorZP.value}`, selectorZD);
        else selectorZD.innerHTML = '<option value="">Seleccione provincia primero</option>';
    });

    // Botón Nuevo
    document.getElementById('btnNuevoRegistro').addEventListener('click', () => {
        formRegistro.reset();
        document.getElementById('ID_REGISTRO').value = '';
        document.getElementById('accion_crud').value = 'insert';
        document.getElementById('modalTitulo').textContent = 'Nuevo Registro';
        selectorAE.innerHTML = '<option value="">Seleccione acción primero</option>';
        selectorZD.innerHTML = '<option value="">Seleccione provincia primero</option>';
        modalRegistro.show();
    });

    // Botón Ver Detalle
    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.closest('tr').dataset.id;
            try {
                const res = await fetch(`api.php?action=get_detalle_completo&id=${id}`);
                const data = await res.json();
                
                const mapeo = [
                    ['Expediente', data.NRO_EXPEDIENTE],
                    ['Contrato', data.CONTRATO],
                    ['Acción', data.NOMBRE_ACCION],
                    ['Acción Específica', data.ACCION_ESPECIFICA],
                    ['Actividad', data.NOMBRE_ACTIVIDAD],
                    ['Tipo de Agente', data.NOMBRE_TA],
                    ['Transporte', 'Opción ' + data.NOMBRE_TRANSPORTE],
                    ['Provincia', data.NOMBRE_PROVINCIA],
                    ['Distrito', data.NOMBRE_DISTRITO],
                    ['Observaciones', data.OBSERVACIONES]
                ];

                contenidoVer.innerHTML = mapeo.map(row => `
                    <tr>
                        <th class="ps-3 w-40">${row[0]}</th>
                        <td>${row[1] || '<span class="text-muted">No especificado</span>'}</td>
                    </tr>
                `).join('');
                
                modalVer.show();
            } catch (error) {
                Swal.fire('Error', 'No se pudo cargar el detalle', 'error');
            }
        });
    });

    // Botón Editar
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', async () => {
            const d = btn.closest('tr').dataset;
            document.getElementById('modalTitulo').textContent = 'Editar Registro';
            document.getElementById('accion_crud').value = 'update';
            document.getElementById('ID_REGISTRO').value = d.id;
            document.getElementById('NRO_EXPEDIENTE').value = d.exp;
            document.getElementById('CONTRATO').value = d.cont;
            document.getElementById('OBSERVACIONES').value = d.obs;
            
            document.getElementById('selector-actividad').value = d.actividad;
            document.getElementById('selector-ta').value = d.ta;
            document.getElementById('selector-tt').value = d.tt;
            document.getElementById('selector-accion').value = d.accion;
            document.getElementById('selector-zp').value = d.zp;

            // Cargar dependientes y pre-seleccionar
            await Promise.all([
                cargarDependiente(`api.php?action=get_ae&id_accion=${d.accion}`, selectorAE, d.ae),
                cargarDependiente(`api.php?action=get_distritos&id_zp=${d.zp}`, selectorZD, d.zd)
            ]);

            modalRegistro.show();
        });
    });

    // Botón Eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.closest('tr').dataset.id;
            Swal.fire({
                title: '¿Eliminar registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const fd = new FormData();
                    fd.append('accion_crud', 'delete');
                    fd.append('ID_REGISTRO', id);
                    const res = await fetch('procesar.php', { method: 'POST', body: fd });
                    const data = await res.json();
                    if (data.success) Swal.fire('Éxito', data.message, 'success').then(() => location.reload());
                }
            });
        });
    });

    // Guardar
    formRegistro.addEventListener('submit', async (e) => {
        e.preventDefault();
        const res = await fetch('procesar.php', { method: 'POST', body: new FormData(formRegistro) });
        const data = await res.json();
        if (data.success) {
            modalRegistro.hide();
            Swal.fire('Guardado', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });
});