<?php

namespace App\Filament\Resources\UserProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\UserProfile;
use Filament\Notifications\Notification;

class UserProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->rule(function () {
                        return function (string $attribute, $value, $fail) {
                            if (UserProfile::where('user_id', $value)->exists()) {
                                // tampilkan pop-up notification
                                Notification::make()
                                    ->title('Profil sudah ada')
                                    ->body('User ini sudah memiliki profil yang terdata.')
                                    ->danger()
                                    ->send();

                                $fail('User ini sudah memiliki profil.');
                            }
                        };
                    }),
                Select::make('gender')
                    ->options(['MALE' => 'M a l e', 'FEMALE' => 'F e m a l e', 'OTHER' => 'O t h e r'])
                    ->required(),
                DatePicker::make('birth_date'),
                TextInput::make('province_id')
                    ->required(),
                TextInput::make('regency_id')
                    ->required(),
                TextInput::make('district_id')
                    ->required(),
                Textarea::make('address_detail')
                    ->columnSpanFull(),
                Select::make('economic_status')
                    ->options([
                        'LOW_INCOME' => 'L o w  i n c o m e',
                        'MIDDLE_BELOW' => 'M i d d l e  b e l o w',
                        'MIDDLE_ABOVE' => 'M i d d l e  a b o v e',
                    ])
                    ->required(),
                TextInput::make('primary_occupation'),
                Toggle::make('is_disabled')
                    ->required(),
                TextInput::make('disability_type'),
            ]);
    }
}
