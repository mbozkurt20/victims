<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsSharesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Verileri getirir.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Post::select('id', 'share_holders_json')->get();
    }

    /**
     * Sütun başlıklarını belirler.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'full_name',
            'phone',

        ];
    }

    /**
     * Her satırı düzenler.
     *
     * @param $post
     * @return array
     */
    public function map($post): array
    {
        return [
            $post->id,
            $post->title,
            strip_tags($post->content), // HTML etiketlerini kaldırma
            $post->kg . ' kg', // kg ekleyerek düzenleme
            number_format($post->amount, 2) . ' ₺', // Parasal format
            $post->order,
            $post->age . ' yaş',
            $post->number_of_shares . ' Kişi',
            $post->status == 'sold' ? 'Satışta': ($post->status == 'pending' ? 'Satış Bekliyor' : 'Hazır Değil'), // Boolean değeri yazıya çevirme
        ];
    }
}
