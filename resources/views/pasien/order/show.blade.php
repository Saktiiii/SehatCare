<form action="{{ route('pasien.checkout') }}" method="GET" class="mt-6">

    <input type="hidden" name="items[0][obat_id]" value="{{ $obat->id }}">
    <input type="hidden" name="items[0][nama]" value="{{ $obat->nama_obat }}">
    <input type="hidden" name="items[0][harga]" value="{{ $obat->harga }}">

    <label class="form-label">Jumlah</label>
    <input type="number"
           name="items[0][qty]"
           min="1"
           max="{{ $obat->stok }}"
           value="1"
           class="input w-32 border mt-2"
           required>

    <button type="submit"
            class="button bg-theme-1 text-white mt-4">
        Pesan Obat
    </button>
</form>
