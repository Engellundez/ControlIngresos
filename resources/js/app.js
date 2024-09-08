import "./bootstrap";
import Alpine from "alpinejs";
import { driver } from "driver.js";
import Chart from "chart.js/auto";

// Configuración de opciones para obtener el formato deseado en la zona horaria -0600
const DATE_OPTIONS = {
	year: 'numeric',
	month: '2-digit',
	day: '2-digit',
	timeZone: 'America/Mexico_City' // Ejemplo para zona horaria -0600
};


function processJsonResponse(response, callback = null) {
	if (response.response_type === "alert") {
		alertToast(response);
		return null;
	}

	console.error(
		`El response_type: "${response.response_type}", no ha sido reconocido, verificar`
	);
	if (callback != null) return callback(response);
	return null;
}

function alertToast(alertStructure) {
	console.log("🚀 ~ alertToast ~ alertStructure:", alertStructure);
}

window.Alpine = Alpine;
window.Chart = Chart;
window.showTutorial = driver();
window.processJsonResponse = processJsonResponse;
window.alertToast = alertToast;
window.DATE_OPTIONS = DATE_OPTIONS;
Alpine.start();
