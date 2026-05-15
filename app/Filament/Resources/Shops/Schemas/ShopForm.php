<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Βασικές Πληροφορίες')
                    ->description('Τα στοιχεία επικοινωνίας του μαγαζιού.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Όνομα Μαγαζιού')
                            ->required(),
                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('phone')
                            ->label('Τηλέφωνο')
                            ->tel(),
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                    ])->columns(2),

                Section::make('Εμφάνιση & Branding')
                    ->description('Διαλέξτε τα χρώματα και το λογότυπο για τη βιτρίνα σας.')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Λογότυπο (Αυτόματη μετατροπή σε WebP)')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->saveUploadedFileUsing(function ($file) {
                                $filename = Str::uuid().'.webp';
                                $path = 'logos/'.$filename;

                                $manager = new ImageManager(new GdDriver);
                                $image = $manager->decode($file);
                                $image->scale(width: 600);
                                $encoded = $image->encode(new WebpEncoder(quality: 80));

                                Storage::disk('public')->put($path, (string) $encoded);

                                return $path;
                            }),

                        ColorPicker::make('primary_color')
                            ->label('Κυρίως Χρώμα (Buttons)')
                            ->default('#4c1d95'),

                        ColorPicker::make('accent_color')
                            ->label('Χρώμα Τονισμού (Accents)')
                            ->default('#2dd4bf'),
                    ])->columns(2),
            ]);
    }
}
