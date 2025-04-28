<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsSharesExport implements FromCollection, WithHeadings, WithMapping
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Verileri getirir.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $post = Post::where('id', $this->id)->select('id','order','order_date','amount', 'title', 'share_holders_json')->get();
        return $post;
    }

    /**
     * Sütun başlıklarını belirler.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Küpe No',
            'Kesim Tarihi',
            'Kesim Sırası',
            'Hissedar Sahibi',
            'Telefon Numaras',
            'Vekalet Sahibi',
            'Vekalet Telefon Numaras',
            'Ödenen Tutar',
            'Kalan Tutar',
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
        $shareholders = json_decode($post->share_holders_json, true);
        $shareholderData = [];

        foreach ($shareholders as $shareholder) {
            $shareholderData[] = [
                'Küpe No' => $post->title,
                'Kesim Tarihi' => date('d-m-Y H:i', strtotime($post->order_date)),
                'Kesim Sırası' => $post->order,
                'Hissedar' => $shareholder['full_name'],
                'Telefon' => $shareholder['phone'],
                'Vekalet' => $shareholder['vekalet'],
                'Vekalet Telefon' => $shareholder['vekalet_phone'],
                'Ödenen Tutar' => $this->calculateTotalPayment($shareholder['paymentItems'],$post)['odenen'],
                'Kalan Tutar' => $this->calculateTotalPayment($shareholder['paymentItems'],$post)['kalan'],
            ];
        }

        return $shareholderData;
    }


    private function calculateTotalPayment($paymentItems,$post)
    {
        $totalPayment = 0;
        foreach ($paymentItems as $payment) {
            $totalPayment += (float) $payment['price'];
        }

        return ['odenen' => number_format($totalPayment, 2) . ' ₺', 'kalan' => number_format($post->amount - $totalPayment, 2) . ' ₺'];
    }
}
