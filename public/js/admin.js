// Seleccionar el botón de categoría
const btnCategory = document.querySelector('#new-category');

// Agregar un evento de clic al botón
btnCategory.addEventListener('click', async e => {
  // Crear elementos del panel emergente
  const background      = document.createElement('div');      // Fondo oscuro
  const panel           = document.createElement('div');      // Panel principal
  const titlebar        = document.createElement('div');      // Barra de título
  const closeButton     = document.createElement('a');        // Botón de cierre
  const closeButtonText = document.createElement('i');        // Texto del botón de cierre
  const ajaxcontent     = document.createElement('div');      // Contenido AJAX

  // Configurar los atributos de los elementos
  background.setAttribute('id', 'background-container');
  panel.setAttribute('id', 'panel-container');
  titlebar.setAttribute('id', 'title-bar-container');
  closeButton.setAttribute('class', 'close-button');
  //closeButton.setAttribute('href', '#');
  closeButtonText.setAttribute('class', 'material-icons');
  ajaxcontent.setAttribute('id', 'ajax-content');

  // Construir la estructura del panel emergente
  background.appendChild(panel);
  panel.appendChild(titlebar);
  panel.appendChild(ajaxcontent);
  titlebar.appendChild(closeButton);
  closeButton.appendChild(closeButtonText);
  closeButtonText.appendChild(document.createTextNode('close'));
  document.querySelector('#main-container').appendChild(background);

  // Agregar evento de clic al botón de cierre
  closeButton.addEventListener('click', e => {
    background.remove();    // Eliminar el panel emergente al hacer clic en el botón de cierre
  });

  // Obtener el contenido a través de una solicitud AJAX
  const html = await getContent();
  ajaxcontent.innerHTML += html;
});

// Función asincrónica para obtener el contenido
async function getContent() {
  // Realizar una solicitud de búsqueda a la URL especificada y obtener el texto de respuesta
  const html = await fetch('http://localhost:80/expense-app/admin/createCategory').then(res => res.text());
  return html;    // Devolver el contenido obtenido
}

