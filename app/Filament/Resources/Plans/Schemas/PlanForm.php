<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        RichEditor::make('description')
                            ->label('Descrição'),
                        TextInput::make('url')
                            ->url(),
                        Repeater::make('features')
                            ->label('Recursos')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Recurso')
                                    ->required(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([1 => 'Ativo', 0 => 'Inativo'])
                                    ->default(1)
                                    ->required(),
                            ])
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('Preço')
                            ->required()
                            ->numeric()
                            ->prefix('R$'),
                        Select::make('status')
                            ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                            ->default('active')
                            ->required(),
                    ]),
            ]);
    }
}
