<?php

namespace App\Filament\Client\Resources\SiteConfigs;

use App\Filament\Client\Resources\SiteConfigs\Pages\EditSiteConfig;
use App\Filament\Client\Resources\SiteConfigs\Pages\ListSiteConfigs;
use App\Models\SiteConfig;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SiteConfigResource extends Resource
{
    protected static ?string $model = SiteConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'company_name';

    protected static ?string $label = 'Meu Site';

    protected static ?string $pluralLabel = 'Meu Site';

    protected static ?int $navigationSort = 1;

    /**
     * Garante que o cliente só enxerga e edita o próprio site (escopo por
     * usuário aplicado tanto na listagem quanto na resolução do registro).
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Dados do site')
                    ->description('Estas informações são usadas para configurar o seu site.')
                    ->columnSpan(8)
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nome da empresa')
                            ->required(),
                        TextInput::make('domain')
                            ->label('Domínio próprio')
                            ->placeholder('seunegocio.com.br')
                            ->helperText('Deixe em branco se ainda não tiver um domínio.'),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel(),
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/seunegocio'),
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->placeholder('https://facebook.com/seunegocio'),
                    ]),
                Section::make('Identidade visual')
                    ->columnSpan(4)
                    ->schema([
                        FileUpload::make('brand')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->visibility('public'),
                        ColorPicker::make('primary_color')
                            ->label('Cor principal'),
                    ]),
                Section::make('Conteúdo do site (briefing)')
                    ->description('Quanto mais completo, mais rápido seu site fica pronto.')
                    ->columnSpan(12)
                    ->columns(2)
                    ->schema([
                        Textarea::make('about')
                            ->label('Sobre o seu negócio')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('services')
                            ->label('Produtos / serviços')
                            ->helperText('Liste os serviços ou produtos que devem aparecer no site.')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('business_hours')
                            ->label('Horário de atendimento')
                            ->placeholder('Seg a Sex, 9h às 18h'),
                        TextInput::make('address')
                            ->label('Endereço'),
                        FileUpload::make('photos')
                            ->label('Fotos')
                            ->helperText('Fotos do seu trabalho, equipe ou produtos.')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Empresa')
                    ->searchable(),
                TextColumn::make('domain')
                    ->label('Domínio')
                    ->placeholder('—'),
                IconColumn::make('is_finished')
                    ->label('No ar')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteConfigs::route('/'),
            'edit' => EditSiteConfig::route('/{record}/edit'),
        ];
    }
}
