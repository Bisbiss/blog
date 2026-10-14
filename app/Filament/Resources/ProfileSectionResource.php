<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileSectionResource\Pages;
use App\Models\ProfileSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileSectionResource extends Resource
{
    protected static ?string $model = ProfileSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Halaman Depan';

    protected static ?string $modelLabel = 'Detail Profil';

    protected static ?string $pluralModelLabel = 'Detail Profil';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul accordion')
                            ->placeholder('Present Activities')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi')
                            ->toolbarButtons(['bold', 'italic', 'link', 'h3', 'bulletList', 'orderedList', 'undo', 'redo'])
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Tampilkan')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Tampil'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfileSections::route('/'),
            'create' => Pages\CreateProfileSection::route('/create'),
            'edit' => Pages\EditProfileSection::route('/{record}/edit'),
        ];
    }
}
