let caisse = {}

caisse.contenue = []
caisse.compteur = 0;
caisse.total = 0;
caisse.total_billet = 0;
caisse.total_piece = 0;
caisse.total_centime = 0;
caisse.detail_calcul = {};
caisse.json_arr = {};

/**
*
*
*
**/
caisse.ajout_block_nominal_qut = function(element, b_maj){
  // création du block nominal quantité selon le type de block
    if(caisse.contenue.length == 6)
    {
      symbole = 'ct';
    }
    else
    {
      symbole = '&euro;';
    }
    html_block = '<div class="default flex deletable n_'+caisse.compteur+'"><div class="nominal"><div class=""><label for="">Nominal</label></div><div class="" style="margin-top:15px"><select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet(\''+element+'\', \''+b_maj+'\')">';
      for(i = 0; i < caisse.contenue.length; i++)
      {
          html_block += '<option value="'+caisse.contenue[i]+'" >'+caisse.contenue[i]+' '+symbole+' </option>';
      }
    html_block += '</select></div></div><div class="quantite"><div class=""><label for="">Quantité</label></div><div class="" style="margin-top:15px"><input class="quantiteInput" type="number" onkeyup="caisse.calculer_somme_billet(\''+element+'\', \''+b_maj+'\')"><label class="supp" onclick="caisse.supp_block_nominal_qut('+caisse.compteur+');caisse.calculer_somme_billet(\''+element+'\', \''+b_maj+'\')">Supprimer</label></div></div></div>';
    caisse.compteur++;
    return html_block;
}
/**
*
*
*
**/
caisse.supp_block_nominal_qut = function(num_block){
  $(".n_"+num_block).remove();
}
/*
*
*
*/
caisse.calculer_somme_billet = function(block, b_maj){
  tableau_nominalSelect = [];
  tableau_quantiteInput = [[]];
  i = 0;
  total = 0;
  $(block+" .block_nominal .gauche .default select.nominalSelect").each(function(index, element){
    tableau_nominalSelect[i] = $(element).val();
    i++;
  })
  i = 0;
  $(block+"  .block_nominal .gauche .default input.quantiteInput").each(function(index, element){
    tableau_quantiteInput[i] = $(element).val();

    i++;
  })

  debut_j = '';
  for(i = 0; i < tableau_nominalSelect.length; i++)
  {
    total += tableau_nominalSelect[i] * tableau_quantiteInput[i];
    virgule = ",";
    if((i+1) == tableau_nominalSelect.length)
    {
      virgule = "";
    }
    debut_j += tableau_nominalSelect[i]+"_#_"+tableau_quantiteInput[i]+virgule;
  }



  if(block == ".bloc_centimes")
  {
    total = total/100;
    caisse.total_centime =  total;
    caisse.json_arr["bc"] = debut_j;
  }
  else if(block == ".block_billets")
  {
    caisse.total_billet = total;
    caisse.json_arr["bb"] = debut_j;
  }
  else{
    caisse.total_piece = total;
    caisse.json_arr["bp"] = debut_j;
  }
  caisse.total = caisse.total_centime + caisse.total_billet + caisse.total_piece;
  $(b_maj).html(total +" &euro;");

  $("#total_somme_i").val(caisse.total);
  $("#total_somme").html(caisse.total +" &euro;");
  $("#det_cal").val(JSON.stringify(caisse.json_arr));
  console.log(caisse.json_arr);
  return total;
}

caisse.ready = function(){


  $("#ajout_billet").on("click",function(data){
    caisse.contenue = [5, 10, 20, 50, 100, 200, 500];
    $(this).before(caisse.ajout_block_nominal_qut('.block_billets', '#total_billet'));
  });
  /*
  *
  *
  */
  $("#ajout_nominal").on("click", function(){
    caisse.contenue = [0, 1, 2];
    $(this).before(caisse.ajout_block_nominal_qut('.block_piece', '#total_piece'));
  });
  /*
  *
  *
  */
  $("#ajout_centimes").on("click", function(){
    caisse.contenue = [1, 2, 5, 10, 20, 50];
    $(this).before(caisse.ajout_block_nominal_qut('.bloc_centimes', '#total_centime'));
  });

  $("#enregistrer").on("click", function(){
    $('form.entre_caisse').submit();
  })

  /*$('form.entre_caisse').on('submit', function(event)
     {
         event.preventDefault();
         var formData = new FormData();
         var id_task = $("#upload_id_task").val();
         formData.append('_token',$('form.entre_caisse').find('[name="_token"]').val());
         formData.append('total_somme',$('form.entre_caisse').find('[name="total_somme"]').val());
         formData.append('note',$('form.entre_caisse').find('[name="note"]').val());
         formData.append('type_operation',$('form.entre_caisse').find('[name="type_operation"]').val());
         formData.append('date_operation',$('form.entre_caisse').find('[name="date_operation"]').val());
         formData.append('detail_operation', JSON.stringify(caisse.json_arr));
         $.ajax({
             url: $('form.entre_caisse').attr('action'),
             type: 'POST',
             data: formData,
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             contentType: false,
             processData: false,
             error: function(data){
               //var a = JSON.parse(data.responseText);
               //alert(a.errors.image[0]);
             }
           }).done(function(data) {

             if(data.success == true)
             {
               alert('donne')
             }
           });
     });*/
}


$(document).ready(function(){
  caisse.ready();
  $('.date_operation').datepicker({
    changeMonth: true,
    changeYear: true
  });
})
