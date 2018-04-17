<?php

namespace tdc\Console\Commands;

use Illuminate\Console\Command;
use tdc\models\{Special, Weapon, Skill, Faction, Unit, Role};

class import extends Command
{
	private $path ='';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tdc:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import factions data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->path = base_path('resources\imports\faction_data');
		$files = preg_grep('/^([^.])/', scandir($this->path));
		$files = array_values($files);
		$this->info('Which of the following files do you wish to import(multiple option can be given, this can be done be comma separated for individual files and/or - for a range):');
		for($i = 0; $i < count($files); $i++)
		{
			$this->info($i.': '.substr($files[$i], 0, -5));
		}
		$toHandles = [0];//explode(',', $this->ask('Give the numbers'));
		foreach($toHandles as $toHandle)
		{
			$range = explode('-', $toHandle);
			$start = intval($range[0]);
			$end = isset($range[1]) ? intval($range[1]) : $start;
			for(; $start <= $end; $start++)
			{
				if(isset($files[$start]))
				{
					$this->handleFile($files[$start]);
				}
				else
				{
					$this->error($start.' is not in the list.');
				}
			}
		}
    }
	
	private function handleFile(string $file)
	{
		$this->info('handling file: '.$file);
		$data = json_decode(file_get_contents($this->path.'/'.$file));
		if(isset($data->weapon_rules))
		{
			$this->handleWeaponRules($data->weapon_rules);
		}
		if(isset($data->weapons))
		{
			$this->handleWeapon($data->weapons);
		}
		if(isset($data->skills))
		{
			$this->handleSkills($data->skills);
		}
		if(isset($data->factions))
		{
			$this->handleFactions($data->factions);
		}
	}
	
	private function handleWeaponRules(array $rules)
	{
		foreach($rules as $rule)
		{
			$special = Special::where('name', $rule->name)->first();
			$special = $special == null ? new Special() : $special;
			$special->name = $rule->name;
			$special->description = $rule->description;
			$special->save();
		}
	}
	
	private function handleWeapon(array $weapons)
	{
		foreach($weapons as $weapon)
		{
			$weaponObject = Weapon::where('name', $weapon->name)->first();
			$weaponObject = $weaponObject == null ? new Weapon() : $weaponObject;
			$weaponObject->name = $weapon->name;
			if(isset($weapon->pass_range))
			{
				$weaponObject->pass_range = $weapon->pass_range;
			}
			if(isset($weapon->nail_range))
			{
				$weaponObject->nail_range = $weapon->nail_range;
			}
			$weaponObject->pass_damage = $weapon->pass_damage;
			$weaponObject->nail_damage = $weapon->nail_damage;
			foreach($weapon->rules as $rule)
			{
				$special = Special::where('name', $rule)->first();
				if($special == null)
				{
					$this->error($rule.' is not found(weapons: '.$weapon->name.')');
					return;
				}
			}
			$weaponObject->save();
			foreach($weapon->rules as $rule)
			{
				$special = Special::where('name', $rule)->first();
				$weaponObject->specials()->syncWithoutDetaching($special);
			}
		}
	}
	
	private function handleSkills(array $skills)
	{
		foreach($skills as $skill)
		{
			$skillObject = Skill::where('name', $skill->name)->first();
			$skillObject = $skillObject == null ? new Skill() : $skillObject;
			$skillObject->name = $skill->name;
			$skillObject->description = $skill->description;
			$skillObject->save();
		}
	}
	
	private function handleFactions(array $factions)
	{
		foreach($factions as $faction)
		{
			$factionObject = Faction::where('name', $faction->name)->first();
			$factionObject = $factionObject == null ? new Faction() : $factionObject;
			$factionObject->name = $faction->name;
			$factionObject->type = $faction->type;
			$factionObject->save();
			foreach($faction->units as $unit)
			{
				$role = Role::where('name', $unit->role)->first();
				if($role == null)
				{
					$role = new Role();
					$role->name = $unit->role;
					$role->type = $unit->role == 'leader' ? Role::TYPE_LEADER : Role::TYPE_OTHER;
					$role->save();
				}
				$unitObject = Unit::where('name', $unit->name)->where('role_id', $role->id)->where('type', $unit->type)->first();
				if($unitObject == null)
				{
					$unitObject = new Unit();
				}
				$unitObject->name = $unit->name;
				$unitObject->unique_name = $unit->unique_name;
				$unitObject->type = $unit->type;
				$unitObject->role()->associate($role);
				$unitObject->max = $unit->max;
				$unitObject->points = $unit->points;
				$unitObject->action_points = $unit->action_points;
				$unitObject->action_points_max = $unit->action_points_max;
				$unitObject->pass_speed = $unit->pass_speed;
				$unitObject->nail_speed = $unit->nail_speed;
				$unitObject->wounds = $unit->wounds;
				$unitObject->armor = $unit->armor;
				$unitObject->close_combat = $unit->close_combat;
				$unitObject->agility = $unit->agility;
				$unitObject->marksmanship = $unit->marksmanship;
				$unitObject->intelligence = $unit->intelligence;
				$unitObject->toughness = $unit->toughness;
				$unitObject->faction_id = $factionObject->id;
				$unitObject->save();

				foreach($unit->weapons as $weapon)
				{
					$weaponObject = Weapon::where('name', $weapon)->first();
					if($weaponObject == null)
					{
						$this->error('The weapon: "'.$weapon.'" has not been added');
						continue;
					}
					$unitObject->weapons()->syncWithoutDetaching($weaponObject);
				}

				foreach($unit->skills as $skill)
				{
					$skillObject = Skill::where('name', $skill)->first();
					if($skillObject == null)
					{
						$this->error('The skill: "'.$skill.'" has not been added');
						continue;
					}
					$unitObject->skills()->syncWithoutDetaching($skillObject);
				}
			}
		}
	}
}
