import "../styles/scss/client/client.scss";

import $ from "jquery";
import Swal from "sweetalert2";

$(document).ready(function () {
  if ($("body").hasClass("client-page")) {
    actionClient.delete();
    actionClient.checked();
  }
});

var actionClient = {
  delete: function () {
    $("body").on("click", "#delete-client", function () {

      const $this = $(this);
      const url = $this.attr("data-url");

      const fullName = $this.attr('data-fullName');

      Swal.fire({
        title: "Est vous sur?",
        text: `Vous Voulez vraiment supprimer ${fullName}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            method: "GET",
            data : {
                fullName : fullName,
            },
            success: function (resp) {
              if (resp) {
                window.location.reload();
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Erreur",
                  text: "Une erreur est survenue lors de la suppression.",
                  confirmButtonText: "OK",
                });
              }
            },
            error: function () {
              Swal.fire({
                icon: "error",
                title: "Erreur Serveur",
                text: "Une erreur est survenue lors de la suppression.",
                confirmButtonText: "OK",
              });
            },
          });
        }
      });
    });
  },

  checked : function() {
    $('body').on('click', '.check-contrat', function() {
      const $this = $(this);
      const $contratWrapper = $('.form-create-contract');
      if($this.prop('checked')){
        $contratWrapper.removeClass('d-none');
      }else{
        $contratWrapper.addClass('d-none');
      }

    })
  }
};
