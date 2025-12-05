<nav class="bg-white shadow-md w-full py-3 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3 justify-between items-center px-4">

        {{-- LEFT: Title --}}
        <div class="flex items-center gap-4">
            <h1 class="text-xl font-bold text-gray-700">
                Pemantauan Suhu Gudang Berpendingin
            </h1>

            <select
                id="plantSelect"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                @foreach($plants as $plant)
                <option value="{{ $plant->id }}" {{ session('selected_plant') == $plant->id ? 'selected' : '' }}>
                    Cabang {{ $plant->name }}
                </option>
                @endforeach
                <option value="all" {{ session('selected_plant') == 'all' ? 'selected' : '' }}>Semua Cabang</option>
            </select>
        </div>

        {{-- RIGHT: Navigation --}}
        <div class="flex gap-2 items-center flex-wrap">

            {{-- Menu Buttons --}}
            <a href="{{ route('dashboard.page') }}"
                class="px-4 py-2 text-sm font-semibold border rounded-md hover:bg-blue-50">
                🏠 Dashboard
            </a>

            <a href="{{ route('input.index') }}"
                class="px-4 py-2 text-sm font-semibold border rounded-md hover:bg-blue-50">
                📝 Input Data
            </a>

            <a href="{{ route('warehouse.recap') }}"
                class="px-4 py-2 text-sm font-semibold border rounded-md hover:bg-blue-50">
                📦 Rekap Gudang
            </a>

            <a href="{{ route('shipment.recap') }}"
                class="px-4 py-2 text-sm font-semibold border rounded-md hover:bg-blue-50">
                🚚 Rekap Pengiriman
            </a>

            {{-- Dropdown Database --}}
            <div class="relative">
                <button onclick="toggleDropdown()"
                    class="px-4 py-2 text-sm font-semibold border rounded-md hover:bg-blue-50">
                    🗄️ Database ▼
                </button>

                <div id="dropdownMenu" class="absolute hidden bg-white border rounded-md shadow-lg mt-1 w-44">
                    <a href="{{ route('warehouses.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                        📦 Database Gudang
                    </a>
                    <a href="{{ route('expeditions.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                        🚚 Database Ekspedisi
                    </a>
                    <a href="{{ route('employees.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                        👤 Database Karyawan
                    </a>
                    <a href="{{ route('plants.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                        🏢 Database Cabang
                    </a>
                    <a href="{{ route('departments.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                        🏢 Database Departemen
                    </a>
                </div>
            </div>


            {{-- Logout Button --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-md">
                    🚪 Logout
                </button>
            </form>

        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    }

    // Klik luar → dropdown menutup
    window.addEventListener('click', function(e) {
        const button = document.querySelector('[onclick="toggleDropdown()"]');
        const menu = document.getElementById('dropdownMenu');

        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>