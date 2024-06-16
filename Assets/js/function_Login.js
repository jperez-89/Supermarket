// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function () {
  $(".login-box").toggleClass("flipped");
  return false;
});

document.addEventListener(
  "DOMContentLoaded",
  function () {
    if (document.querySelector("#frmLogin")) {
      let frmLogin = document.querySelector("#frmLogin");

      frmLogin.onsubmit = function (e) {
        e.preventDefault();

        let usuario = document.getElementById("txtUsername").value;
        let password = document.getElementById("txtPassword").value;

        if (usuario == "") {
          txtUsername.focus();
          swal("", "Digite su usuario", "info");
          return false;

        } else if (password == "") {
          txtPassword.focus();
          swal("", "Digite su contraseña", "info");
          return false;

        } else {
          const url = `${base_url}login/LoginUser`;
          frmDatos = new FormData(frmLogin);

          const res = fnt_Fetch(url, 'post', frmDatos);
          res.then(data => {
            if (data.status) {
              window.location = `${base_url}dashboard`;
            } else {
              swal("", data.msg, "error");
            }
          })
        }
      };
    }
  },
  false
);
