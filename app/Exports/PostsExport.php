<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Post::with('categories')
            ->select('id', 'title', 'amount', 'order', 'order_date', 'number_of_shares', 'status')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Küpe No',
            'Fiyat',
            'Hisse Fiyatı',
            'Kesim Sırası',
            'Kesim Tarihi',
            'Hissedar Sayısı',
            'Durum',
            'Kategori',
        ];
    }

    public function map($post): array
    {
        $statusMap = [
            'sold'        => 'Satışta',
            'pending'     => 'Satış Bekliyor',
            'not_ready'   => 'Hazır Değil',
            'was_cut_off' => 'Kesildi',
        ];

        $categories = $post->categories->pluck('name')->implode(', ');

        return [
            $post->id,
            $post->title,
            number_format($post->amount, 2, '.', '') . ' TL',
            number_format($post->amount / 7, 2, '.', '') . ' TL',
            $post->order ?? '-',
            $post->order_date ? date('d.m.Y', strtotime($post->order_date)) : '-',
            $post->number_of_shares . ' Kişi',
            $statusMap[$post->status] ?? $post->status,
            $categories ?: '-',
        ];
    }
}
