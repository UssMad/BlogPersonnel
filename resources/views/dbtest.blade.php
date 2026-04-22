@php
    use Illuminate\Support\Facades\DB;

    try {
        DB::connection()->getPdo();
        $dbname = DB::connection()->getDatabaseName();
        $status = "Connected successfully to: " . $dbname;
        $color = "green";
    } catch (\Exception $e) {
        $status = "Connection failed: " . $e->getMessage();
        $color = "red";
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Test</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f9; }
        .card { padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .status { font-weight: bold; color: {{ $color }}; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Database Connection Test</h1>
        <p class="status">{{ $status }}</p>
    </div>
</body>
</html>