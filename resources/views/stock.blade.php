<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stock') }}
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
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 20000)"
                            class="text-sm text-red-600 dark:text-gray-400">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        @endif
                        </p>
                    </div>

                    <div class="text-l relative overflow-x-auto">
                        @if(count($stock) > 0)
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-left text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">
                                        Product name
                                    </th>
                                    <th class="px-6 py-4">
                                        In Stock
                                    </th>
                                    <th class="px-6 py-4">
                                        Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                            @foreach($stock as $item)
                                <tr>
                                    <form action="{{ route('item.update') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    @method('patch')

                                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                                    <td class="px-6 py-4 text-center"><input name="name" id="name" value="{{ $item->name }}"></td>
                                    <td class="px-6 py-4 text-center"><input name="stock" id="stock" value="{{ $item->stock }}"></td>
                                    <td class="px-6 py-4 text-center"><input name="price" id="price" value="{{ $item->price }}"></td>
                                    <td class="px-6 py-4 text-center">
                                        <x-primary-button class="mt-4">
                                            {{ __('Confirm Edit') }}
                                        </x-primary-button>
                                    </td>
                                    </form>
                                    <td>
                                        <form action="{{ route('item.destroy') }}" method="POST" class="form-horizontal">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <x-primary-button class="mt-4">
                                            {{ __('Delete') }}
                                        </x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    @include('stock.item-create-form')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>