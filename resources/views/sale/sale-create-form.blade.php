<div class="panel-body mt-10">

    <form action="{{ route('salesLineItem.create') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <input type="hidden" name="sale_id" value="{{ $sale->id }}">

        <div class="flex form-group">
            <div>
                <label for="item_id" class="col-sm-3 control-label">Product</label>
                <div class="col-sm-6 mt-3">
                    <select name="item_id" id="item_id" class="form-control">
                            <option value="none">select a product</option>
                            @foreach($stock as $option)
                                @if(old('item_id') == $option->id)
                                    <option value="{{ $option->id }}" selected="true">{{ $option->name }} -- {{ $option->price }} baht</option>
                                @else
                                    <option value="{{ $option->id }}">{{ $option->name }} -- {{ $option->price }} baht</option>
                                @endif
                            @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ms-3">
                <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                <div class="col-sm-6 mt-3">
                    <input type="text" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}">
                </div>
            </div>
        </div>


        <div class="form-group mt-4">
            <div class="col-sm-offset-3 col-sm-6">
                <x-primary-button class="ms-3">
                    {{ __('Add item') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>