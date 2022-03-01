$(document).ready(function(){

  $("#show_total").html("Total caisse: "+ $("#total_somme_2").val()+" &euro;")



  $("#datepicker").datepicker(
    {
			changeMonth: true,
			changeYear: true
		}
  )	.on( "change", function() {
        var due_date = new Date($('#datepicker').datepicker().val());
        due_date = due_date.getFullYear()+'-'+(due_date.getMonth()+1)+'-'+due_date.getDate();
        url =  window.location.origin+'/caisse/list/'+due_date;
        location.href = url;

    });



   $('#list_caisse').DataTable({
     columnDefs: [
      {
          targets: -1,
          className: 'dt-head-right'
      }
    ]
   });

   /*
    configuration modal
  */
    $(".edit").on("click", function(){
      var id = $(this).attr("data-id");
      var url = $(this).attr("url");

      $.ajax({
          url: url,
          type: 'GET',
          contentType: false,
          processData: false,
          error: function(data){
            alert("Une erreur est survénue")
          }
        }).done(function(data) {
            $(".modal-body").html(data);

            $('.date_operation').datepicker({
              changeMonth: true,
              changeYear: true
            });
            caisse.ready();
            caisse.calculer_somme_billet('.bloc_centimes', '#total_centime');
            caisse.calculer_somme_billet('.block_billets', '#total_billet');
            caisse.calculer_somme_billet('.block_piece', '#total_piece');

        });

      $("#myModal").css("display", "block");
    });

    $(".supp_def").on("click", function(){
      var r = confirm("ATTENTION ! Opération irréversible. Cette action supprimera cette opération du jour. Êtes-vous sûr de continuer? ");
      if (r == true)
      {
        location.href = $(this).attr("url");
      }
    });

    $(".close").on("click", function(){
      $("#myModal").css("display", "none");
    });



})
