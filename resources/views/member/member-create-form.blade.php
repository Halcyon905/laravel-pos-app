<div class="panel-body mt-10">

    <form action="{{ route('member.create') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <div class="flex form-group">
            <div>
                <label for="new_member_name" class="col-sm-3 control-label">New Member name</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="new_member_name" id="new_member_name" class="form-control" value="{{ old('new_member_name') }}">
                </div>
            </div>
            
            <div class="ms-3">
                <label for="new_phone" class="col-sm-3 control-label">New Phone Number</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="new_phone" id="new_phone" class="form-control" value="{{ old('new_phone') }}">
                </div>
            </div>
        </div>


        <div class="form-group mt-4">
            <div class="col-sm-offset-3 col-sm-6">
                <x-primary-button class="ms-3">
                    {{ __('Create Member') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>