@extends('layouts.front')
@section('title', 'Réserver une prestation - LetiMNails')
@section('meta_description', 'Réservez votre prestation de pose ou dépose d\'ongles chez LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Réserver une prestation</h1>
        <p>Vous pouvez réserver une prestation directement depuis cette page</p>
    </div>
</section>

<div class="container section" style="max-width:900px;margin:0 auto">
    @if($appointmentTypes->count() > 0)
    <div class="reservation-types">
        @foreach($appointmentTypes as $type)
        <div class="reservation-card">
            <h3>{{ $type->name }}</h3>
            @if($type->description)
            <p style="color:var(--text-light);margin-bottom:10px">{{ $type->description }}</p>
            @endif
            <p style="font-size:0.9rem;color:var(--text-light)">Durée : {{ $type->formatted_duration }}</p>
            @if($type->price)
            <p style="font-size:1.3rem;font-weight:700;color:var(--primary-dark);margin:10px 0">{{ number_format($type->price, 2) }} €</p>
            @endif
            <div class="actions">
                <button class="btn btn-primary btn-sm" onclick="openReservationForm({{ $type->id }}, '{{ $type->name }}', 'Pose')">Réserver une pose</button>
                <button class="btn btn-outline btn-sm" onclick="openReservationForm({{ $type->id }}, '{{ $type->name }}', 'Dépose')">Réserver une dépose</button>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:40px 0">
        <h3>Les réservations arrivent bientôt</h3>
        <p style="color:var(--text-light)">En attendant, vous pouvez nous contacter via la page Support.</p>
    </div>
    @endif
</div>

<div class="modal-overlay" id="reservation-modal">
    <div class="modal" style="max-width:550px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <h3 id="modal-title">Réserver une prestation</h3>
            <button style="border:none;background:none;font-size:1.5rem;cursor:pointer" onclick="closeReservationForm()">&times;</button>
        </div>
        <form action="{{ route('reservation.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="appointment_type_id" id="modal-type-id">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
                <div class="form-group">
                    <label for="modal-first-name">Prénom *</label>
                    <input type="text" class="form-control" id="modal-first-name" name="first_name" value="{{ old('first_name', auth()->user()?->name ? explode(' ', auth()->user()->name)[0] : '') }}" required>
                </div>
                <div class="form-group">
                    <label for="modal-last-name">Nom *</label>
                    <input type="text" class="form-control" id="modal-last-name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="modal-email">Email *</label>
                <input type="email" class="form-control" id="modal-email" name="email" value="{{ old('email', auth()->user()?->email) }}" required>
            </div>

            <div class="form-group">
                <label for="modal-phone">Téléphone *</label>
                <input type="tel" class="form-control" id="modal-phone" name="phone" value="{{ old('phone', auth()->user()?->phone) }}" required>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
                <div class="form-group">
                    <label for="modal-date">Date *</label>
                    <input type="date" class="form-control" id="modal-date" name="date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="form-group">
                    <label for="modal-time">Horaire *</label>
                    <select class="form-control" id="modal-time" name="time" required>
                        <option value="">Sélectionnez</option>
                        @for($h = 9; $h <= 17; $h++)
                        <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                        <option value="{{ sprintf('%02d:30', $h) }}">{{ sprintf('%02d:30', $h) }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="modal-notes">Notes</label>
                <textarea class="form-control" id="modal-notes" name="notes" rows="3" placeholder="Informations complémentaires..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                Confirmer la réservation
            </button>
        </form>
    </div>
</div>

@if(session('success'))
<script>document.addEventListener('DOMContentLoaded', function() { document.getElementById('reservation-modal').classList.remove('open'); });</script>
@endif
@endsection

@push('scripts')
<script>
function openReservationForm(typeId, typeName, actionType) {
    document.getElementById('modal-type-id').value = typeId;
    document.getElementById('modal-title').textContent = actionType + ' - ' + typeName;
    document.getElementById('reservation-modal').classList.add('open');
}
function closeReservationForm() {
    document.getElementById('reservation-modal').classList.remove('open');
}
</script>
@endpush
