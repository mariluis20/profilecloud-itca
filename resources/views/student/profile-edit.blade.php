@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="text-white-50 small"><i class="bi bi-arrow-left me-1"></i>Volver al panel</a>
        <h1>Editar perfil</h1>
        <p>Esta información es la que verán las empresas y docentes en tu perfil público.</p>
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="pc-panel reveal text-center">
                    <div class="pc-panel-title justify-content-center"><i class="bi bi-camera"></i>Foto</div>
                    <div class="d-flex justify-content-center mb-3">
                        @if($profile->photo_url)
                            <img src="{{ $profile->photo_url }}" id="photoPreview" class="pc-avatar pc-avatar-xl" alt="Foto actual">
                        @else
                            <div id="photoPreview" class="pc-avatar pc-avatar-xl">{{ $user->initials }}</div>
                        @endif
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/png,image/jpeg,image/webp"
                           class="form-control @error('photo') is-invalid @enderror">
                    @error('photo')<div class="invalid-feedback text-start">{{ $message }}</div>@enderror
                    <small class="text-muted d-block mt-2">JPG, PNG o WEBP · máximo 2 MB</small>
                    @if($profile->photo_path)
                        <div class="form-check mt-3 d-inline-block">
                            <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                            <label class="form-check-label small" for="remove_photo">Quitar foto actual</label>
                        </div>
                    @endif
                </div>

                <div class="pc-panel reveal">
                    <div class="pc-panel-title"><i class="bi bi-sliders"></i>Preferencias</div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_public" name="is_public" value="1" @checked(old('is_public', $profile->is_public))>
                        <label class="form-check-label" for="is_public">Perfil público en el directorio</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="available" name="available" value="1" @checked(old('available', $profile->available))>
                        <label class="form-check-label" for="available">Disponible para pasantía o empleo</label>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="pc-panel reveal">
                    <div class="pc-panel-title"><i class="bi bi-person"></i>Información general</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Primer nombre <span class="text-danger">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" maxlength="60"
                                   class="form-control @error('first_name') is-invalid @enderror" required autocomplete="given-name">
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="middle_name" class="form-label">Segundo nombre <small class="text-muted fw-normal">(opcional)</small></label>
                            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" maxlength="60"
                                   class="form-control @error('middle_name') is-invalid @enderror" autocomplete="additional-name">
                            @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Primer apellido <span class="text-danger">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" maxlength="60"
                                   class="form-control @error('last_name') is-invalid @enderror" required autocomplete="family-name">
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="second_last_name" class="form-label">Segundo apellido <small class="text-muted fw-normal">(opcional)</small></label>
                            <input type="text" id="second_last_name" name="second_last_name" value="{{ old('second_last_name', $user->second_last_name) }}" maxlength="60"
                                   class="form-control @error('second_last_name') is-invalid @enderror" autocomplete="family-name">
                            @error('second_last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="headline" class="form-label">Titular profesional</label>
                            <input type="text" id="headline" name="headline" value="{{ old('headline', $profile->headline) }}" maxlength="150" class="form-control @error('headline') is-invalid @enderror" placeholder="Ej. Desarrollador web en formación">
                            @error('headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="carrera" class="form-label">Carrera</label>
                            <select id="carrera" name="carrera" class="form-select @error('carrera') is-invalid @enderror" required>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera }}" @selected(old('carrera', $profile->carrera) === $carrera)>{{ $carrera }}</option>
                                @endforeach
                            </select>
                            @error('carrera')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="sede" class="form-label">Sede</label>
                            <select id="sede" name="sede" class="form-select @error('sede') is-invalid @enderror">
                                <option value="">—</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede }}" @selected(old('sede', $profile->sede) === $sede)>{{ $sede }}</option>
                                @endforeach
                            </select>
                            @error('sede')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="ciclo" class="form-label">Ciclo</label>
                            <input type="number" id="ciclo" name="ciclo" min="1" max="10" value="{{ old('ciclo', $profile->ciclo) }}" class="form-control @error('ciclo') is-invalid @enderror">
                            @error('ciclo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="bio" class="form-label">Biografía</label>
                            <textarea id="bio" name="bio" rows="5" maxlength="2000" class="form-control @error('bio') is-invalid @enderror" placeholder="Cuéntale a los demás quién eres, qué te apasiona y qué buscas.">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="pc-panel reveal">
                    <div class="pc-panel-title"><i class="bi bi-link-45deg"></i>Enlaces</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="linkedin_url" class="form-label">LinkedIn</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="form-control @error('linkedin_url') is-invalid @enderror" placeholder="https://www.linkedin.com/in/usuario">
                                @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="github_url" class="form-label">GitHub</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-github"></i></span>
                                <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="form-control @error('github_url') is-invalid @enderror" placeholder="https://github.com/usuario">
                                @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="website_url" class="form-label">Sitio web o portafolio</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-globe2"></i></span>
                                <input type="url" id="website_url" name="website_url" value="{{ old('website_url', $profile->website_url) }}" class="form-control @error('website_url') is-invalid @enderror" placeholder="https://miportafolio.com">
                                @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-pc"><i class="bi bi-check2 me-1"></i>Guardar cambios</button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
