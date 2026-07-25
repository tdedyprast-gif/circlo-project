<?php

namespace App\Filament\Resources\Grants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GrantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('donor_id')
                    ->relationship('donor', 'organization_name')
                    ->required(),
                TextInput::make('grant_name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                
                TextInput::make('total_funding_amount')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set) {
                        self::calculateCostPerBeneficiary($get, $set);
                    }),

                TextInput::make('target_beneficiaries_count')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set) {
                        self::calculateCostPerBeneficiary($get, $set);
                    }),

                TextInput::make('cost_per_beneficiary_target')
                    ->numeric()
                    ->readOnly(),

                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'DRAFT' => 'Draft',
                        'ACTIVE' => 'Active',
                        'COMPLETED' => 'Completed',
                        'AUDITED' => 'Audited',
                    ])
                    ->default('DRAFT')
                    ->required(),
            ]);
    }

    /**
     * Method kalkulasi tanpa membatasi namespace Get dan Set secara ketat.
     */
    protected static function calculateCostPerBeneficiary($get, $set): void
    {
        $totalFunding = (float) $get('total_funding_amount');
        $targetCount = (int) $get('target_beneficiaries_count');

        if ($targetCount > 0 && $totalFunding > 0) {
            $result = $totalFunding / $targetCount;
            $set('cost_per_beneficiary_target', round($result, 2));
        } else {
            $set('cost_per_beneficiary_target', null);
        }
    }
}