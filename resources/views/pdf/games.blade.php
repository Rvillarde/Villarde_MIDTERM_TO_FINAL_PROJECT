<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Games List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .stats {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
        }
        .stat-box {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title ?? 'Games List' }}</h1>
        <p>Generated on {{ date('F j, Y') }}</p>
    </div>

    @if(isset($stats))
    <div class="stats">
        @foreach($stats as $stat)
        <div class="stat-box">
            <div class="stat-number">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Release Year</th>
                <th>Category</th>
                @if(isset($showDeletedAt))
                <th>Deleted At</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
            <tr>
                <td>{{ $game->title }}</td>
                <td>{{ $game->description ?? 'N/A' }}</td>
                <td>{{ $game->release_year }}</td>
                <td>{{ $game->category->name ?? 'N/A' }}</td>
                @if(isset($showDeletedAt))
                <td>{{ $game->deleted_at ? $game->deleted_at->format('M j, Y') : 'N/A' }}</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ isset($showDeletedAt) ? 5 : 4 }}" style="text-align: center;">No games found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
