<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa yang Dihapus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        aside {
            background-color: #f1f1f1;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        aside ul {
            list-style-type: none;
            padding: 0;
        }

        aside ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #4CAF50;
            color: white;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        button {
            padding: 8px 12px;
            font-size: 14px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
        }

        .delete-button:hover {
            background-color: #e53935;
        }

        .success-message {
            margin: 20px auto;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            text-align: center;
            width: 90%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Data Siswa yang Dihapus</h1>
    </header>

    <!-- Menampilkan pesan sukses jika ada -->
    @if (session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <aside>
        <!-- Menampilkan sidebar jika ada data -->
        @isset($sidebar_data)
            <h3>Data Terkait</h3>
            <ul>
                @foreach($sidebar_data as $data)
                    <li>{{ $data->name }}</li>
                @endforeach
            </ul>
        @endisset
    </aside>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Menampilkan data pengguna yang dihapus -->
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="actions">
                            <form action="{{ route('data-guru.restore', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit">Restore</button>
                            </form>
                            <form action="{{ route('data-guru.force-delete', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="delete-button">Hapus Permanen</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
