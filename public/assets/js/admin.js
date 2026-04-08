/**
 * Funciones compartidas del panel de administración.
 */

/**
 * Escucha global para confirmaciones de envío de formularios.
 * Busca el atributo data-confirm en el formulario que se intenta enviar.
 * Uso: <form ... data-confirm="¿Eliminar este registro?">
 */
document.addEventListener('submit', function (e) {
  const form = e.target;
  if (form && form.hasAttribute('data-confirm')) {
    const msg = form.getAttribute('data-confirm') || '¿Eliminar este registro?';
    if (!confirm(msg)) {
      e.preventDefault();
    }
  }
}, false);

/**
 * Mantiene la función por compatibilidad, aunque se recomienda usar data-confirm.
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
