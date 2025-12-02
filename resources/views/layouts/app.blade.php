<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pemantauan Suhu Gudang Berpendingin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    * {
        box-sizing: border-box;
    }

    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .nav-button {
        transition: all 0.2s;
    }

    .nav-button:hover {
        transform: translateY(-1px);
    }

    .nav-button.active {
        transform: scale(0.98);
    }

    .input-field {
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-field:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .data-row {
        transition: background-color 0.2s;
    }

    .data-row:hover {
        background-color: #f9fafb;
    }

    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .toast.success {
        background-color: #10b981;
        color: white;
    }

    .toast.error {
        background-color: #ef4444;
        color: white;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        z-index: 100;
        margin-top: 4px;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-item {
        padding: 12px 16px;
        cursor: pointer;
        transition: background-color 0.2s;
        border-radius: 6px;
        margin: 4px;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background-color: white;
        border-radius: 12px;
        max-width: 500px;
        width: 90%;
        max-height: 90%;
        overflow-y: auto;
    }
    </style>
    <style>
    @view-transition {
        navigation: auto;
    }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    {{-- Topbar --}}
    @include('partials.topbar')

    <main class="py-6">
        @yield('content')
    </main>

</body>

</html>