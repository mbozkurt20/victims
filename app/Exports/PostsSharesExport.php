<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsSharesExport implements FromArray, WithHeadings
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    private function getPost()
    {
        return Post::where('id', $this->id)
            ->select('id', 'order', 'order_date', 'amount', 'title', 'share_holders_json')
            ->first();
    }

    private function maxPayments($shareholders): int
    {
        $max = 0;
        foreach ($shareholders as $sh) {
            $cnt = count($sh['paymentItems'] ?? []);
            if ($cnt > $max) $max = $cnt;
        }
        return $max;
    }

    public function array(): array
    {
        $post = $this->getPost();
        if (!$post) return [];

        $shareholders = json_decode($post->share_holders_json, true) ?? [];
        $maxPay = $this->maxPayments($shareholders);
        $sharePriceUnit = $post->amount / 7;
        $cutDate = $post->order_date ? date('d.m.Y', strtotime($post->order_date)) : '-';

        $rows = [];
        foreach ($shareholders as $idx => $sh) {
            $paymentItems = $sh['paymentItems'] ?? [];
            $totalPaid = array_sum(array_column($paymentItems, 'price'));
            $remaining = $sharePriceUnit - $totalPaid;

            $row = [
                $post->title,
                $cutDate,
                $post->order ?? '-',
                ($idx + 1),
                $sh['full_name'] ?? '-',
                $sh['phone'] ?? '-',
                $sh['vekalet'] ?? '-',
                $sh['vekalet_phone'] ?? '-',
            ];

            for ($i = 0; $i < $maxPay; $i++) {
                if (isset($paymentItems[$i])) {
                    $p = $paymentItems[$i];
                    $row[] = number_format((float)($p['price'] ?? 0), 2, '.', '') . ' TL';
                    $row[] = $p['payment_type'] ?? '-';
                    $row[] = isset($p['date']) ? date('d.m.Y', strtotime($p['date'])) : '-';
                } else {
                    $row[] = '-';
                    $row[] = '-';
                    $row[] = '-';
                }
            }

            $row[] = number_format($totalPaid, 2, '.', '') . ' TL';
            $row[] = number_format($remaining, 2, '.', '') . ' TL';

            $rows[] = $row;
        }

        return $rows;
    }

    public function headings(): array
    {
        $post = $this->getPost();
        $shareholders = json_decode($post->share_holders_json ?? '[]', true) ?? [];
        $maxPay = $this->maxPayments($shareholders);

        $heads = [
            'Kupe No',
            'Kesim Tarihi',
            'Kesim Sirasi',
            'Hissedar No',
            'Ad Soyad',
            'Telefon',
            'Vekalet',
            'Vekalet Tel',
        ];

        for ($i = 1; $i <= $maxPay; $i++) {
            $heads[] = $i . '. Odeme Tutar';
            $heads[] = $i . '. Odeme Sekli';
            $heads[] = $i . '. Odeme Tarihi';
        }

        $heads[] = 'Toplam Odenen';
        $heads[] = 'Kalan Tutar';

        return $heads;
    }
}
