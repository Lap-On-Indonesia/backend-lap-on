<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionMarketplaceResource\Pages;
use App\Models\TransactionMarketplace;
use App\Models\User;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionMarketplaceResource extends Resource
{
    protected static ?string $model = TransactionMarketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),
                Select::make('product_id')
                    ->label('Product')
                    ->options(Product::all()->pluck('name_product', 'product_id'))
                    ->required(),
                TextInput::make('total')
                    ->label('Total')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->required(),
                TextInput::make('status')
                    ->label('Status')
                    ->required(),
                TextInput::make('payment_url')
                    ->label('Payment URL')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product.name_product')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR', true),
                TextColumn::make('status')
                    ->label('Status'),
                TextColumn::make('payment_url')
                    ->label('Payment URL'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactionMarketplaces::route('/'),
            'create' => Pages\CreateTransactionMarketplace::route('/create'),
            'edit' => Pages\EditTransactionMarketplace::route('/{record}/edit'),
        ];
    }
}
