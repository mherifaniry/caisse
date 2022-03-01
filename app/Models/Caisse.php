<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Caisse extends Model
{
    use HasFactory;
    protected $table        = 'caisse';
    protected $fillable = ['type_operation', 'note', 'date_operation', 'total_somme', 'detail_operation'];
    /**
    * Insertion des donnée dans la table caisse
    * input: les données du formulaire
    **/
    public function CreateCaisse($input)
    {
      return  DB::table('caisse')->insert([
        'type_operation' => $input['type_operation'],
        'note' => $input['note'],
        'date_operation' => $input['date_operation'],
        'total_somme' => $input['total_somme'],
        'detail_operation' => Self::array_to_json($input['detail_operation']),
        'created_at' =>  @date('Y-m-d H:i:s'),
        'updated_at' =>  @date('Y-m-d H:i:s'),
      ]);
    }
    /**
    * mise à jour des données de caisse dans la table caisse
    * input: les données du formulaire
    *
    */
    public function UpdateCaisse($input)
    {
      return DB::table('caisse')
                ->where(['id_caisse' => $input['id']])->update([
                'type_operation' => $input['type_operation'],
                'note' => $input['note'],
                'date_operation' => $input['date_operation'],
                'total_somme' => $input['total_somme'],
                'detail_operation' => Self::array_to_json($input['detail_operation']),
                'updated_at' =>  @date('Y-m-d H:i:s')]);
    }
    /**
    *
    * Consulté les éntrée de fond de caisse d'une date
    * date: la date à consulté
    */
    public function GetCaissebyDate($date)
    {
      return DB::table('caisse')->where('date_operation', $date)
      ->select('id_caisse', 'type_operation', 'note', 'date_operation', 'total_somme', 'total_somme')
      ->get();
    }
    /**
    * Consulté une entrée de fond de caisse par son identité
    *
    *id: identité
    */
    public function GetCaisseById($id)
    {
      return DB::table('caisse')->where('id_caisse', $id)
                ->select('id_caisse', 'type_operation', 'note', 'date_operation', 'total_somme', 'total_somme', 'detail_operation')
                ->get();
    }
    /**
    *
    * supprimé une opération du jour
    * id: identité
    */
    public function DestroyId($id)
    {
      return DB::table('caisse')->where('id_caisse', $id)
              ->delete();
    }

    public function array_to_json($array)
    {
      //$block = json_decode($detail_caisse[0]->detail_operation);
      $block = json_decode($array);

      if(isset($block->bb) && !empty($block->bb))
      {
        $block_bb = explode(',', $block->bb);
        $block_bb = Self::to_array($block_bb);
      }
      else
      {
        $block_bb = '';
      }

      if(isset($block->bp)&& !empty($block->bp))
      {
        $block_bp = explode(',', $block->bp);
        $block_bp = Self::to_array($block_bp);
      }
      else
      {
        $block_bp = '';
      }

      if(isset($block->bc)&& !empty($block->bc))
      {
        $block_bc = explode(',', $block->bc);
        $block_bc = Self::to_array($block_bc);
      }
      else
      {
        $block_bc = '';
      }


      return json_encode(array(
        'bb' => $block_bb,
        'bp' => $block_bp,
        'bc' => $block_bc
      ));
    }
    /**
    *
    *
    *
    */
    public function to_array($array)
    {
      $new_as = array();
      foreach($array as $block)
      {
        $i = explode('_#_', $block);
        $new_as[$i[0]] = $i[1];
      }

      return $new_as;
    }


}
