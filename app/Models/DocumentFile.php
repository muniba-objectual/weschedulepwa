<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentFile
 *
 * @package App
 *
 * @property int id
 * @property string file_name
 * @property array|null file_meta_info
 * @property string directory_path
 * @property string file_category
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 */
class DocumentFile extends Model
{
    const CATEGORY_DYNAMIC_FORM = 'web_route';
    const CATEGORY_PDF = 'pdf';
    const CATEGORY_IMAGE = 'image';
    const CATEGORY_HTML = 'html';

    protected $table = 'document_files';

    protected $casts = [
        'file_meta_info' => 'array',
    ];

    protected $fillable = ['file_name', 'file_meta_info', 'directory_path', 'file_category'];
}
