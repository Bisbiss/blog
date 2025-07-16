<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use App\Filament\Resources\PostsResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set; // Import ini buat set state field lain
use Illuminate\Support\Str; // Import ini buat Str::slug()

class PostsResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->placeholder('Title')
                                    ->required()
                                    ->maxLength(255) // Tambahin max length biar aman
                                    ->reactive() // Ini penting biar slug field bisa denger perubahan title
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->live(onBlur: true), // Ini biar otomatis nge-update slug pas user pindah fokus dari field title

                                // Field Slug
                                Forms\Components\TextInput::make('slug')
                                    ->placeholder('Slug')
                                    ->required()
                                    ->maxLength(255) // Tambahin max length biar aman
                                    ->unique(ignoreRecord: true) // Penting: Slug harus unik, tapi ignore record yang lagi diedit
                                    ->helperText('Slug akan otomatis terisi dari judul'), // Kasih helper text biar jelas

                                ]),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image() // Pastikan ini cuma nerima gambar
                            ->nullable(), // Bikin ini nullable kalo gambar gak wajib

                        Forms\Components\RichEditor::make('content')
                            ->label('Content')
                            ->placeholder('Content')
                            ->required()
                            ->columnSpanFull(), // Bikin content ngambil full width
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(), // Bikin gambar jadi bulet
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyiin by default
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyiin by default
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Tambahin delete action
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePosts::route('/create'),
            'edit' => Pages\EditPosts::route('/{record}/edit'),
        ];
    }
}