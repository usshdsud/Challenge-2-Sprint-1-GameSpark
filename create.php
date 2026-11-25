<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'header.php';?>

    <main class="main">
        <form action="" method="post" enctype="multipart/form-data">
        
        <label for="game_name">Game Naam:</label>
        <input type="text" name="game_name" placeholder="Game Naam">


        <label for="platform">Platform:</label>
        <select id="platform" name="platform">
            <option value="pc">PC</option>
            <option value="playstation">PlayStation</option>
            <option value="xbox">Xbox</option>
            <option value="nintendo">Nintendo</option>
        </select>


        <label for="genre">Genre:</label>
        <select id="genre" name="genre">
            <option value="action">Action</option>
            <option value="adventure">Adventure</option>
            <option value="rpg">RPG</option>
            <option value="strategy">Strategy</option>
            <option value="sports">Sports</option>
        </select>

        <label for="release_date">Release Datum:</label>
        <input type="date" id="release_date" name="release_date">

        <label for="rating">Beoordeling:</label>
        <input type="range" id="rating" name="rating" min="1" max="5" step="1">

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="wishlist">Wishlist</option>
            <option value="inbezit">In bezit</option>
            <option value="speeltnu">Speelt nu</option>
            <option value="uitgespeeld">Uitgespeeld</option>
        </select>

        <label for="afbeelding">Afbeelding:</label>
        <input type="file" id="afbeelding" name="afbeelding" accept="image/*">

        <label for="notitie">Notitie:</label>
        <textarea id="notitie" name="notitie" rows="3" maxlength="255"
                  placeholder="Korte notitie"></textarea>

        </textarea>

        <input type="submit" value="Toevoegen">
        </form>
    </main>

    <?php include 'footer.php';?>
</body>
</html>