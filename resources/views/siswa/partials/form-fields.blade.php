@props(['siswa' => null])

<!-- NIS -->
<x-input
    name="nis"
    id="nis"
    label="NIS"
    maxlength="10"
    :value="old('nis', $siswa?->nis)"
    required
    spellcheck="false"
/>

<!-- Nama -->
<x-input
    name="nama"
    id="nama"
    label="Nama Lengkap"
    :value="old('nama', $siswa?->nama)"
    required
/>

<!-- Jenis Kelamin -->
<div>
    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="jenis_kelamin">
        Jenis Kelamin
    </label>
    <x-select name="jenis_kelamin" id="jenis_kelamin" placeholder="-- Pilih Jenis Kelamin --">
        <option value="L" {{ old('jenis_kelamin', $siswa?->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin', $siswa?->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
    </x-select>
    @error('jenis_kelamin')
        <p id="jenis_kelamin-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
    @enderror
</div>

<!-- Agama -->
<x-input
    name="agama"
    id="agama"
    label="Agama"
    :value="old('agama', $siswa?->agama)"
/>

<!-- Email -->
<x-input
    type="email"
    name="email"
    id="email"
    label="Email"
    autocomplete="email"
    :value="old('email', $siswa?->email)"
/>

<!-- Nomor HP -->
<x-input
    name="nomor_hp"
    id="nomor_hp"
    label="Nomor Handphone"
    autocomplete="tel"
    inputmode="tel"
    :value="old('nomor_hp', $siswa?->nomor_hp)"
/>

<!-- Alamat -->
<div class="md:col-span-2">
    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="alamat">
        Alamat Domisili
    </label>
    <textarea name="alamat" id="alamat" rows="3" autocomplete="street-address"
              class="w-full text-sm bg-white border rounded-lg px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-[border-color,box-shadow] duration-150 @error('alamat') border-rose-500 focus:border-rose-500 focus:ring-rose-500/20 @else border-slate-300 hover:border-slate-400 @enderror"
              @error('alamat') aria-invalid="true" aria-describedby="alamat-error" @enderror>{{ old('alamat', $siswa?->alamat) }}</textarea>
    @error('alamat')
        <p id="alamat-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
    @enderror
</div>
