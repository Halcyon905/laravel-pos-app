<div class="panel-body mt-10">

    <form action="{{ route('item.create') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <div class="flex form-group">
            <div>
                <label for="item_name" class="col-sm-3 control-label">New Product name</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="new_item_name" id="new_item_name" class="form-control" value="{{ old('new_item_name') }}">
                </div>
            </div>
            
            <div class="ms-3">
                <label for="stock" class="col-sm-3 control-label">Quantity</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="new_stock" id="new_stock" class="form-control" value="{{ old('new_stock') }}">
                </div>
            </div>

            <div class="ms-3">
                <label for="price" class="col-sm-3 control-label">Price</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="new_price" id="new_price" class="form-control" value="{{ old('new_price') }}">
                </div>
            </div>
        </div>


        <div class="form-group mt-4">
            <div class="col-sm-offset-3 col-sm-6">
                <x-primary-button class="ms-3">
                    {{ __('Create item') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>