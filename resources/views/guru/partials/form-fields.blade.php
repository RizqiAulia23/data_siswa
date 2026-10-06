@props(['guru' => null])

<!-- NIP -->
<x-input
    name="nip"
    id="nip"
    label="NIP"
    maxlength="20"
    :value="old('nip', $guru?->nip)"
    spellcheck="false"
/>

<!-- Nama -->
<x-input
    name="nama"
    id="nama"
    label="Nama Lengkap"
    maxlength="100"
    :value="old('nama', $guru?->nama)"
/>

<!-- Jenis Kelamin -->
<div>
    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="jenis_kelamin">
        Jenis Kelamin
    </label>
    <x-select name="jenis_kelamin" id="jenis_kelamin" placeholder="-- Pilih Jenis Kelamin --">
        <option value="L" {{ old('jenis_kelamin', $guru?->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin', $guru?->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
    </x-select>
    @error('jenis_kelamin')
        <p id="jenis_kelamin-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
    @enderror
</div>

<!-- Tanggal Lahir -->
<x-input
    type="date"
    name="tanggal_lahir"
    id="tanggal_lahir"
    label="Tanggal Lahir"
    :value="old('tanggal_lahir', $guru?->tanggal_lahir?->format('Y-m-d'))"
/>

<!-- Jam Masuk -->
<x-input
    type="text"
    name="jam_masuk"
    id="jam_masuk"
    label="Jam Masuk (Contoh: 07:00:00)"
    maxlength="8"
    :value="old('jam_masuk', $guru?->jam_masuk)"
/>

<!-- Gaji -->
<x-input
    type="number"
    step="0.01"
    name="gaji"
    id="gaji"
    label="Gaji"
    :value="old('gaji', $guru?->gaji)"
/>

<!-- Nomor HP -->
<x-input
    name="nomor_hp"
    id="nomor_hp"
    label="Nomor Handphone"
    maxlength="15"
    autocomplete="tel"
    inputmode="tel"
    :value="old('nomor_hp', $guru?->nomor_hp)"
/>

<!-- Status Aktif -->
<div>
    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="aktif">
        Status Aktif
    </label>
    <x-select name="aktif" id="aktif">
        <option value="1" {{ old('aktif', $guru?->aktif ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('aktif', $guru?->aktif ?? 1) == 0 ? 'selected' : '' }}>Non-Aktif</option>
    </x-select>
    @error('aktif')
        <p id="aktif-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
    @enderror
</div>

<!-- Alamat -->
<div class="md:col-span-2">
    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="alamat">
        Alamat Domisili
    </label>
    <textarea name="alamat" id="alamat" rows="3" autocomplete="street-address"
              class="w-full text-sm bg-white border rounded-lg px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-[border-color,box-shadow] duration-150 @error('alamat') border-rose-500 focus:border-rose-500 focus:ring-rose-500/20 @else border-slate-300 hover:border-slate-400 @enderror"
              @error('alamat') aria-invalid="true" aria-describedby="alamat-error" @enderror>{{ old('alamat', $guru?->alamat) }}</textarea>
    @error('alamat')
        <p id="alamat-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
    @enderror
</div>
