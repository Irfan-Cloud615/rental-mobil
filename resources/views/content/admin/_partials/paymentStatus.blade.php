@php
$map = [
    'pending' => ['label' => 'Menunggu', 'color' => 'bg-label-warning'],
    'submitted' => ['label' => 'Perlu Verifikasi', 'color' => 'bg-label-info'],
    'completed' => ['label' => 'Lunas', 'color' => 'bg-label-success'],
    'rejected' => ['label' => 'Ditolak', 'color' => 'bg-label-danger'],
    'expired' => ['label' => 'Kedaluwarsa', 'color' => 'bg-label-secondary'],
];
$item = $map[$status] ?? ['label' => ucfirst($status), 'color' => 'bg-label-secondary'];
@endphp
<span class="badge {{ $item['color'] }}">{{ $item['label'] }}</span>
