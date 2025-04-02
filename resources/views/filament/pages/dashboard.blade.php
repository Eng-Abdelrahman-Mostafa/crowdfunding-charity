<x-filament-panels::page>
    @if(count($this->getWidgets()))
        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :widgets="$this->getWidgets()"
        />
    @else
        <div class="flex items-center justify-center p-6">
            <div class="text-center">
                <x-filament::icon
                    icon="heroicon-o-information-circle"
                    class="mx-auto h-12 w-12 text-gray-400"
                />
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('No widgets available') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('There are no widgets configured for your dashboard.') }}
                </p>
            </div>
        </div>
    @endif
</x-filament-panels::page>
