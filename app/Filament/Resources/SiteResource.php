<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Site;
use Dotenv\Util\Str;
use Filament\Tables;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Tables\Columns\AdminLink;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SiteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SiteResource\RelationManagers;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('domainName')->required(),
                //Forms\Components\TextInput::make('J4'),
                Forms\Components\Toggle::make('J4')
                    ->label('Sito con Joomla 4?')
                    ->inline(false)
                    ->live(onBlur: true),
                Forms\Components\TextInput::make('token')->disabled(function (Get $get): bool {
                    return !$get('J4');
                }),

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null) //Azioni sulla riga

            ->recordUrl(null)   //Azioni sulla riga

            ->columns([

                Tables\Columns\TextColumn::make('domainName')->label('Sito')->getStateUsing(function (Model $record) {
                    return "<a href='http://www.$record->domainName' target='_blank'>$record->domainName</a>";
                })->searchable()->html(),
                Tables\Columns\TextColumn::make('admin')->getStateUsing(function (Model $record) {
                    return "<a href='http://www.$record->domainName/administrator' target='_blank'>$record->domainName/administrator</a>";
                })->html(),
                Tables\Columns\IconColumn::make('token')->boolean(),
                Tables\Columns\IconColumn::make('J4')->boolean()



            ])
            ->filters([
                Filter::make('J4')->query(fn (Builder $query): Builder => $query->where('J4', 1))->toggle(),
                Filter::make('-token')->label('Non hanno il token')->query(fn (Builder $query): Builder => $query->whereNull('token'))->toggle(),
                Filter::make('+token')->label('Hanno il token')->query(fn (Builder $query): Builder => $query->whereNotNull('token'))->toggle(),


            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->tooltip('Edit'),
            ]);

        //->bulkActions([
        //    Tables\Actions\BulkActionGroup::make([
        //        Tables\Actions\DeleteBulkAction::make(),
        //    ]),
        //]);
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
            'index' => Pages\ListSites::route('/'),
            //'create' => Pages\CreateSite::route('/create'),
            //'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
