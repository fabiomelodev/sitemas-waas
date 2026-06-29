<?php

namespace App\Filament\Resources\SupportTickets;

use App\Filament\Resources\SupportTickets\Pages\EditSupportTicket;
use App\Filament\Resources\SupportTickets\Pages\ListSupportTickets;
use App\Models\SupportTicket;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static ?string $label = 'Chamado';

    protected static ?string $pluralLabel = 'Chamados';

    protected static string|UnitEnum|null $navigationGroup = 'Clientes e Assinaturas';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(8)
                    ->schema([
                        TextInput::make('subject')
                            ->label('Assunto')
                            ->disabled(),
                        Textarea::make('message')
                            ->label('Mensagem do cliente')
                            ->rows(5)
                            ->disabled(),
                        Textarea::make('admin_reply')
                            ->label('Sua resposta')
                            ->rows(5),
                    ]),
                Section::make()
                    ->columnSpan(4)
                    ->schema([
                        Select::make('user_id')
                            ->label('Cliente')
                            ->relationship('user', 'name')
                            ->disabled(),
                        Select::make('status')
                            ->label('Status')
                            ->options(SupportTicket::STATUSES)
                            ->default('open')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Assunto')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => SupportTicket::STATUSES[$state] ?? $state)
                    ->colors([
                        'warning' => 'open',
                        'info' => 'in_progress',
                        'success' => 'closed',
                    ]),
                TextColumn::make('created_at')
                    ->label('Aberto em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(SupportTicket::STATUSES),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupportTickets::route('/'),
            'edit' => EditSupportTicket::route('/{record}/edit'),
        ];
    }
}
