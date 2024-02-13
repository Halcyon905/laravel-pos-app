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
                        @include('messages.error-msg-display')
                    </div>

                    <div class="py-4 mt-3 text-xl font-bold">
                        Grand Total: {{ $grand_total }} baht
                    </div>
                    @if($member->full_name == 'temp')
                    <form action="{{ route('payment.update') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    @method("patch")
                    <div class="flex py-4">
                        <div class="mt-3">
                            <div>
                                <label for="phone">Add member</label>
                            </div>
                            <div>
                                <input name="phone" id="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <input type="hidden" name="sale_id" value="{{ $sale_id }}">
                        <x-primary-button class="ms-3 mt-4">
                            {{ __('Add member') }}
                        </x-primary-button>
                    </div>
                    </form>
                    @else
                    <div class="py-4 text-xl font-bold">
                        Membership added; 10% discount Applied.
                    </div>
                    @endif

                    <form action="{{ route('sale.confirm') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    @method("patch")
                    <div class="py-4">
                        <div>
                            <label for="payment">Payment Method</label>
                        </div>
                        <div class="flex mt-3">
                            <select name="payment" id="payment">
                                <option value="cash">Cash</option>
                                <option value="qr-code">QR Code</option>
                            </select>
                            <div class="ml-4 mt-2">
                                <label for="pay_confirm">Payment confirmed</label>
                                <input type="checkbox" name="pay_confirm" value="true">
                            </div>
                        </div>
                        <div class="qrcode mt-4 p-10" style="display: none;">
                            <img src="{{ url('/qrcode_payment.png') }}" width="200" height="200">
                        </div> 
                    </div>
                    <script>
                        function show_qr() {    
                            if($('#payment').val() === 'cash') {
                                $('.qrcode').hide();
                            } else {
                                $('.qrcode').show();
                            }
                        }

                        show_qr();

                        $('#payment').on('change', show_qr);
                    </script>
                    <div>
                        <input type="hidden" name="sale_id" value="{{ $sale_id }}">
                        <x-primary-button class="ms-3 mt-4">
                            {{ __('Confirm and finish') }}
                        </x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
