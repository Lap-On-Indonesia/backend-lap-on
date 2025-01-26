<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\CategoryMarketplace;
use App\Models\OwnerMarketplace;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getNavigationGroup(): ?string
    {
        return 'Admin Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name_product')
                    ->label('Nama Produk')
                    ->required(),
                Select::make('owner_marketplace_id')
                    ->label('Owner')
                    ->options(OwnerMarketplace::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->default(fn () => auth()->user()->hasRole('super_admin') ? null : auth()->user()->owner_marketplace_id)
                    ->disabled(fn () => !auth()->user()->hasRole('super_admin')),
                Select::make('category_marketplace_id')
                    ->label('Category Marketplace')
                    ->options(CategoryMarketplace::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->required(),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('product')
                    ->required(),
                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')
                    ->label('Product ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_product')
                    ->label('Nama Produk'),
                TextColumn::make('categoryMarketplace.name')
                    ->label('Category Marketplace')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Image')
                    ->width(100)
                    ->height(100),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', true),
                TextColumn::make('stock')
                    ->label('Stock'),
                TextColumn::make('description')
                    ->label('Deskripsi'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->check() && auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        if (auth()->check() && !empty(auth()->user()->owner_marketplace_id)) {
            return parent::getEloquentQuery()->where('owner_marketplace_id', auth()->user()->owner_marketplace_id);
        }

        // Default: Jika tidak memenuhi syarat, kembalikan query kosong
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }
}
