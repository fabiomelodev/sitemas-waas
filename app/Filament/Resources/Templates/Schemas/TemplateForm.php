<?php

namespace App\Filament\Resources\Templates\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TemplateForm
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
                        Textarea::make('excerpt')
                            ->label('Resumo')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('url')
                            ->url()
                            ->required(),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->visibility('public')
                            ->disk('public'),
                        Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->required(),
                        Select::make('plan_id')
                            ->label('Plano')
                            ->relationship('plan', 'name')
                            ->required(),
                        Select::make('status')
                            ->options(['active' => 'Ativo', 'inactive' => 'Inativo'])
                            ->default('active')
                            ->required(),
                    ]),
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        Repeater::make('features')
                            ->label('Características')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome')
                            ])
                    ])
            ]);
    }
}
