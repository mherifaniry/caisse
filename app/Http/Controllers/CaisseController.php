<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCaisseRequest;
use App\Http\Requests\UpdateCaisseRequest;

class CaisseController extends Controller
{

    private $caisse;
    /**
     * Constructeur pour instancier la classe $caisse et teste si l'utilisateur est connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Caisse $caisse)
    {
      $this->middleware('auth');
      $this->caisse = $caisse;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('caisse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $validated = $request->validate([
          'date_operation' => 'required|date',
          'detail_operation' => 'required'
      ]);

        $date = new \DateTime($request['date_operation']);
        $request['date_operation']  = $date->format('Y-m-d');
        $reponse = $this->caisse::CreateCaisse($request);
        if($reponse)
        {
           return redirect()->route('show_caisse', ['date' =>  $request['date_operation']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {
        $type_operation = array(
          1 => "Dépôt de caisse",
          2 => "Rémise en banque",
          3 => "Rétrait"
        );
        $list_caisse = $this->caisse::GetCaissebyDate($date);
        //return $list_caisse;
        return view('caisse_list', ['list_caisse' => $list_caisse, 'type_operation' => $type_operation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $detail_caisse = $this->caisse::GetCaisseById($id);
        return view('caisse_detail', [ 'detail_caisse' => $detail_caisse]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCaisseRequest  $request
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $reponse = $this->caisse::UpdateCaisse($request);
      if($reponse)
      {
         return redirect()->route('show_caisse', ['date' =>  $request['date_operation']]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $date)
    {
        $reponse = $this->caisse::DestroyId($id);
        if($reponse)
        {
           return redirect()->route('show_caisse', ['date' =>  $date]);
        }
    }
}
