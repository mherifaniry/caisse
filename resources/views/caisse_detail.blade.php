<div class="body_gauche">
  <div class="">
    <h1>Modification de fond de caisse</h1>
    <hr>
    <form class="entre_caisse flex" action="{{ route('update_caisse_post')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="total_somme" id="total_somme_i" >
      <input type="hidden" name="detail_operation"  id="det_cal">
      <input type="hidden" name="id" value="{{$detail_caisse[0]->id_caisse}}" id="id_caisse">

      <div class="gauche cinquante">
          <div class="blockeEntree">
            <div class="nominal">
              <div class="">
                <label for="">Type d'operation</label>
              </div>
              <div class="">
                <select style="margin-top:10px" class="nominalSelect" name="type_operation">
                    <option value="1" <?php if($detail_caisse[0]->type_operation == 1) {echo "selected='selected'";}?>>Dépôt de caisse</option>
                    <option value="2" <?php if($detail_caisse[0]->type_operation == 2) {echo "selected='selected'";}?>>Remise en banque</option>
                    <option value="3" <?php if($detail_caisse[0]->type_operation == 3) {echo "selected='selected'";}?>>Retrait</option>
                </select>
              </div>
            </div>
            <div class="nominal">
              <div class="" style="margin-top:10px">
                <label for="">date</label>
              </div>
              <div class="">
                <input style="margin-top:10px;width:145px" class="quantiteInput date_operation" name="date_operation" value="<?php $date = new DateTime($detail_caisse[0]->date_operation); echo $date->format('Y-m-d'); ?>">
              </div>
            </div>
            <div class="nominal">
              <div class="" style="margin-top:10px">
                <label for="">Note</label>
              </div>
              <div class="">
                <textarea style="margin-top:10px" name="note" rows="3" cols="80">{{$detail_caisse[0]->note}}</textarea>
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
  <?php
    $block = json_decode($detail_caisse[0]->detail_operation);
  ?>
  <div class="block_billets">
      <h1>Billets</h1>
      <hr>
      <div class="block_nominal flex">
        <div class="gauche cinquante">

          <?php
          $i = 0;
          if($block->bb):
          foreach( $block->bb as $key => $value):

            ?>
          <div class="default flex deletable n_<?php echo $i;?>">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">

                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.block_billets', '#total_billet')">
                  <option value="0" <?php if($key=='0'):?>selected <?php endif;?>>0</option>
                  <option value="5" <?php if($key=='5'):?>selected <?php endif;?>>5 &euro;</option>
                  <option value="10" <?php if($key=='10'):?>selected <?php endif;?>>10 &euro;</option>
                  <option value="20" <?php if($key=='20'):?>selected <?php endif;?>>20 &euro;</option>
                  <option value="50" <?php if($key=='50'):?>selected <?php endif;?>>50 &euro;</option>
                  <option value="100" <?php if($key=='100'):?>selected <?php endif;?>>100 &euro;</option>
                  <option value="200" <?php if($key=='200'):?>selected <?php endif;?>>200 &euro;</option>
                  <option value="500" <?php if($key=='500'):?>selected <?php endif;?>>500 &euro;</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="<?php echo $value?>" onkeyup="caisse.calculer_somme_billet('.block_billets', '#total_billet')">
                <label class="supp" onclick="caisse.supp_block_nominal_qut(<?php echo $i;$i++;?>);caisse.calculer_somme_billet('.block_billets', '#total_billet')">Supprimer</label>
              </div>
            </div>
          </div>
          <?php
          endforeach;
          endif;
          ?>
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
          <?php
          if($block->bp):
          foreach( $block->bp as $key => $value):?>
          <div class="default flex n_<?php echo $i;?>">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">
                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.block_piece', '#total_piece')">
                  <option value="0" <?php if($key=='0'):?>selected <?php endif;?>>0</option>
                  <option value="1" <?php if($key=='1'):?>selected <?php endif;?>>1 &euro;</option>
                  <option value="2" <?php if($key=='2'):?>selected <?php endif;?>>2 &euro;</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="<?php echo $value?>"  onkeyup="caisse.calculer_somme_billet('.block_piece', '#total_piece')">
                <label class="supp" onclick="caisse.supp_block_nominal_qut(<?php echo $i;$i++;?>);caisse.calculer_somme_billet('.block_piece', '#total_piece')">Supprimer</label>
              </div>
            </div>
          </div>
          <?php
          endforeach;
          endif;?>
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
          <?php
          if($block->bc):
          foreach( $block->bc as $key => $value):?>
          <div class="default flex n_<?php echo $i;?>">
            <div class="nominal">
              <div class="">
                <label for="">Nominal</label>
              </div>
              <div class="" style="margin-top:15px">
                <select class="nominalSelect" name="" onchange="caisse.calculer_somme_billet('.bloc_centimes', '#total_centime')">
                  <option value="0" <?php if($key=='0'):?>selected <?php endif;?>>0</option>
                  <option value="1" <?php if($key=='1'):?>selected <?php endif;?>>1 ct</option>
                  <option value="2" <?php if($key=='2'):?>selected <?php endif;?>>2 ct</option>
                  <option value="5" <?php if($key=='5'):?>selected <?php endif;?>>5 ct</option>
                  <option value="10" <?php if($key=='10'):?>selected <?php endif;?>>10 ct</option>
                  <option value="20" <?php if($key=='20'):?>selected <?php endif;?>>20 ct</option>
                  <option value="50" <?php if($key=='50'):?>selected <?php endif;?>>50 ct</option>
                </select>
              </div>
            </div>
            <div class="quantite">
              <div class="">
                  <label for="">Quantité</label>
              </div>
              <div class="" style="margin-top:15px">
                <input class="quantiteInput" type="number" name="" value="<?php echo $value?>"  onkeyup="caisse.calculer_somme_billet('.bloc_centimes', '#total_centime')">
                <label class="supp" onclick="caisse.supp_block_nominal_qut(<?php echo $i;$i++;?>);caisse.calculer_somme_billet('.bloc_centimes', '#total_centime')">Supprimer</label>
              </div>
            </div>
        </div>
        <?php
        endforeach;
        endif;
        ?>
        <button id="ajout_centimes" class="green"  type="button" name="button">Ajouter</button>
        </div>
        <div class="droite cinquante">
          <b id="total_centime">0 &euro;</b>
        </div>
      </div>

  </div>
  <center><button type="button" class="grey" name="button" id="enregistrer"><b>Enregistrer</b></button></center>
</div>
