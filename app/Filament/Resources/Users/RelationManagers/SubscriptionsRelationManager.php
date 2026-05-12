<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Subscriptions\SubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $relatedResource = SubscriptionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
