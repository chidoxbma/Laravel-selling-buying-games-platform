<!DOCTYPE html>
<html>
<head>
    <title>login</title>
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
    <h1>login</h1>
    
    <a href="/" class="back-link">← Back to Games</a>
    
    <form action="/store-jeu" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nom">Username:</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="password">Password :</label>
            <input type="text" id="password" name="password" required>
        </div>
        
      
        
        <button type="submit">Login</button>

    </form>
</body>
</html>
