<div class="form-grid">
    <div class="form-group full">
        <label for="titulo">Título del libro</label>
        <input type="text"
               id="titulo"
               name="titulo"
               value="{{ old('titulo', $libro->titulo ?? '') }}"
               class="form-control @error('titulo') is-invalid @enderror"
               placeholder="Ej. Bachué y el origen de la humanidad">
        @error('titulo')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="autor">Autor</label>
        <input type="text"
               id="autor"
               name="autor"
               value="{{ old('autor', $libro->autor ?? '') }}"
               class="form-control @error('autor') is-invalid @enderror"
               placeholder="Ej. Javier Ocampo López">
        @error('autor')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="anio">Año de publicación</label>
        <input type="number"
               id="anio"
               name="anio"
               value="{{ old('anio', $libro->anio ?? '') }}"
               class="form-control @error('anio') is-invalid @enderror"
               placeholder="Ej. 2006">
        @error('anio')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full">
        <label for="categoria_id">Categoría</label>
        <select id="categoria_id"
                name="categoria_id"
                class="form-control @error('categoria_id') is-invalid @enderror">
            <option value="">-- Selecciona una categoría --</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    {{ (string) old('categoria_id', $libro->categoria_id ?? '') === (string) $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @error('categoria_id')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group full">
        <input type="hidden" name="disponible" value="0">
        <div class="checkbox-row">
            <input type="checkbox"
                   id="disponible"
                   name="disponible"
                   value="1"
                   {{ (string) old('disponible', isset($libro) ? ($libro->disponible ? '1' : '0') : '1') === '1' ? 'checked' : '' }}>
            <label for="disponible">Disponible para préstamo</label>
        </div>
        @error('disponible')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>
</div>
