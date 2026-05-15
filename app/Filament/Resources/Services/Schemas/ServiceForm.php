<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select; 
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Όνομα Υπηρεσίας')
                    ->required(),

                TextInput::make('price')
                    ->label('Τιμή (€)')
                    ->required()
                    ->numeric()
                    ->prefix('€') // Το αλλάξαμε σε Ευρώ
                    // Senior Logic: Μετατροπή cents σε ευρώ για την οθόνη
                    ->formatStateUsing(fn ($state) => $state / 100)
                    // Μετατροπή ευρώ σε cents για τη βάση
                    ->dehydrateStateUsing(fn ($state) => $state * 100),

                TextInput::make('duration_minutes')
                    ->label('Διάρκεια (λεπτά)')
                    ->required()
                    ->numeric()
                    ->suffix('min'),

                // Εδώ η μεγάλη αλλαγή: Από TextInput το κάναμε Select
                Select::make('shop_id')
                    ->label('Μαγαζί')
                    ->relationship('shop', 'name') // Συνδέεται αυτόματα με τα μαγαζιά
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}