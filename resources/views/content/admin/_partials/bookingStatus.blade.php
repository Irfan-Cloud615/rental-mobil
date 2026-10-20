@php
$map = [
    'pending_payment' => ['label' => 'Menunggu Pembayaran', 'color' => 'bg-label-warning'],
    'waiting_verification' => ['label' => 'Menunggu Verifikasi', 'color' => 'bg-label-info'],
    'confirmed' => ['label' => 'Dikonfirmasi', 'color' => 'bg-label-primary'],
    'completed' => ['label' => 'Selesai', 'color' => 'bg-label-success'],
    'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-label-secondary'],
];
$item = $map[$status] ?? ['label' => ucfirst(str_replace('_', ' ', $status)), 'color' => 'bg-label-secondary'];
@endphp
<span class="badge {{ $item['color'] }}">{{ $item['label'] }}</span>
