<?php

namespace App\Filament\Pages;

use App\Filament\Forms\ImageUpload;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?string $slug = 'settings';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::values());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan')
                    ->persistTabInQueryString()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Umum & SEO')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Nama situs')
                                    ->helperText('Dipakai di judul tab browser, contoh: "Artikel - Syaifulloh".')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Textarea::make('site_description')
                                    ->label('Deskripsi situs (meta description)')
                                    ->helperText('Idealnya 120–160 karakter. Tampil di hasil pencarian Google.')
                                    ->rows(3)
                                    ->maxLength(300),
                                Forms\Components\TextInput::make('site_keywords')
                                    ->label('Kata kunci')
                                    ->helperText('Pisahkan dengan koma.'),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        ImageUpload::make('logo', 'settings')
                                            ->label('Logo / favicon'),
                                        ImageUpload::make('og_image', 'settings')
                                            ->label('Gambar saat dibagikan (Open Graph)')
                                            ->helperText('Muncul saat link dibagikan ke WhatsApp/Facebook. Jika kosong memakai foto hero.'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Hero')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('hero_greeting')
                                            ->label('Sapaan'),
                                        Forms\Components\TextInput::make('hero_title')
                                            ->label('Judul')
                                            ->required(),
                                    ]),
                                Forms\Components\RichEditor::make('hero_text')
                                    ->label('Perkenalan')
                                    ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList', 'undo', 'redo']),
                                ImageUpload::make('hero_image', 'settings')
                                    ->label('Foto'),
                                Forms\Components\Toggle::make('hero_particles')
                                    ->label('Animasi partikel di latar hero')
                                    ->helperText('Titik-titik amber yang bergerak halus. Otomatis nonaktif untuk pengunjung yang mengatur "kurangi gerakan" di perangkatnya.')
                                    ->default(true),
                                Forms\Components\Repeater::make('social_links')
                                    ->label('Tombol media sosial')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),
                                        Forms\Components\Select::make('color')
                                            ->label('Warna')
                                            ->options([
                                                'pink' => 'Pink',
                                                'sky' => 'Biru muda',
                                                'blue' => 'Biru',
                                                'slate' => 'Abu-abu',
                                                'red' => 'Merah',
                                                'emerald' => 'Hijau',
                                                'amber' => 'Oranye',
                                            ])
                                            ->default('slate')
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->reorderable()
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah tombol'),
                                Forms\Components\Repeater::make('hero_stats')
                                    ->label('Angka pencapaian')
                                    ->helperText('Tampil sebagai deretan angka di bawah hero. Maksimal 4.')
                                    ->schema([
                                        Forms\Components\TextInput::make('value')
                                            ->label('Angka')
                                            ->placeholder('13+')
                                            ->required()
                                            ->maxLength(20),
                                        Forms\Components\TextInput::make('label')
                                            ->label('Keterangan')
                                            ->placeholder('Tahun pengalaman')
                                            ->required()
                                            ->maxLength(60),
                                    ])
                                    ->columns(2)
                                    ->reorderable()
                                    ->maxItems(4)
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah angka'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Tentang')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Forms\Components\TextInput::make('about_title')
                                    ->label('Judul bagian'),
                                Forms\Components\RichEditor::make('about_text')
                                    ->label('Isi')
                                    ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList', 'undo', 'redo']),
                                ImageUpload::make('about_image', 'settings')
                                    ->label('Gambar'),
                                Forms\Components\TextInput::make('profile_title')
                                    ->label('Judul bagian Detail Profil')
                                    ->helperText('Isi detail profil (accordion) diatur di menu "Detail Profil".'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Bagian Halaman')
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                Forms\Components\Section::make('Media & Publikasi')
                                    ->schema([
                                        Forms\Components\TextInput::make('media_title')
                                            ->label('Judul'),
                                        ImageUpload::make('media_image', 'settings')
                                            ->label('Gambar'),
                                    ]),
                                Forms\Components\Section::make('Buku')
                                    ->description('Daftar buku diatur di menu "Buku".')
                                    ->schema([
                                        Forms\Components\TextInput::make('books_title')
                                            ->label('Judul'),
                                        Forms\Components\TextInput::make('books_subtitle')
                                            ->label('Subjudul'),
                                        Forms\Components\TextInput::make('books_text')
                                            ->label('Keterangan'),
                                    ]),
                                Forms\Components\Section::make('Artikel & Gallery')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('articles_title')
                                            ->label('Judul bagian Artikel'),
                                        Forms\Components\TextInput::make('gallery_title')
                                            ->label('Judul bagian Gallery'),
                                    ]),
                                Forms\Components\Section::make('Achievements')
                                    ->description('Daftar achievement diatur di menu "Achievements".')
                                    ->schema([
                                        Forms\Components\TextInput::make('achievements_title')
                                            ->label('Judul'),
                                        Forms\Components\TextInput::make('achievements_subtitle')
                                            ->label('Subjudul'),
                                        ImageUpload::make('achievement_images', 'achievements')
                                            ->label('Foto slider')
                                            ->multiple()
                                            ->reorderable()
                                            ->panelLayout('grid'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Kontak & Footer')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Forms\Components\TextInput::make('contact_title')
                                    ->label('Judul bagian'),
                                Forms\Components\Textarea::make('contact_text')
                                    ->label('Teks')
                                    ->rows(3),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_whatsapp')
                                            ->label('Nomor WhatsApp')
                                            ->helperText('Format internasional tanpa +, contoh: 628123456789')
                                            ->tel()
                                            ->regex('/^[0-9]+$/'),
                                        Forms\Components\TextInput::make('contact_button')
                                            ->label('Teks tombol'),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('footer_text')
                                            ->label('Teks footer')
                                            ->helperText('Otomatis diawali © tahun berjalan.'),
                                        Forms\Components\TextInput::make('footer_url')
                                            ->label('Link footer')
                                            ->url(),
                                    ]),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        Setting::store($this->form->getState());

        Notification::make()
            ->title('Pengaturan disimpan')
            ->success()
            ->send();
    }
}
