@extends('Main.app')
@section('css')
  <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection

@section('body')
<div class="body_gauche">
  <div class="flex">
    <div class="gauche vingt">
      <h1 id="show_total"></h1>
      <hr>
      <div id="datepicker" class="datepicker-here"></div>
    </div>
    <div class="droite soixante-dix">
      <h1>Opérations du jour</h1>
      <hr>
      <table id="list_caisse" class="crow-border order-column stripe">
          <thead>
              <tr>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Note</th>
                  <th>Retraits</th>
                  <th>Ajouts</th>
                  <th>Total</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
            <?php
              $total_somme_ajout = 0;
              $total_somme_retrait = 0;
            ?>
            @if(count($list_caisse))
              @foreach ($list_caisse as $tableau)
                <tr>
                    <td ><?php $date = new DateTime($tableau->date_operation); echo $date->format('d M Y'); ?> </td>
                    <td>{{$type_operation[$tableau->type_operation]}}</td>
                    <td>{{$tableau->note}}</td>
                    <?php
                      $td_1 = 0;
                      $td_2 = 0;
                      if($tableau->type_operation > 1)
                      {
                        $td_1 = $tableau->total_somme;
                        $td_2 = 0;
                        $total_somme_retrait += $td_1;
                      }
                      else
                      {
                        $td_1 = 0;
                        $td_2 = $tableau->total_somme;
                        $total_somme_ajout += $td_2;
                      }

                    ?>
                    <td>{{$td_1}}  &euro;</td>
                    <td>{{$td_2}}  &euro;</td>
                    <td>
                      <?php
                        echo $tableau->total_somme;
                      ?>
                       &euro;
                    </td>
                    <td><label url="{{route('update_caisse', ['id' => $tableau->id_caisse])}}" class="edit" data-id="{{$tableau->id_caisse}}">Modifier</label><label class="supp supp_def"  url="{{route('delete_caisse', ['id' => $tableau->id_caisse, 'date' =>  $tableau->date_operation])}}"  >Supprimer</label></td>
                </tr>
              @endforeach
            @endif
          </tbody>
      </table>
        <p><b>Sous-total opérations de retrait: {{ $total_somme_retrait}} &euro;</b></p>
        <p><b>sous-total opérations d'ajout: {{ $total_somme_ajout}} &euro;</b></p>
        <p><b>Total:  {{$total_somme_ajout - $total_somme_retrait}} &euro;</b></p>
      <input type="hidden" id="total_somme_2" value="{{$total_somme_ajout - $total_somme_retrait}}">
    </div>
  </div>
  <div>

  </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="modal-header"></div>
    <div class="modal-body">

    </div>
  </div>

</div>
@endsection
@section('javascript')
  <script type="text/javascript" src="{{asset('js/caisse.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/caisse_list.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
@endsection
