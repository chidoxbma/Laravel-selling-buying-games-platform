<!DOCTYPE html>
<html>
<head>
    <title>Add New Game</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .back-link { display: block; margin: 20px 0; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Add New Game</h1>
    
    <a href="/" class="back-link">← Back to Games</a>
    
    <form action="/store-jeu" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="nom">Game Name:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="categorie">Category:</label>
            <select id="categorie" name="categorie">
                <option value="">Select Category (Optional)</option>
                @foreach($categories as $category)
                    <option value="{{ $category->nom }}">{{ $category->nom }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="date_sortie">Release Date:</label>
            <input type="date" id="date_sortie" name="date_sortie" required>
        </div>
        
        <div class="form-group">
            <label for="prix">Price:</label>
            <input type="number" id="prix" name="prix" step="0.01" min="0" required>
        </div>
        
        <div class="form-group">
            <label for="plateforme_id">Platform:</label>
            <select id="plateforme_id" name="plateforme_id" required>
                <option value="">Select Platform</option>
                @foreach($plateformes as $plateforme)
                    <option value="{{ $plateforme->id }}">{{ $plateforme->nom }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Game Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <small style="color: #666;">Upload game image (JPG, PNG, GIF)</small>
        </div>
        
        <button type="submit">Add Game</button>
    </form>
</body>
</html>
