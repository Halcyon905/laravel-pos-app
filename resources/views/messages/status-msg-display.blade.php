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