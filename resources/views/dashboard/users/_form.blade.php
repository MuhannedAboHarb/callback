@csrf
<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <x-form.input name="name" id="name" :lable="__('Name')" :value="$user->name" />
        </div>

        <div class="form-group mb-3">
            <x-form.input name="email" id="email" :lable="__('Email')" :value="$user->email" />
        </div>

        <div class="col-md-12">
            <h3> {{ __('Roles') }} </h3>
            @foreach (App\Models\Role::all() as $role)
                <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" role="switch"
                        id="roles_{{ $role->id }}" name="roles[]" value="{{ $role->id }}" @if(in_array($role->id, $user_roles))  checked @endif >
                    <label class="custom-control-label"
                        for="roles_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-danger ml-2">{{ $button2 }}</a>
        </div>

    </div>
</div>
