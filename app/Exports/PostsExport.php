<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Verileri getirir.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Post::select('id', 'title', 'content', 'amount', 'order', 'number_of_shares', 'status', 'share_holders_json')->get();
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
            'Başlık',
            'İçerik',
            'Tutar',
            'Sipariş Sırası',
            'Paylaşım Sayısı',
            'Durum',
            'Hissedarlar', // JSON verisini işleyerek eklenen alan
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
        $shareholders = $this->formatShareholders($post->share_holders_json);

        return [
            $post->id,
            $post->title,
            strip_tags($post->content), // HTML etiketlerini kaldırma
            number_format($post->amount, 2) . ' ₺', // Parasal format
            $post->order,
            $post->number_of_shares . ' paylaşım',
            $post->status ? 'Aktif' : 'Pasif', // Boolean değeri yazıya çevirme
            $shareholders, // JSON'dan gelen veriyi işleyerek ekleme
        ];
    }

    /**
     * Hissedarlar JSON verisini işler.
     *
     * @param string|null $json
     * @return string
     */
    private function formatShareholders(?string $json): string
    {
        if (!$json) {
            return 'Hissedar Yok';
        }

        $shareholders = json_decode($json, true);
        if (!$shareholders || !is_array($shareholders)) {
            return 'Geçersiz Veri';
        }

        $formatted = array_map(function ($holder) {
            $paymentType = $holder['payment_type'] ?? (isset($holder['paymentItems'][0]['payment_type']) ? $holder['paymentItems'][0]['payment_type'] : '-');
            return "{$holder['full_name']} ({$holder['phone']}) - {$paymentType}";
        }, $shareholders);

        return implode(" | ", $formatted);
    }
}
