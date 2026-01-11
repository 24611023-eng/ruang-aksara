<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\LoanBook
 *
 * @property int $id
 * @property int|null $original_book_id
 * @property string $judul
 * @property string|null $penulis
 * @property string|null $kategori
 * @property string|null $penerbit
 * @property string|null $isbn
 * @property int|null $loan_stok
 * @property string|null $image
 * @property int|null $halaman
 * @property string|null $deskripsi
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @mixin \Eloquent
 */
class LoanBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_books';

    protected $fillable = [
        'original_book_id',
        'judul',
        'penulis',
        'kategori',
        'penerbit',
        'isbn',
        'loan_stok',
        'image',
        'halaman',
        'deskripsi',
        'status',
    ];

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            return asset('storage/book-covers/' . $this->image);
        }
        return asset('images/default-book.jpg');
    }

    public function originalBook()
    {
        return $this->belongsTo(Book::class, 'original_book_id');
    }
}
