(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function (event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function (event) {
		event.preventDefault();
		if (!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	// $("[data-toggle='tooltip']").tooltip();

})();

var audio = new Audio('Assets/mp3/beep.mp3');
function PlayAudio() {
	audio.play();
}

async function fnt_Fetch(url, method = '', Databody) {
	var jsonResponse;

	if (method == 'post') {
		jsonResponse = fetch(url, {
			method: method,
			body: Databody,
			mode: "no-cors",
			headers: { 'Content-Type': 'application/json' },
		})
			.then(res => res.json())
			.catch((error) => {
				alert('Server Error => ' + error)
			});
	} else {
		jsonResponse = fetch(url).then(res => res.json())
	}

	return jsonResponse;
}

function pfrm(frm) {
	new Response(frm).text().then(console.log);
}

async function swalMixin(icon, title, position, timer) {
	const Toast = Swal.mixin({
		toast: true,
		iconColor: 'white',
		customClass: {
			popup: 'colored-toast'
		},
		position: position,
		showConfirmButton: false,
		timer: timer,
		timerProgressBar: true,
		// didOpen: (toast) => {
		//      toast.addEventListener('mouseenter', Swal.stopTimer)
		//      toast.addEventListener('mouseleave', Swal.resumeTimer)
		// }
	})

	await Toast.fire({
		icon: icon,
		title: title
	})
}

async function swalConfirmed(text, icon) {
	var res = await Swal.fire({
		title: "",
		text: text,
		icon: icon,
		confirmButtonText: "OK",
		confirmButtonColor: '#35b8e0',
		allowOutsideClick: false
	})
	return res;
}

async function swalEnviarFactura(title, text, icon) {
	var res = await Swal.fire({
		title: title,
		text: text,
		icon: icon,
		confirmButtonText: "Sí",
		confirmButtonColor: '#35b8e0',
		showCancelButton: true,
		cancelButtonText: 'No',
		allowOutsideClick: false
	})
	return res;
}

function generarPDF(idVenta, pagaCon, Vuelto) {
	url = `${base_url}facturacion/generarPDF/&iv=${idVenta}&pc=${pagaCon}&v=${Vuelto}`;
	window.open(url, 'blank');
}

function verFacturaPDF(idVenta) {
	url = `${base_url}assets/facturas/factura-${idVenta}.pdf`;
	window.open(url, '_blank');
}

function enviarFacturaPDF(emailCliente, nFactura) {
	url = `${base_url}facturacion/enviarFactura`;
	const frm = new FormData();
	frm.append('emailCliente', emailCliente);
	frm.append('nFactura', nFactura);

	const response = fnt_Fetch(url, 'post', frm);
	response.then((res) => {
		if (res.status) {
			const msg = swalConfirmed(res.msg, "success");
			msg.then((res) => {
				if (res) {
					location.reload();
				}
			})
		} else {
			swal('', res.msg, "error");
		}
	});
}

function BuscarCliente(Identificacion) {
	if (Identificacion === "") {
		swal('', 'Digite el número de Identificación', "info");
		return false;
	} else if (Identificacion === "1") {
	}

	if (Identificacion.length < 9) {
		swal('', 'El numero de Identificación debe contener entre 9 o 10 caracteres', "info");
		return false
	}

	const url = `https://api.hacienda.go.cr/fe/ae?identificacion=${Identificacion}`;
	const response = fnt_Fetch(url)
	response.then(data => {
		if (data.code == 400) {
			document.getElementById("txtIdentificacion").focus();
			document.querySelector("#txtNombre").value = '';
			document.querySelector("#estadoHacienda").value = '';
			statusHacienda = '';
			selecRegimen.selectedIndex = 0;
			swalMixin('error', `El número de identificación ${Identificacion} no es válido o no existe`, 'top-end', 4000)
			return false;
		}

		if (data.regimen.codigo != 0) {
			document.querySelector("#txtNombre").value = data.nombre;
			document.querySelector("#estadoHacienda").value = data.situacion.estado;
			statusHacienda = data.situacion.estado;
			selecRegimen.selectedIndex = data.regimen.codigo;
		} else {
			document.querySelector("#txtNombre").value = data.nombre;
			document.querySelector("#estadoHacienda").value = data.situacion.estado;
			statusHacienda = data.situacion.estado;
			selecRegimen.selectedIndex = data.regimen.codigo;

			swal('', `Cliente ${data.situacion.estado} ante Hacienda`, "info");
		}
	});
}

function isString(idInput) {
	$("#" + idInput).on({
		keydown: (e) => {
			return (e.key.length != 1 || 1 + e.key.search(/[a-zA-Z]/)) ? true : false;
		},
		paste: function (e) {
			return false;
		}
	});
}

function isNumber(idInput) {
	$(`#${idInput}`).on({
		keydown: (e) => {
			return (e.key.length != 1 || 1 + e.key.search(/^[0-9]/)) ? true : false;
		},
		paste: function (e) {
			return true;
		}
	});
}

$('.logout').click(function (e) {
	e.preventDefault();

	let a = document.createElement("a");
	document.body.appendChild(a);
	a.style = "display: none";
	a.href = `${base_url}logout`;
	a.click();
});

const MOON = '🌙';
const SUN = '☀️';
const DARK_MODE = 'dark';
const LIGHT_MODE = 'light';
const DEFAULT_MODE = DARK_MODE;

// const btn = document.querySelector('#theme-switcher');

// init();

function init() {
	let storedMode = sessionStorage.getItem('mode');
	if (!storedMode) {
		storedMode = DEFAULT_MODE;
		sessionStorage.setItem('mode', DEFAULT_MODE);
	}
	setMode(storedMode);
}

function setMode(mode = DEFAULT_MODE) {
	if (mode === DARK_MODE) {
		btn.textContent = SUN;
		document.body.classList.add(DARK_MODE);

	} else if (mode === LIGHT_MODE) {
		btn.textContent = MOON;
		document.body.classList.remove(DARK_MODE);
	}
}

// btn.addEventListener('click', function () {
// 	let mode = sessionStorage.getItem('mode');
// 	if (mode) {
// 		let newMode = mode == DARK_MODE ? LIGHT_MODE : DARK_MODE;
// 		setMode(newMode);
// 		sessionStorage.setItem('mode', newMode);
// 	}
// });