<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Settings';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'hero_logo' => Setting::get('hero_logo'),
            'reg_simposium_url' => Setting::get('reg_simposium_url'),
            'reg_handson_url' => Setting::get('reg_handson_url'),
            'reg_funrun_url' => Setting::get('reg_funrun_url'),
            'reg_pengmas_url' => Setting::get('reg_pengmas_url'),
            'reg_pitch_url' => Setting::get('reg_pitch_url'),
            'registration_open' => (bool) Setting::get('registration_open', true),
            '3mpc_open' => (bool) Setting::get('3mpc_open', true),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Logo')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_logo')
                            ->label('Logo Hero (menggantikan badge 78)')
                            ->image()
                            ->directory('settings'),
                    ]),

                Forms\Components\Section::make('Link Registrasi')
                    ->schema([
                        Forms\Components\TextInput::make('reg_simposium_url')
                            ->label('URL Registrasi Simposium')
                            ->url(),

                        Forms\Components\TextInput::make('reg_handson_url')
                            ->label('URL Registrasi Hands-on')
                            ->url(),

                        Forms\Components\TextInput::make('reg_funrun_url')
                            ->label('URL Registrasi Fun Run')
                            ->url(),

                        Forms\Components\TextInput::make('reg_pengmas_url')
                            ->label('URL Registrasi Pengmas')
                            ->url(),

                        Forms\Components\TextInput::make('reg_pitch_url')
                            ->label('URL Info Pitch Competition')
                            ->url(),
                    ]),

                Forms\Components\Section::make('Ticketing & Pembayaran')
                    ->schema([
                        Forms\Components\Toggle::make('registration_open')
                            ->label('Registrasi Dibuka')
                            ->default(true),

                        Forms\Components\Toggle::make('3mpc_open')
                            ->label('Submission 3MPC Dibuka')
                            ->default(true),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('hero_logo', $data['hero_logo'] ?? null);
        Setting::set('reg_simposium_url', $data['reg_simposium_url'] ?? null);
        Setting::set('reg_handson_url', $data['reg_handson_url'] ?? null);
        Setting::set('reg_funrun_url', $data['reg_funrun_url'] ?? null);
        Setting::set('reg_pengmas_url', $data['reg_pengmas_url'] ?? null);
        Setting::set('reg_pitch_url', $data['reg_pitch_url'] ?? null);
        Setting::set('registration_open', $data['registration_open'] ?? true);
        Setting::set('3mpc_open', $data['3mpc_open'] ?? true);

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}
