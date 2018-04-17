<?php

namespace tdc\Http\Controllers;

use Illuminate\Http\Request;
use tdc\Models\{Crew, Faction};

class CrewController extends Controller
{
    public function crewForm(Crew $crew = null)
	{
		$factions = Faction->with('units.mounts')->get();
        return view('crews.start', ['factions'=>$factions]);
	}
}
?>