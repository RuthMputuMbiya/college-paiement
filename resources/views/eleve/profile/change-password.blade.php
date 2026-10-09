{{-- resources/views/eleve/profile/change-password.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Changer mon mot de passe')
@section('page-title', 'Changer mon mot de passe')
@section('page-subtitle', 'Définissez un nouveau mot de passe sécurisé')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-key"></i> Nouveau mot de passe</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('eleve.profile.update-password') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label required">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label required">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </form>
    </div>
</div>
@endsection