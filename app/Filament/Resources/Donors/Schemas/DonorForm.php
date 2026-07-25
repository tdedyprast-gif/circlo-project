<?php

namespace App\Filament\Resources\Donors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DonorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('organization_name')
                    ->required(),
                Select::make('type')
                    ->options([
            'CSR_CORPORATE' => 'C s r  c o r p o r a t e',
            'INTERNATIONAL_NGO' => 'I n t e r n a t i o n a l  n g o',
            'GOVERNMENT' => 'G o v e r n m e n t',
            'INDIVIDUAL' => 'I n d i v i d u a l',
        ])
                    ->required(),
                TextInput::make('contact_person_name')
                    ->required(),
                TextInput::make('contact_email')
                    ->email()
                    ->required(),
            ]);
    }
}
