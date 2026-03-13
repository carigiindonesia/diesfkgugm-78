<x-filament-panels::page>
    <x-filament-panels::form wire:submit="create">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="[
                \Filament\Actions\Action::make('create')
                    ->label('Simpan Registrasi')
                    ->submit('create'),
            ]"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
