@extends('Main.app')
@section('body')
<div class="body_gauche">
  <div class="">
    <h1>Entrée de fond de caisse</h1>
    <hr>
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="entre_caisse flex" action="{{ route('create_caisse') }}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="total_somme" id="total_somme_i" >
      <input type="hidden" name="detail_operation"  id="det_cal">
      <div class="gauche cinquante">
          <div class="blockeEntree">
            <div class="nominal">
              <div class="">
                <label for="">Type d'operation</label>
              </div>
              <div class="">
                <select style="margin-top:10px" class="nominalSelect" name="type_operation">
                    <option value="1">Dépôt de caisse</option>
                    <option value="2">Remise en banque</option>
                    <option value="3">Retrait</option>
                </select>
              </div>
            </div>
            <div class="nominal">
              <div class="" style="margin-top:10px">
                <label for="">date</label>
              </div>
              <div class="">
                <input style="margin-top:10px;width:145px" class="quantiteInput date_operation" name="date_operation" value="<?php $date = new DateTime( @date('Y-m-d H:i:s')); echo $date->format('Y-m-d'); ?>">
              </div>
            </div>
            <div class="nominal">
              <div class="" style="margin-top:10px">
                <label for="">Note</label>
              </div>
              <div class="">
                <textarea style="margin-top:10px" name="note" rows="3" cols="80"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="droite cinquante">
          <h2 id="total_somme">0 &euro;</h2>
        </div>
    </form>
  </div>
  <!-- block billets -->
  <div class="block_billets">
      <h1>Billets</h1>
      <hr>
      <div class="block_nominal flex">
        <div class="gauche cinquante">
          <div class="default flex">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">
                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.block_billets', '#total_billet')">
                  <option value="0" selected>0</option>
                  <option value="5">5 &euro;</option>
                  <option value="10">10 &euro;</option>
                  <option value="20">20 &euro;</option>
                  <option value="50">50 &euro;</option>
                  <option value="100">100 &euro;</option>
                  <option value="200">200 &euro;</option>
                  <option value="500">500 &euro;</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="" onkeyup="caisse.calculer_somme_billet('.block_billets', '#total_billet')">
              </div>
            </div>
          </div>

          <button  id="ajout_billet" class="green" type="button" name="button">Ajouter</button>
        </div>

        <div class="droite cinquante">
          <b id="total_billet">0 &euro;</b>
        </div>
      </div>

  </div>

  <!-- block Pièces -->
  <div class="block_piece">
      <h1>Pièces</h1>
      <hr>
      <div class="block_nominal flex">
        <div class="gauche cinquante">
          <div class="default flex">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">
                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.block_piece', '#total_piece')">
                  <option value="0" selected>0</option>
                  <option value="1">1 &euro;</option>
                  <option value="2">2 &euro;</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="" onkeyup="caisse.calculer_somme_billet('.block_piece', '#total_piece')">
              </div>
            </div>
          </div>

          <button  id="ajout_nominal" class="green" type="button" name="button">Ajouter</button>
        </div>
        <div class="droite cinquante">
          <b id="total_piece">0 &euro;</b>
        </div>
      </div>

  </div>

  <!-- block centimes -->
  <div class="bloc_centimes">
      <h1>Centimes</h1>
      <hr>
      <div class="block_nominal flex">
        <div class="gauche cinquante">
          <div class="default flex">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">
                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.bloc_centimes', '#total_centime')">
                  <option value="0" selected>0</option>
                  <option value="1">1 ct</option>
                  <option value="2">2 ct</option>
                  <option value="5">5 ct</option>
                  <option value="10">10 ct</option>
                  <option value="20">20 ct</option>
                  <option value="50">50 ct</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="" onkeyup="caisse.calculer_somme_billet('.bloc_centimes', '#total_centime')">
              </div>
            </div>
        </div>

        <button id="ajout_centimes" class="green"  type="button" name="button">Ajouter</button>
        </div>
        <div class="droite cinquante">
          <b id="total_centime">0 &euro;</b>
        </div>
      </div>

  </div>
  <center><button type="button" class="grey" name="button" id="enregistrer"><b>Enregistrer</b></button></center>
</div>

@endsection
@section('javascript')
  <script type="text/javascript" src="{{asset('js/caisse.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
@endsection
