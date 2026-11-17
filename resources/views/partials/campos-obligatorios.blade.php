{{--
    Campos obligatorios
    -------------------
    Inclúyelo antes de </body> en cualquier vista con formularios:

        @include('partials.campos-obligatorios')

    Qué hace, para todos los campos con el atributo "required":
    - Agrega un asterisco rojo (*) a su etiqueta (o al placeholder si no tiene etiqueta).
    - Al enviar el formulario, si hay campos vacíos (o solo con espacios),
      cancela el envío, marca los campos en rojo, muestra "Este campo es obligatorio."
      y lleva el cursor al primero.
    - Reemplaza la burbuja nativa del navegador por el mismo mensaje en español.
    - También funciona con campos que se agregan después con JavaScript (modales, partidas, etc.).

    Para marcar manualmente una etiqueta de grupo (p. ej. radios), agrega
    <span class="req-mark">*</span> dentro de la etiqueta.

    Para pedir confirmación en un botón de envío, usa data-confirmar="¿Seguro...?"
    en lugar de onclick="return confirm(...)": así la pregunta sale solo cuando
    ya no faltan campos.
--}}
<style>
    .req-mark {
        color: #e11d2e;
        font-weight: bold;
        margin-left: 3px;
    }

    .campo-invalido,
    .campo-invalido:focus {
        border-color: #e11d2e !important;
        box-shadow: 0 0 0 3px rgba(225, 29, 46, .18) !important;
        outline: none !important;
    }

    .msg-obligatorio {
        display: block;
        color: #e11d2e;
        font-size: 12px;
        font-weight: normal;
        text-transform: none;
        letter-spacing: normal;
        margin-top: 6px;
        text-align: left;
    }
</style>

