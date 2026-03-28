<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'log_name'         => $this->log_name,
            'description'      => $this->buildDescription(),
            'subject_type'     => $this->subject_type,
            'subject_label'    => $this->subjectLabel(),
            'subject_name'     => $this->subjectName(),
            'changed_fields'   => $this->changedFields(),
            'event'            => $this->event,
            'causer_type'      => $this->causer_type,
            'causer_id'        => $this->causer_id,
            'properties'       => $this->properties,
            'batch_uuid'       => $this->batch_uuid,
            'created_at'       => $this->created_at,
            'format_created_at' => $this->created_at->diffForHumans(),
            'created_at_full'  => $this->created_at->format('d.m.Y H:i'),
        ];
    }

    private function buildDescription(): string
    {
        $label = $this->subjectLabel();
        $name  = $this->subjectName();

        return match ($this->event) {
            'created' => "{$label} oluşturuldu: {$name}",
            'updated' => "{$label} güncellendi: {$name}",
            'deleted' => "{$label} silindi: {$name}",
            'login'   => 'Sisteme giriş yapıldı',
            'logout'  => 'Sistemden çıkış yapıldı',
            default   => $this->description ?? ucfirst($this->event),
        };
    }

    private function subjectLabel(): string
    {
        return match ($this->subject_type) {
            'App\\Models\\Post'     => 'Kurban',
            'App\\Models\\User'     => 'Kullanıcı',
            'App\\Models\\Category' => 'Kategori',
            'App\\Models\\Role'     => 'Rol',
            default => $this->subject_type ? class_basename($this->subject_type) : 'Sistem',
        };
    }

    private function subjectName(): string
    {
        // Try the live model first
        try {
            $subject = $this->subject;
            if ($subject) {
                return $subject->title ?? $subject->name ?? "#{$subject->id}";
            }
        } catch (\Throwable) {}

        // Fall back to stored properties
        $attrs = $this->properties['attributes'] ?? $this->properties['old'] ?? [];
        return $attrs['title'] ?? $attrs['name'] ?? ($this->subject_id ? "#{$this->subject_id}" : '—');
    }

    private function changedFields(): ?string
    {
        if ($this->event !== 'updated') return null;

        $old = $this->properties['old'] ?? [];
        $new = $this->properties['attributes'] ?? [];

        $fieldLabels = [
            'title'               => 'Küpe No',
            'amount'              => 'Fiyat',
            'status'              => 'Durum',
            'order'               => 'Kesim Sırası',
            'order_date'          => 'Kesim Tarihi',
            'content'             => 'Not',
            'name'                => 'İsim',
            'email'               => 'E-posta',
            'number_of_shares'    => 'Hissedar Sayısı',
            'share_holders_json'  => 'Hissedar Bilgileri',
        ];

        $changes = [];
        foreach ($new as $key => $newVal) {
            if (array_key_exists($key, $old) && $old[$key] !== $newVal && isset($fieldLabels[$key])) {
                $changes[] = $fieldLabels[$key];
            }
        }

        return empty($changes) ? null : implode(', ', $changes);
    }
}
