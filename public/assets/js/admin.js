/**
 * Funciones compartidas del panel de administración.
 */

/**
 * Pide confirmación antes de enviar un formulario de eliminar.
 * Uso: onsubmit="confirmarEliminar(event, '¿Eliminar este registro?')"
 *
 * @param {SubmitEvent} e
 * @param {string} msg
 */
function confirmarEliminar(e, msg) {
  msg = msg || '¿Eliminar este registro?';
  if (!confirm(msg)) {
    e.preventDefault();
  }
}
