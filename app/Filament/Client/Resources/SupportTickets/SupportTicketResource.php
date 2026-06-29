<?php

namespace App\Filament\Client\Resources\SupportTickets;

use App\Filament\Client\Resources\SupportTickets\Pages\CreateSupportTicket;
use App\Filament\Client\Resources\SupportTickets\Pages\ListSupportTickets;
use App\Models\SupportTicket;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLifebuoy;

    protected static ?string $label = 'Suporte';

    protected static ?string $pluralLabel = 'Suporte';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Abrir um chamado')
                    ->description('Descreva sua dúvida ou problema e nossa equipe responderá por aqui.')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Assunto')
                            ->required()
                            ->maxLength(120),
                        Textarea::make('message')
                            ->label('Mensagem')
                            ->required()
                            ->rows(6),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('subject')
                    ->label('Assunto')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => SupportTicket::STATUSES[$state] ?? $state)
                    ->color(fn (?string $state): string => match ($state) {
                        'open' => 'warning',
                        'in_progress' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('admin_reply')
                    ->label('Resposta')
                    ->placeholder('Aguardando resposta')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Aberto em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupportTickets::route('/'),
            'create' => CreateSupportTicket::route('/create'),
        ];
    }
}
