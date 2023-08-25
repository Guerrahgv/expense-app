// Seleccionar el botón de gasto
const btnExpense = document.querySelector('#new-expense');

// Agregar un evento de clic al botón
btnExpense.addEventListener('click', async e => {
  // Crear elementos del panel emergente
  const background      = document.createElement('div');
  const panel           = document.createElement('div');
  const titlebar        = document.createElement('div');   
  const closeButton     = document.createElement('a');     
  const closeButtonText = document.createElement('i');       
  const ajaxcontent     = document.createElement('div');     

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
  const html = await fetch('http://localhost:80/expense-app/expenses/create').then(res => res.text());
  return html;    // Devolver el contenido obtenido
}

// Cargar la biblioteca de gráficos de Google y llamar a la función drawChart cuando esté lista
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

// Función para dibujar el gráfico
async function drawChart() {
  // Obtener los datos para el gráfico a través de una solicitud AJAX
  const http = await fetch('http://localhost:80/expense-app/expenses/getExpensesJSON')
    .then(json => json.json())
    .then(res => res);

  let expenses = [...http];
  expenses.shift();
  console.log(expenses);

  let colors = [...http][0];
  colors.shift();

  // Convertir los datos en un objeto DataTable de Google Charts
  var data = google.visualization.arrayToDataTable(expenses);

  // Configurar las opciones del gráfico
  var options = {
    colors: colors
  };

  // Crear un objeto de gráfico de barras y dibujar el gráfico en el elemento con el ID 'chart'
  var chart = new google.charts.Bar(document.getElementById('chart'));
  chart.draw(data, google.charts.Bar.convertOptions(options));
}
