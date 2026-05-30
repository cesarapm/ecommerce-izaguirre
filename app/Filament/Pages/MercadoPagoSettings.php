<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class MercadoPagoSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Mercado Pago';

    protected static ?string $title = 'Configuración de Mercado Pago';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 90;

    protected static string $view = 'filament.pages.mercado-pago-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'access_token' => Setting::get('mercadopago_access_token', ''),
            'notification_url' => Setting::get('mercadopago_notification_url', ''),
            'webhook_secret' => Setting::get('mercadopago_webhook_secret', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Credenciales de Mercado Pago')
                    ->description('Configura las credenciales de Mercado Pago para procesar pagos en línea.')
                    ->schema([
                        Forms\Components\TextInput::make('access_token')
                            ->label('Access Token')
                            ->helperText('Token de acceso de Mercado Pago (APP_USR-...)')
                            ->placeholder('APP_USR-XXXX-XXXXXX-XXXX')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('notification_url')
                            ->label('URL de Notificación (Webhook)')
                            ->helperText('URL donde Mercado Pago enviará las notificaciones de pago')
                            ->placeholder('https://tudominio.com/api/mercado-pago/webhook')
                            ->url()
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('webhook_secret')
                            ->label('Webhook Secret')
                            ->helperText('Secreto para validar las firmas de los webhooks')
                            ->placeholder('7c9b512de072ed10...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Información')
                    ->schema([
                        Forms\Components\Placeholder::make('info')
                            ->label('')
                            ->content('Estos valores se guardarán en la base de datos y tendrán prioridad sobre las variables del archivo .env. Para obtener tus credenciales, ingresa a tu cuenta de Mercado Pago en la sección de Desarrolladores.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('mercadopago_access_token', $data['access_token'], 'Access Token de Mercado Pago');
        Setting::set('mercadopago_notification_url', $data['notification_url'], 'URL de notificación de Mercado Pago');
        Setting::set('mercadopago_webhook_secret', $data['webhook_secret'], 'Secreto del webhook de Mercado Pago');

        // Limpiar cache de configuración
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->body('Las credenciales de Mercado Pago se han actualizado correctamente.')
            ->send();
    }
}
