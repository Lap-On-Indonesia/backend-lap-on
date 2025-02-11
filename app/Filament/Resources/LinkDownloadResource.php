<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkDownloadResource\Pages;
use App\Filament\Resources\LinkDownloadResource\RelationManagers;
use App\Models\LinkDownload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;


class LinkDownloadResource extends Resource
{
    protected static ?string $model = LinkDownload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Company Profile';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('link')
                ->label('Link')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('link')
                ->label('Link')
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
            'index' => Pages\ListLinkDownloads::route('/'),
            'create' => Pages\CreateLinkDownload::route('/create'),
            'edit' => Pages\EditLinkDownload::route('/{record}/edit'),
        ];
    }
}
