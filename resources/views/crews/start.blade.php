@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List builder</div>

                <div class="card-body">
					<form>
						<div class="form-group">
							<label name="Name">Name: </label>
							<input type="text" value="" id="Name" name="Name" placeholder="Awesome list name" />
						</div>
						<div class="form-group">
							<label name="faction_picker">Faction: </label>
							<select for="form-control" id="faction_picker" name="faction_picker">
								<option value="">- pick a faction -</option>
								@foreach($factions as $faction)
								<option value="{{ $faction->id }}">{{ $faction->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label name="points">Points: </label>
							<input type="number" value="100" id="points" name="points" />
						</div>
						<button type="submit" class="btn btn-primary">Save list</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection