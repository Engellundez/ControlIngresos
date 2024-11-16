import "./bootstrap";
import Alpine from "alpinejs";
import mask from "@alpinejs/mask";
import { driver } from "driver.js";
import Chart from "chart.js/auto";
import Swal from "sweetalert2";

// Configuración de opciones para obtener el formato deseado en la zona horaria -0600
const DATE_OPTIONS = {
	year: "numeric",
	month: "2-digit",
	day: "2-digit",
	timeZone: "America/Mexico_City", // Ejemplo para zona horaria -0600
};

const Toast = Swal.mixin({
	toast: true,
	position: "top-end",
	iconColor: '#1f2937',
	customClass: {
		popup: "colored-toast",
	},
	showConfirmButton: false,
	timerProgressBar: true,
});

function processJsonResponse(response) {
	if (response.response_type === "alert") {
		alertToast(response.response);
	} else {
		console.error(`El response_type: "${response.response_type}", no ha sido reconocido, verificar`);
	}
	return null;
}

function alertToast(data) {
	Toast.fire({
		icon: data?.type ?? "question",
		title: data?.message ?? "",
		timer: data?.timer ?? 2000,
	});
}

function formatCurrency(number) {
	if (number == null) return null;

	return new Intl.NumberFormat("en-US", {
		style: "currency",
		currency: "USD",
		minimumFractionDigits: 2, // Para asegurarte de que tenga dos decimales
	}).format(number);
}

function formatCreditCard(number, maskPattern = "XXXX XXXX XXXX XXXX") {
	let str = String(number).replace(/\D/g, "");

	// Aquí podrías cambiar la lógica de máscara según el patrón que envíes
	if (maskPattern === "XXXX XXXX XXXX XXXX") {
		return str.replace(/(\d{4})(?=\d)/g, "$1 ");
	}
	// Otras máscaras
	return str;
}

function parseCurrency(currencyStr) {
	// Elimina el símbolo de moneda y las comas
	let numericStr = String(currencyStr).replace(/[,$]/g, "");

	// Convierte la cadena restante a número flotante
	return parseFloat(numericStr);
}

Alpine.plugin(mask);

window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;
window.showTutorial = driver();
window.processJsonResponse = processJsonResponse;
window.alertToast = alertToast;
window.formatCurrency = formatCurrency;
window.formatCreditCard = formatCreditCard;
window.parseCurrency = parseCurrency;
window.DATE_OPTIONS = DATE_OPTIONS;
Alpine.start();
