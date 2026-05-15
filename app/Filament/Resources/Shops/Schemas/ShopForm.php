<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Όνομα Μαγαζιού')
                    ->required()
                    ->live(onBlur: true) // "Ακούει" όταν τελειώσεις το γράψιμο
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                
                TextInput::make('slug')
                    ->label('URL (Slug)')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('phone')
                    ->label('Τηλέφωνο'),

                Select::make('user_id')
                    ->label('Ιδιοκτήτης')
                    ->relationship('user', 'name') // Συνδέει το μαγαζί με το όνομα του χρήστη
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}