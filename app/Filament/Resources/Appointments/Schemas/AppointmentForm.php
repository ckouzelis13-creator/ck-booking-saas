<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\Section::make('Στοιχεία Πελάτη')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('customer_name')
                        ->label('Όνομα Πελάτη')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('customer_phone')
                        ->label('Τηλέφωνο')
                        ->required(),
                ])->columns(2),
    
                \Filament\Forms\Components\Section::make('Λεπτομέρειες Ραντεβού')
                ->schema([
                    \Filament\Forms\Components\Select::make('shop_id')
                        ->label('Μαγαζί')
                        ->relationship('shop', 'name')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn ($set) => $set('service_id', null)),
            
                    // ΕΔΩ ΤΟ ΒΑΖΟΥΜΕ
                    \Filament\Forms\Components\Select::make('employee_id')
                        ->label('Υπάλληλος')
                        ->relationship('employee', 'name') // Συνδέεται με τη σχέση employee στο Model
                        ->required()
                        ->live(), // Το κάνουμε live για να μπορούμε αργότερα να ελέγχουμε τη διαθεσιμότητα του

                        
                    \Filament\Forms\Components\Select::make('service_id')
                        ->label('Υπηρεσία')
                        ->required()
                        ->options(function (get $get) {
                            $shopId = $get('shop_id');
                            if (!$shopId) return [];
                            // Φιλτράρει τις υπηρεσίες βάσει του μαγαζιού που διαλέξαμε
                            return \App\Models\Service::where('shop_id', $shopId)->pluck('name', 'id');
                        })
                        ->live()
                        ->afterStateUpdated(function ($state, $set, $get) {
                            self::updateFinishTime($set, $get);
                        }),
    
                    \Filament\Forms\Components\DateTimePicker::make('start_time')
                        ->label('Έναρξη')
                        ->required()
                        ->displayFormat('d/m/Y H:i')
                        ->live()
                        ->afterStateUpdated(function ($set, $get) {
                            self::updateFinishTime($set, $get);
                        }),
    
                    \Filament\Forms\Components\DateTimePicker::make('finish_time')
                        ->label('Λήξη (Αυτόματα)')
                        ->required()
                        ->readonly() // Ο χρήστης δεν το αλλάζει, το υπολογίζουμε εμείς
                        ->displayFormat('d/m/Y H:i'),
                ])->columns(2),
        ]);
    }
    
    // Βοηθητική συνάρτηση για τον υπολογισμό του χρόνου
    protected static function updateFinishTime($set, $get)
    {
        $serviceId = $get('service_id');
        $startTime = $get('start_time');
    
        if ($serviceId && $startTime) {
            $service = \App\Models\Service::find($serviceId);
            $start = \Illuminate\Support\Carbon::parse($startTime);
            
            // Προσθέτουμε τα λεπτά της υπηρεσίας στην ώρα έναρξης
            $set('finish_time', $start->addMinutes($service->duration_minutes)->toDateTimeString());
        }
    }
}
