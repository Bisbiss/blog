<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Kolom slug sebelumnya hanya ditambahkan manual di database lokal,
     * jadi migration ini aman dijalankan baik kolomnya sudah ada maupun belum.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }

        // Isi slug yang kosong / duplikat supaya bisa diberi unique index.
        $used = [];
        foreach (DB::table('posts')->orderBy('id')->get(['id', 'title', 'slug']) as $post) {
            $slug = $post->slug ?: Str::slug($post->title);
            $slug = $slug ?: 'post-' . $post->id;

            if (in_array($slug, $used, true)) {
                $slug .= '-' . $post->id;
            }

            $used[] = $slug;

            if ($slug !== $post->slug) {
                DB::table('posts')->where('id', $post->id)->update(['slug' => $slug]);
            }
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->string('image')->nullable()->change();
        });

        if (! Schema::hasIndex('posts', ['slug'], 'unique')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });
    }
};
