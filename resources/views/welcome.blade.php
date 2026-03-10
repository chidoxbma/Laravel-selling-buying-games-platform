<!DOCTYPE html>
<html>
<head>
    <title>Games for Sale</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .game { border: 1px solid #ccc; margin: 10px; padding: 15px; border-radius: 5px; }
        .game h3 { margin: 0 0 10px 0; color: #333; }
        .game p { margin: 5px 0; color: #666; }
        .no-games { text-align: center; color: #999; }
    </style>
</head>
<body>
    <h1>Games for Sale</h1>
    
    <!-- Show different options based on user type -->
    @if(auth()->check())
        @if(auth()->user()->account_type == 'vendeur')
            <div style="margin: 20px 0;">
                <a href="/add-jeu" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Add New Game</a>
            </div>
            <p style="color: #666;">Welcome, {{ auth()->user()->name }}! You are a seller.</p>
        @elseif(auth()->user()->account_type == 'acheteur')
            <p style="color: #666;">Welcome, {{ auth()->user()->name }}! Browse games below to buy.</p>
        @endif
        
        <div style="margin: 20px 0;">
            <a href="/dashboard" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Dashboard</a>
            <form action="/logout" method="POST" style="display: inline; margin-left: 10px;">
                @csrf
                <button type="submit" style="background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Logout</button>
            </form>
        </div>
    @else
        <div style="margin: 20px 0;">
            <a href="/login" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login</a>
            <a href="/register" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;">Register</a>
        </div>
    @endif


    @if($jeux->count() > 0)
        @foreach($jeux as $jeu)
            <div class="game">
                <h3>{{ $jeu->nom }}</h3>
                @if($jeu->categorie)
                    <p><strong>Category:</strong> {{ $jeu->categorie }}</p>
                @endif
                <p><strong>Release Date:</strong> {{ $jeu->date_sortie }}</p>
                <p><strong>Price:</strong> ${{ number_format($jeu->prix, 2) }}</p>
                @if($jeu->description)
                    <p><strong>Description:</strong> {{ $jeu->description }}</p>
                @endif
                @if($jeu->plateforme)
                    <p><strong>Platform:</strong> {{ $jeu->plateforme->nom }}</p>
                @endif
                @if($jeu->image_url)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset($jeu->image_url) }}" alt="{{ $jeu->nom }}" style="max-width: 200px; max-height: 150px; border-radius: 4px; margin-top: 5px;">
                @endif
                
                <!-- Show contact button for acheteurs -->
                @if(auth()->check() && auth()->user()->account_type == 'acheteur')
                    <div style="margin-top: 15px;">
                        <button onclick="alert('Contact seller for: {{ $jeu->nom }}')" style="background: #28a745; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">Contact Seller</button>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-games">
            <h2>No games available</h2>
            <p>There are currently no games for sale.</p>
        </div>
    @endif
</body>
</html>