<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Citas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .logo-container {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .step {
            display: none;
            animation: slideIn 0.5s ease-out;
        }

        .step.active {
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        h2 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .step-indicator {
            color: #999;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            background: white;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .info-box p {
            margin: 8px 0;
            color: #555;
        }

        .info-box strong {
            color: #333;
        }

        /* Calendario mejorado */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .calendar-nav {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .nav-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        .nav-btn:hover {
            background: #5568d3;
        }

        .current-month {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            min-width: 150px;
            text-align: center;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 10px;
        }

        .weekday {
            text-align: center;
            font-weight: 600;
            color: #667eea;
            padding: 10px;
            font-size: 14px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            position: relative;
            background: white;
        }

        .calendar-day:hover:not(.disabled):not(.empty) {
            background: #e7e9ff;
            border-color: #667eea;
            transform: scale(1.05);
        }

        .calendar-day.selected {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .calendar-day.disabled {
            background: #f5f5f5;
            color: #ccc;
            cursor: not-allowed;
        }

        .calendar-day.empty {
            border: none;
            cursor: default;
        }

        .calendar-day.has-appointments {
            border-color: #ffc107;
        }

        .calendar-day.has-appointments::after {
            content: '';
            position: absolute;
            bottom: 5px;
            width: 6px;
            height: 6px;
            background: #ffc107;
            border-radius: 50%;
        }

        .calendar-day.selected.has-appointments::after {
            background: white;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 20px 0;
        }

        .time-slot {
            padding: 12px;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            position: relative;
        }

        .time-slot:hover:not(.occupied) {
            background: #e7e9ff;
            border-color: #667eea;
        }

        .time-slot.selected {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .time-slot.occupied {
            background: #f5f5f5;
            color: #999;
            border-color: #ddd;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .time-slot-status {
            font-size: 11px;
            margin-top: 4px;
            color: #666;
        }

        .time-slot.occupied .time-slot-status {
            color: #dc3545;
        }

        .success-message {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #667eea;
        }

        .legend {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
            font-size: 13px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid;
        }

        .legend-available {
            background: white;
            border-color: #e0e0e0;
        }

        .legend-has-appointments {
            background: white;
            border-color: #ffc107;
        }

        .legend-selected {
            background: #667eea;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="logo.jpg" alt="Studio karli" class="logo">
            <h1 style="color: #667eea; margin-top: 10px;">Sistema de Citas</h1>
        </div>

        <div class="form-container">
            <!-- Paso 1: Ingreso de teléfono -->
            <div id="step1" class="step active">
                <h2>Bienvenido</h2>
                <p class="step-indicator">Paso 1 de 5</p>
                <form id="phoneForm">
                    <div class="form-group">
                        <label for="telefono">Número de Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Ej: 5551234567" required>
                        <span id="phoneError" class="error"></span>
                    </div>
                    <button type="submit" class="btn">Continuar</button>
                </form>
            </div>

            <!-- Paso 2: Verificación/Registro de datos -->
            <div id="step2" class="step">
                <h2>Verificar Datos</h2>
                <p class="step-indicator">Paso 2 de 5</p>
                <div id="clienteExistente" style="display:none;">
                    <div class="info-box" id="datosCliente"></div>
                    <p>¿Los datos son correctos?</p>
                    <button class="btn" onclick="continuarConDatos()">Sí, continuar</button>
                    <button class="btn btn-secondary" onclick="editarDatos()">No, actualizar datos</button>
                </div>

                <form id="datosForm" style="display:none;">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Género</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="masculino" name="genero" value="Masculino" required>
                                <label for="masculino" style="margin:0">Masculino</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="femenino" name="genero" value="Femenino">
                                <label for="femenino" style="margin:0">Femenino</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="otro" name="genero" value="Otro">
                                <label for="otro" style="margin:0">Otro</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" required>
                    </div>
                    <button type="submit" class="btn">Guardar y Continuar</button>
                </form>
            </div>

            <!-- Paso 3: Selección de servicio -->
            <div id="step3" class="step">
                <h2>Seleccionar Servicio</h2>
                <p class="step-indicator">Paso 3 de 5</p>
                <form id="servicioForm">
                    <div class="form-group">
                        <label for="servicioSelect">Seleccione el servicio que necesita</label>
                        <select id="servicioSelect" name="servicio" required>
                            <option value="">-- Seleccione un servicio --</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Continuar</button>
                    <button type="button" class="btn btn-secondary" onclick="volverPaso(2)">Atrás</button>
                </form>
            </div>

            <!-- Paso 4: Selección de fecha y hora -->
            <div id="step4" class="step">
                <h2>Seleccionar Fecha y Hora</h2>
                <p class="step-indicator">Paso 4 de 5</p>
                
                <div class="calendar-header">
                    <div class="calendar-nav">
                        <button type="button" class="nav-btn" onclick="cambiarMes(-1)">◀</button>
                        <span class="current-month" id="currentMonth"></span>
                        <button type="button" class="nav-btn" onclick="cambiarMes(1)">▶</button>
                    </div>
                </div>

                <div class="calendar-weekdays">
                    <div class="weekday">Dom</div>
                    <div class="weekday">Lun</div>
                    <div class="weekday">Mar</div>
                    <div class="weekday">Mié</div>
                    <div class="weekday">Jue</div>
                    <div class="weekday">Vie</div>
                    <div class="weekday">Sáb</div>
                </div>

                <div class="calendar-grid" id="calendar"></div>

                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-box legend-available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-has-appointments"></div>
                        <span>Con citas</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-selected"></div>
                        <span>Seleccionado</span>
                    </div>
                </div>

                <div id="timeSlotsContainer" style="display:none;">
                    <h3 style="margin: 30px 0 15px 0;">Horarios disponibles para <span id="fechaSeleccionadaTexto"></span>:</h3>
                    <div id="loadingSlots" class="loading" style="display:none;">Cargando horarios...</div>
                    <div class="time-slots" id="timeSlots"></div>
                </div>

                <button class="btn" onclick="continuarConFecha()" style="margin-top: 20px;">Continuar</button>
                <button class="btn btn-secondary" onclick="volverPaso(3)">Atrás</button>
            </div>

            <!-- Paso 5: Confirmación -->
            <div id="step5" class="step">
                <h2>Confirmar Cita</h2>
                <p class="step-indicator">Paso 5 de 5</p>
                <div class="info-box" id="resumenCita"></div>
                <button class="btn" onclick="confirmarCita()">Confirmar Cita</button>
                <button class="btn btn-secondary" onclick="volverPaso(4)">Atrás</button>
            </div>

            <!-- Mensaje de éxito -->
            <div id="stepSuccess" class="step">
                <div class="success-message">
                    <div class="success-icon">✓</div>
                    <h2>¡Cita Registrada Exitosamente!</h2>
                    <p style="margin: 20px 0; color: #666;">Gracias por usar nuestro servicio. Hemos registrado su cita correctamente.</p>
                    <div class="info-box" id="confirmacionFinal"></div>
                    <button class="btn" onclick="location.reload()">Agendar Nueva Cita</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let clienteData = {};
        let servicioSeleccionado = null;
        let servicioNombre = '';
        let fechaSeleccionada = null;
        let horaSeleccionada = null;
        let currentDate = new Date();
        let citasDelMes = {};

        // Paso 1: Verificar teléfono
        document.getElementById('phoneForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const telefono = document.getElementById('telefono').value;
            
            fetch('verificar_cliente.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({telefono: telefono})
            })
            .then(response => response.json())
            .then(data => {
                clienteData.telefono = telefono;
                if(data.existe) {
                    clienteData = {...clienteData, ...data.cliente};
                    mostrarDatosCliente(data.cliente);
                } else {
                    mostrarFormularioNuevo();
                }
                cambiarPaso(2);
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarFormularioNuevo();
                cambiarPaso(2);
            });
        });

        function mostrarDatosCliente(cliente) {
            document.getElementById('clienteExistente').style.display = 'block';
            document.getElementById('datosForm').style.display = 'none';
            document.getElementById('datosCliente').innerHTML = `
                <p><strong>Nombre:</strong> ${cliente.Nombre}</p>
                <p><strong>Género:</strong> ${cliente.Genero}</p>
                <p><strong>Fecha de Nacimiento:</strong> ${cliente.FechaNacimiento}</p>
                <p><strong>Correo:</strong> ${cliente.CorreoElectronico}</p>
            `;
        }

        function mostrarFormularioNuevo() {
            document.getElementById('clienteExistente').style.display = 'none';
            document.getElementById('datosForm').style.display = 'block';
        }

        function continuarConDatos() {
            cargarServicios();
            cambiarPaso(3);
        }

        function editarDatos() {
            document.getElementById('clienteExistente').style.display = 'none';
            document.getElementById('datosForm').style.display = 'block';
            document.getElementById('nombre').value = clienteData.Nombre || '';
            document.getElementById('fechaNacimiento').value = clienteData.FechaNacimiento || '';
            document.getElementById('correo').value = clienteData.CorreoElectronico || '';
            if(clienteData.Genero) {
                document.querySelector(`input[value="${clienteData.Genero}"]`).checked = true;
            }
        }

        document.getElementById('datosForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clienteData.Nombre = document.getElementById('nombre').value;
            clienteData.Genero = document.querySelector('input[name="genero"]:checked').value;
            clienteData.FechaNacimiento = document.getElementById('fechaNacimiento').value;
            clienteData.CorreoElectronico = document.getElementById('correo').value;

            fetch('guardar_cliente.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(clienteData)
            })
            .then(response => response.json())
            .then(data => {
                clienteData.Id = data.clienteId;
                cargarServicios();
                cambiarPaso(3);
            })
            .catch(error => console.error('Error:', error));
        });

        // Paso 3: Cargar servicios en combobox
        function cargarServicios() {
            fetch('obtener_servicios.php')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('servicioSelect');
                select.innerHTML = '<option value="">-- Seleccione un servicio --</option>';
                data.servicios.forEach(servicio => {
                    const option = document.createElement('option');
                    option.value = servicio.Id;
                    option.textContent = servicio.Nombre;
                    option.dataset.nombre = servicio.Nombre;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
        }

        document.getElementById('servicioForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const select = document.getElementById('servicioSelect');
            servicioSeleccionado = select.value;
            servicioNombre = select.options[select.selectedIndex].dataset.nombre;
            
            if(!servicioSeleccionado) {
                alert('Por favor selecciona un servicio');
                return;
            }
            
            generarCalendario();
            cambiarPaso(4);
        });

        // Paso 4: Calendario con navegación mensual
        function generarCalendario() {
            actualizarTituloMes();
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startingDayOfWeek = firstDay.getDay();
            const totalDays = lastDay.getDate();
            
            // Cargar citas del mes
            cargarCitasDelMes(year, month);
            
            // Espacios vacíos antes del primer día
            for(let i = 0; i < startingDayOfWeek; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'calendar-day empty';
                calendar.appendChild(emptyDiv);
            }
            
            // Días del mes
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            for(let day = 1; day <= totalDays; day++) {
                const fecha = new Date(year, month, day);
                const fechaStr = formatearFecha(fecha);
                const div = document.createElement('div');
                div.className = 'calendar-day';
                div.textContent = day;
                
                // Deshabilitar fechas pasadas
                if(fecha < hoy) {
                    div.classList.add('disabled');
                } else {
                    div.onclick = () => seleccionarFecha(fecha, div);
                }
                
                calendar.appendChild(div);
            }
        }

        function cargarCitasDelMes(year, month) {
            const mesStr = `${year}-${String(month + 1).padStart(2, '0')}`;
            fetch(`obtener_citas_mes.php?mes=${mesStr}`)
            .then(response => response.json())
            .then(data => {
                citasDelMes = data.citas || {};
                marcarDiasConCitas();
            })
            .catch(error => console.error('Error:', error));
        }

        function marcarDiasConCitas() {
            const dias = document.querySelectorAll('.calendar-day:not(.empty):not(.disabled)');
            dias.forEach(dia => {
                const numDia = parseInt(dia.textContent);
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const fecha = new Date(year, month, numDia);
                const fechaStr = formatearFecha(fecha);
                
                if(citasDelMes[fechaStr] && citasDelMes[fechaStr].length > 0) {
                    dia.classList.add('has-appointments');
                }
            });
        }

        function cambiarMes(direccion) {
            currentDate.setMonth(currentDate.getMonth() + direccion);
            fechaSeleccionada = null;
            horaSeleccionada = null;
            document.getElementById('timeSlotsContainer').style.display = 'none';
            generarCalendario();
        }

        function actualizarTituloMes() {
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                          'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            document.getElementById('currentMonth').textContent = 
                `${meses[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        }

        function seleccionarFecha(fecha, elemento) {
            document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
            elemento.classList.add('selected');
            fechaSeleccionada = formatearFecha(fecha);
            
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('fechaSeleccionadaTexto').textContent = 
                fecha.toLocaleDateString('es-ES', opciones);
            
            mostrarHorarios(fechaSeleccionada);
        }

        function mostrarHorarios(fecha) {
            const container = document.getElementById('timeSlotsContainer');
            const loading = document.getElementById('loadingSlots');
            const slots = document.getElementById('timeSlots');
            
            container.style.display = 'block';
            loading.style.display = 'block';
            slots.innerHTML = '';
            
            // Consultar horarios ocupados
            fetch('obtener_horarios_ocupados.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({fecha: fecha})
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                const horariosOcupados = data.horarios || [];
                const horarios = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'];
                
                horarios.forEach(hora => {
                    const div = document.createElement('div');
                    div.className = 'time-slot';
                    
                    const ocupado = horariosOcupados.includes(hora);
                    if(ocupado) {
                        div.classList.add('occupied');
                        div.innerHTML = `
                            ${hora}
                            <div class="time-slot-status">Ocupado</div>
                        `;
                    } else {
                        div.innerHTML = `
                            ${hora}
                            <div class="time-slot-status">Disponible</div>
                        `;
                        div.onclick = () => seleccionarHora(hora, div);
                    }
                    
                    slots.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                loading.style.display = 'none';
            });
        }

        function seleccionarHora(hora, elemento) {
            document.querySelectorAll('.time-slot:not(.occupied)').forEach(el => el.classList.remove('selected'));
            elemento.classList.add('selected');
            horaSeleccionada = hora;
        }

        function continuarConFecha() {
            if(!fechaSeleccionada || !horaSeleccionada) {
                alert('Por favor selecciona fecha y hora');
                return;
            }
            mostrarResumen();
            cambiarPaso(5);
        }

        function mostrarResumen() {
            const resumen = document.getElementById('resumenCita');
            resumen.innerHTML = `
                <p><strong>Nombre:</strong> ${clienteData.Nombre}</p>
                <p><strong>Teléfono:</strong> ${clienteData.telefono}</p>
                <p><strong>Servicio:</strong> ${servicioNombre}</p>
                <p><strong>Fecha:</strong> ${fechaSeleccionada}</p>
                <p><strong>Hora:</strong> ${horaSeleccionada}</p>
            `;
        }

        function confirmarCita() {
            const citaData = {
                Cliente: clienteData.Id,
                Servicio: servicioSeleccionado,
                Fecha: fechaSeleccionada,
                Hora: horaSeleccionada
            };

            fetch('guardar_cita.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(citaData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('confirmacionFinal').innerHTML = `
                    <p><strong>Número de Cita:</strong> #${data.citaId}</p>
                    <p><strong>Servicio:</strong> ${servicioNombre}</p>
                    <p><strong>Fecha:</strong> ${fechaSeleccionada}</p>
                    <p><strong>Hora:</strong> ${horaSeleccionada}</p>
                `;
                cambiarPaso('success');
            })
            .catch(error => console.error('Error:', error));
        }

        function formatearFecha(fecha) {
            const year = fecha.getFullYear();
            const month = String(fecha.getMonth() + 1).padStart(2, '0');
            const day = String(fecha.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function cambiarPaso(paso) {
            document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
            if(paso === 'success') {
                document.getElementById('stepSuccess').classList.add('active');
            } else {
                document.getElementById('step' + paso).classList.add('active');
            }
        }

        function volverPaso(paso) {
            cambiarPaso(paso);
        }
    </script>
</body>
</html>