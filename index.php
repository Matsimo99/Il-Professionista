<?php
// Parametri di connessione al database PostgreSQL di Render
$host = 'dpg-curf2orv2p9s73ahh69g-a.oregon-postgres.render.com';
$port = '5432';  // La porta di default di PostgreSQL
$dbname = 'profslq';  // Il nome del database
$user = 'profslq_user';  // Nome utente del database
$password = 'MyafAY0wufx7p2gqyiqevR7EddKmxBMu';  // La password del database

// Connessione al database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Errore nella connessione al database.";
    exit;
}

// Ottieni i professionisti dalla tabella persone
$query = "SELECT * FROM persone"; // Recupera tutti i professionisti
$result_professionisti = pg_query($conn, $query);

if (!$result_professionisti) {
    echo "Errore nella query: " . pg_last_error($conn);
    exit;
}

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
            <!-- Icona hamburger per dispositivi mobili -->
            <div class="hamburger" id="hamburger-icon">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <!-- Menu di navigazione -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>

            <!-- Menu a tendina per dispositivi mobili -->
            <ul class="navbar-links-mobile" id="navbar-mobile">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi_siamo.php">Chi Siamo</a></li>
                <li><a href="trattamento_dati.php">Trattamento dei Dati</a></li>
                <li><a href="lavora_con_noi.php">Lavora con noi</a></li>
            </ul>
        </nav>
    </header>

    <script>
        // Funzione per mostrare/nascondere il menu a tendina
        const hamburgerIcon = document.getElementById("hamburger-icon");
        const navbarMobile = document.getElementById("navbar-mobile");

        hamburgerIcon.addEventListener("click", () => {
            navbarMobile.classList.toggle("active");
        });
    </script>

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

    <section class="comments-list">
    <?php
    // Recuperiamo i professionisti con valutazioni
    $query_professionisti = "
    SELECT p.id, p.nome, p.cognome, p.professione  -- Aggiungi la professione
    FROM persone p
    WHERE EXISTS (
        SELECT 1 FROM valutazioni v WHERE v.professionista_id = p.id
    )
    ORDER BY p.id DESC
    LIMIT 6;
    ";
    $result_professionisti = pg_query($conn, $query_professionisti);

    while ($row_professionista = pg_fetch_assoc($result_professionisti)) {
        $professionista_id = $row_professionista['id'];
        $nome_professionista = $row_professionista['nome'] . ' ' . $row_professionista['cognome'];
        $professione = $row_professionista['professione'];  // Aggiungi professione

        // Query per recuperare la media delle valutazioni
        $query_valutazioni_media = "
        SELECT AVG(v.valutazione) AS media_valutazione
        FROM valutazioni v
        WHERE v.professionista_id = $1
        ";
        $result_valutazioni_media = pg_query_params($conn, $query_valutazioni_media, array($professionista_id));

        // Verifica se ci sono valutazioni per il professionista
        if ($result_valutazioni_media && pg_num_rows($result_valutazioni_media) > 0) {
            $media_valutazione = pg_fetch_assoc($result_valutazioni_media)['media_valutazione'];
            $stelle = round($media_valutazione);  // Arrotonda al numero intero più vicino
            if ($stelle < 1) $stelle = 1;  // Assicurati che la valutazione non scenda sotto 1
            if ($stelle > 5) $stelle = 5;  // Assicurati che la valutazione non superi 5

            echo "<div class='professionista-commenti'>";
            echo "<h4 class='comment-title'>$nome_professionista</h4>";

            // Aggiungi l'immagine del profilo
            $image_path = "profili/{$professionista_id}.jpg";
            if (file_exists($image_path)) {
                echo "<img src='$image_path' alt='Immagine di $nome_professionista' class='comment-img'>";
            } else {
                echo "<img src='profili/default.jpg' alt='Immagine di default' class='comment-img'>";
            }

            // Visualizza la professione
            if (!empty($professione)) {
                echo "<p class='professione'>$professione</p>";  // Mostra la professione
            }

            // Stelle di valutazione
            echo "<div class='stelle-valutazione'>";
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $stelle) {
                    // Stelle piene
                    echo "<label class='full' for='star$i'>&#9733;</label>"; // Stella gialla
                }
            }
            echo "</div>"; // Fine delle stelle

            // Query per recuperare tutte le recensioni
            $query_valutazioni = "
            SELECT v.punteggio, v.data
            FROM valutazioni v
            WHERE v.professionista_id = $1
            ORDER BY v.data DESC
            ";
            $result_valutazioni = pg_query_params($conn, $query_valutazioni, array($professionista_id));

            // Visualizza le recensioni singole
            if ($result_valutazioni && pg_num_rows($result_valutazioni) > 0) {
                echo "<h5>Valutazioni:</h5>";
                while ($valutazione = pg_fetch_assoc($result_valutazioni)) {
                    echo "<div class='search-comment-box'>";
                    echo "<p><strong>Valutazione:</strong> " . htmlspecialchars($valutazione['punteggio']) . "/5</p>";
                    echo "<p><em>Data: " . htmlspecialchars($valutazione['data']) . "</em></p>";
                    echo "</div>";
                }
            }
            echo "</div>"; // Fine del professionista
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