<script>
(function () {
    if (window.__camposObligatorios) return;
    window.__camposObligatorios = true;

    var SELECTOR = 'input[required], select[required], textarea[required]';
    var CONTENEDORES = '.field, .campo, .form-group, .mechanic-form-group, .fault-field, ' +
        '.mechanic-intake-field, .mechanic-detail-field, .mechanic-status-field, .form-field, .input-group';
    var TIPOS_IGNORADOS = ['hidden', 'submit', 'button', 'reset', 'image'];

    function ignorado(el) {
        return TIPOS_IGNORADOS.indexOf((el.type || '').toLowerCase()) !== -1;
    }

    function etiquetaDe(el) {
        if (el.id) {
            var porFor = document.querySelector('label[for="' + CSS.escape(el.id) + '"]');
            if (porFor) return porFor;
        }
        var envolvente = el.closest('label');
        if (envolvente) return envolvente;

        // Campo dentro de una tabla: el * va en el encabezado de su columna
        var celda = el.closest('td');
        var tabla = celda && celda.closest('table');
        if (tabla && tabla.tHead && tabla.tHead.rows.length) {
            var th = tabla.tHead.rows[0].cells[celda.cellIndex];
            if (th) return th;
        }

        var cont = el.closest(CONTENEDORES);
        if (cont) {
            var labels = cont.querySelectorAll('label');
            for (var i = 0; i < labels.length; i++) {
                // La etiqueta propia del campo, no la de un radio u opción interna
                if (!labels[i].querySelector('input, select, textarea') && !labels[i].htmlFor) {
                    return labels[i];
                }
            }
        }
        return null;
    }

    function marcar(raiz) {
        (raiz || document).querySelectorAll(SELECTOR).forEach(function (el) {
            if (ignorado(el) || el.type === 'radio' || el.type === 'checkbox' || el.dataset.reqMarcado) return;
            el.dataset.reqMarcado = '1';

            var label = etiquetaDe(el);
            if (label) {
                if (!label.querySelector('.req-mark')) {
                    var span = document.createElement('span');
                    span.className = 'req-mark';
                    span.setAttribute('aria-hidden', 'true');
                    span.textContent = '*';
                    // Si la etiqueta envuelve al campo, el * va justo después del texto
                    var control = label.querySelector('input, select, textarea');
                    if (control) label.insertBefore(span, control);
                    else label.appendChild(span);
                }
            } else if (el.tagName === 'SELECT' && el.options.length && el.options[0].value === '') {
                var op = el.options[0];
                if (op.text.slice(-1) !== '*') op.text = op.text.trim() + ' *';
            } else if (el.placeholder && el.placeholder.slice(-1) !== '*') {
                el.placeholder = el.placeholder + ' *';
            }
        });
    }

    // Solo se pone el mensaje junto al campo si tiene su propio contenedor;
    // si no (campos sueltos en filas), se usa un aviso único arriba del formulario.
    function contenedorMensaje(el) {
        return el.closest(CONTENEDORES);
    }

    function actualizarResumen(form) {
        if (!form) return;
        var resumen = form.querySelector('.msg-obligatorio.resumen');
        var pendientes = Array.prototype.some.call(form.querySelectorAll('.campo-invalido'), function (c) {
            return !contenedorMensaje(c);
        });
        if (pendientes && !resumen) {
            resumen = document.createElement('span');
            resumen.className = 'msg-obligatorio resumen';
            resumen.setAttribute('role', 'alert');
            resumen.style.margin = '4px 0 10px';
            resumen.textContent = 'Completa los campos obligatorios (*) marcados en rojo.';
            // Justo arriba del botón de enviar (o de su fila de botones)
            var boton = form.querySelector('button[type="submit"], input[type="submit"], button:not([type])');
            if (boton) {
                var ancla = boton.parentElement !== form && boton.parentElement.querySelectorAll('button').length > 1
                    ? boton.parentElement : boton;
                ancla.parentElement.insertBefore(resumen, ancla);
            } else {
                form.appendChild(resumen);
            }
        } else if (!pendientes && resumen) {
            resumen.remove();
        }
    }

    function limpiar(el) {
        el.classList.remove('campo-invalido');
        el.removeAttribute('aria-invalid');
        var cont = contenedorMensaje(el);
        var msg = cont && cont.querySelector('.msg-obligatorio[data-para="' + (el.name || el.id) + '"]');
        if (msg) msg.remove();
        actualizarResumen(el.form);
    }

    function mostrarError(el, texto) {
        el.classList.add('campo-invalido');
        el.setAttribute('aria-invalid', 'true');
        var cont = contenedorMensaje(el);
        if (!cont) { actualizarResumen(el.form); return; }
        var clave = el.name || el.id;
        var msg = cont.querySelector('.msg-obligatorio[data-para="' + clave + '"]');
        if (!msg) {
            msg = document.createElement('span');
            msg.className = 'msg-obligatorio';
            msg.dataset.para = clave;
            // Después del campo (o de su envoltura, p. ej. el botón "Mostrar" de contraseñas)
            var ancla = el.parentElement !== cont && el.parentElement.parentElement === cont ? el.parentElement : el;
            ancla.insertAdjacentElement('afterend', msg);
        }
        msg.textContent = texto;
    }

    function estaVacio(el) {
        if (el.disabled || ignorado(el)) return false;
        if (el.type === 'checkbox') return !el.checked;
        if (el.type === 'radio') {
            var form = el.form || document;
            return !form.querySelector('input[type="radio"][name="' + CSS.escape(el.name) + '"]:checked');
        }
        if (el.type === 'file') return !el.files || el.files.length === 0;
        return (el.value || '').trim() === '';
    }

    function enfocar(el) {
        try {
            el.scrollIntoView({ block: 'center', behavior: 'smooth' });
            el.focus({ preventScroll: true });
        } catch (e) {}
    }

    // 1) Validación propia al enviar (también atrapa campos con solo espacios)
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-sin-validar')) return;

        var vacios = Array.prototype.filter.call(form.querySelectorAll(SELECTOR), estaVacio);
        if (!vacios.length) {
            // Confirmación opcional del botón (data-confirmar="¿...?"), solo cuando ya no faltan datos
            var boton = e.submitter;
            if (boton && boton.dataset.confirmar && !window.confirm(boton.dataset.confirmar)) {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
            return;
        }

        e.preventDefault();
        e.stopImmediatePropagation();

        vacios.forEach(function (el) {
            if (el.type !== 'radio') mostrarError(el, 'Este campo es obligatorio.');
            else el.classList.add('campo-invalido');
        });
        enfocar(vacios[0]);
    }, true);

    // 2) Reemplaza la burbuja nativa por nuestro mensaje
    var invalidosPendientes = [];
    document.addEventListener('invalid', function (e) {
        var el = e.target;
        e.preventDefault();
        var texto = el.validity.valueMissing ? 'Este campo es obligatorio.' : el.validationMessage;
        mostrarError(el, texto);

        invalidosPendientes.push(el);
        if (invalidosPendientes.length > 1) return;

        setTimeout(function () {
            var form = invalidosPendientes[0].form;
            // El navegador acepta "   " como lleno: márcalos también en esta misma pasada
            if (form) {
                form.querySelectorAll(SELECTOR).forEach(function (campo) {
                    if (estaVacio(campo) && campo.type !== 'radio') {
                        mostrarError(campo, 'Este campo es obligatorio.');
                        invalidosPendientes.push(campo);
                    }
                });
            }
            // Enfoca el primero en el orden de la página
            invalidosPendientes.sort(function (a, b) {
                return a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1;
            });
            enfocar(invalidosPendientes[0]);
            invalidosPendientes = [];
        }, 0);
    }, true);

    // 3) Quita el error en cuanto el usuario corrige
    ['input', 'change'].forEach(function (tipo) {
        document.addEventListener(tipo, function (e) {
            var el = e.target;
            if (!el.classList || !el.classList.contains('campo-invalido')) return;
            if (el.type === 'radio') {
                (el.form || document).querySelectorAll('input[type="radio"][name="' + CSS.escape(el.name) + '"]')
                    .forEach(function (r) { r.classList.remove('campo-invalido'); });
                return;
            }
            // validity.valid no dispara el evento "invalid" (checkValidity sí)
            if (!estaVacio(el) && (!el.validity || el.validity.valid)) limpiar(el);
        }, true);
    });

    // 4) Marca los campos actuales y los que se agreguen después
    function iniciar() {
        marcar(document);
        var pendiente = false;
        new MutationObserver(function () {
            if (pendiente) return;
            pendiente = true;
            requestAnimationFrame(function () { pendiente = false; marcar(document); });
        }).observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['required'] });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', iniciar);
    else iniciar();
})();
</script>
