<?php
// Connessione al database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Errore nella connessione al database.";
    exit;
}

// Recupero dei parametri dalla query string (GET), con default a null
$professione = isset($_GET['professione']) ? $_GET['professione'] : null;
$citta = isset($_GET['citta']) ? $_GET['citta'] : null;

// Codice per la ricerca, per esempio:
$query = "SELECT * FROM persone"; // Recupera tutti i professionisti
if ($professione) {
    $query .= " WHERE professione LIKE '%" . pg_escape_string($conn, $professione) . "%'";
}
if ($citta) {
    $query .= " AND citta LIKE '%" . pg_escape_string($conn, $citta) . "%'";
}
$result_professionisti = pg_query($conn, $query);

if (!$result_professionisti) {
    echo "Errore nella query: " . pg_last_error($conn);
    exit;
}

// Codice per elaborare i risultati della query (ad esempio, stampare i dati)
while ($row = pg_fetch_assoc($result_professionisti)) {
    echo "Nome: " . htmlspecialchars($row['nome']) . "<br>"; // Usiamo htmlspecialchars per prevenire XSS
    echo "Cognome: " . htmlspecialchars($row['cognome']) . "<br>"; // Usiamo htmlspecialchars per prevenire XSS
}

// Chiudi la connessione
pg_close($conn);
?>





<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home | Azienda Ricerca Professionisti</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Barra di navigazione fissa -->
    <header class="navbar">
        <div class="logo">
            <img src="logo1.jpg" alt="Logo Azienda" width="150" height="150">
        </div>
        <nav>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sezione di ricerca orizzontale -->
    <section class="search-section">
        <div class="search-container">
            <h1 class="section-title">Trova il tuo professionista</h1>
            <p class="subheading">Cerca tra i migliori professionisti per la tua esigenza</p>

            <!-- Modulo di ricerca orizzontale -->
            <form action="search.php" method="get" class="search-form" onsubmit="return validateForm()">
                <div class="input-group">
                    <label for="professione">Professione:</label>
                    <input type="text" id="professione" name="professione" placeholder="Es. Medico">
                </div>
                <div class="input-group">
                    <label for="citta">Città:</label>
                    <input type="text" id="citta" name="citta" placeholder="Es. Roma">
                </div>
                <button type="submit" class="btn-search">Cerca</button>
            </form>
        </div>
    </section>

    <!-- Sezione per i commenti professionisti -->
    <section class="comments-list">
        <?php
        // Recuperiamo e visualizziamo i commenti per ogni professionista
        while ($row_professionista = pg_fetch_assoc($result_professionisti)) {
            $professionista_id = $row_professionista['id'];
            $nome_professionista = $row_professionista['nome'] . ' ' . $row_professionista['cognome'];
            $query_commenti = "SELECT * FROM commenti WHERE professionista_id = $1 ORDER BY data DESC"; // Commenti per il professionista
            $result_commenti = pg_query_params($conn, $query_commenti, array($professionista_id));

            // Verifica se ci sono commenti per il professionista
            if ($result_commenti && pg_num_rows($result_commenti) > 0) {
                echo "<div class='professionista-commenti'>"; // Aggiungi una classe specifica
                echo "<h4 class='comment-title'>$nome_professionista</h4>"; // Modifica il titolo del professionista

                // Aggiungi l'immagine del profilo, caricato dalla cartella 'profili'
                $image_path = "profili/{$professionista_id}.jpg";
                if (file_exists($image_path)) {
                    echo "<img src='$image_path' alt='Immagine di $nome_professionista' class='comment-img'>";
                } else {
                    echo "<img src='profili/default.jpg' alt='Immagine di default' class='comment-img'>";
                }

                // Se ci sono commenti, visualizzali
                while ($commento = pg_fetch_assoc($result_commenti)) {
                    echo "<div class='search-comment-box'>"; // Classe aggiornata
                    echo "<p><strong>Commento:</strong> " . htmlspecialchars($commento['commento']) . "</p>";
                    echo "<p><em>Data: " . htmlspecialchars($commento['data']) . "</em></p>";
                    echo "</div>";
                }
                echo "</div>"; // Chiudi la sezione del professionista
            }
        }
        ?>
    </section>

    <footer>
        <div class="footer-container">
            <!-- Links principali -->
            <div class="footer-links">
                <ul>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Informativa Cookie</a></li>
                    <li><a href="#">Termini e Condizioni</a></li>
                    <li><a href="#">Contatti</a></li>
                    <li><a href="#">Help & Contatti</a></li>
                    <li><a href="#">Lavora con noi</a></li>
                    <li><a href="#">Diventa Professionista</a></li>
                    <li><a href="#">Domande Frequenti (FAQ)</a></li>
                </ul>
            </div>

            <div class="footer-social">
    <ul>
        <li>
            <a href="https://www.facebook.com/profile.php?id=61570141079818">
                <img src="fb.png" alt="Facebook" style="width: 30px; height: 30px;">
            </a>
        </li>
        <li>
            <a href="https://www.instagram.com/ilprofessionista2.0?igsh=d2swbGl0OWhoMXhs">
                <img src="in.webp" alt="Instagram" style="width: 30px; height: 30px;">
            </a>
        </li>
        <li>
            <a href="">
                <img src="what.png" alt="WhatsApp" style="width: 30px; height: 30px;">
            </a>
        </li>
    </ul>
</div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>&copy; 2025 Azienda Ricerca Professionisti - Tutti i diritti riservati</p>
            </div>
        </div>
    </footer>

    <!-- Validazione del form -->
    <script>
        // Funzione di validazione dei campi di ricerca
        function validateForm() {
            const professione = document.getElementById('professione').value.trim();
            const citta = document.getElementById('citta').value.trim();

            // Controlla se entrambi i campi sono vuoti
            if (!professione && !citta) {
                alert('Per favore, compila almeno uno dei campi (Professione o Città).');
                return false; // Impedisce l'invio del form
            }
            return true;
        }
    </script>
</body>

</html>
