<x-app-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center gap-4 mt-10 ml-10 text-l">
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 20000)"
                            class="text-sm text-gray-600 dark:text-gray-400">
                        @if (session('status'))
                            {{ __(session('status')) }}
                        @endif
                        </p>
                    </div>

                    <div class="text-l relative overflow-x-auto">
                        @if(count($sale_items) > 0)
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-left text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">
                                        Product name
                                    </th>
                                    <th class="px-6 py-4">
                                        Quantity
                                    </th>
                                    <th class="px-6 py-4">
                                        Total Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                            @foreach($sale_items as $item)
                                <tr>
                                    <td class="px-6 py-4">{{ $item->item->name }}</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4">{{ $item->total }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('salesLineItem.delete') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            @method('delete')

                                            <input type="hidden" name="sale_id" value="{{ $item->sale_id }}">
                                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                                            <x-primary-button class="mt-4">
                                                {{ __('Remove') }}
                                            </x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    <div class="py-4 mt-3 text-xl font-bold">
                        Grand Total: {{ $sale->total }} baht
                    </div>

                    @include('sale.sale-create-form')

                    <div>
                        <form action="{{ route('payment') }}" method="GET" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <x-primary-button class="ms-3 mt-4">
                                {{ __('Conclude Receipt') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
